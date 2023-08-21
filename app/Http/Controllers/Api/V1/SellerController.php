<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BookingStatus;
use App\Enums\Status;
use App\Events\BookingTerminated;
use App\Exceptions\FileUploadedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerUpdateProfileRequest;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\StoreVehicleDocumentsRequest;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\TerminateBookingRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\BookingListResource;
use App\Http\Resources\BookingResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\SellerResource;
use App\Http\Resources\VehicleResource;
use App\Models\Booking;
use App\Models\House;
use App\Models\Seller;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SellerController extends Controller
{
    use PasswordCanBeUpdated;

    public function storeVehicle(StoreVehicleRequest $request): VehicleResource
    {
        $vehicle = auth()->user()->vehicles()->create($request->validated());

        $vehicle->addMultipleMediaFromRequest(['photos'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('vehicle');
            });

        return VehicleResource::make($vehicle);
    }

    public function updateVehicle(UpdateVehicleRequest $request, Vehicle $vehicle): VehicleResource
    {
        $this->authorize('update', $vehicle);

        $vehicle->update($request->validated());

        if ($request->validated('photos')) {
            $vehicle->addMultipleMediaFromRequest(['photos'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('vehicle');
                });
        }

        return VehicleResource::make($vehicle);
    }

    public function storeVehicleDocuments(StoreVehicleDocumentsRequest $request, Seller $seller, Vehicle $vehicle): Response
    {
        $documents = $request->validated('documents');

        try {
            foreach ($documents as $document) {
                $unique = uniqid().'.jpg';
                $document['document_image']->storeAs('public/documents', $unique);
                $image = config('app.url').'/storage/documents/'.$unique;
                $vehicle->documents()->create(['document_type' => $document['document_type'], 'document_url' => $image, 'expiry_date' => $document['expiry_date']]);
            }
        } catch (\Exception $exception) {
            throw new FileUploadedException();
        }

        return response()->noContent();
    }

    public function destroyVehicleDocument(Vehicle $vehicle, VehicleDocument $vehicleDocument): Response
    {
        if ($vehicle->getKey() != $vehicleDocument->vehicle_id) {
            abort(403);
        }

        $this->authorize('update', $vehicle);

        $vehicleDocument->delete();

        return response()->noContent();
    }

    public function vehicles(): JsonResource
    {
        $vehicles = auth()->user()->vehicles()->get();

        return VehicleResource::collection($vehicles);
    }

    public function storeHouse(StoreHouseRequest $request): HouseResource
    {
        $house = auth()->user()->houses()->create($request->validated());

        $house->addMultipleMediaFromRequest(['photos'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('house');
            });

        return HouseResource::make($house);
    }

    public function updateHouse(UpdateHouseRequest $request, House $house): HouseResource
    {
        $this->authorize('update', $house);

        $house->update($request->validated());

        if ($request->validated('photos')) {
            $house->addMultipleMediaFromRequest(['photos'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('house');
                });
        }

        return HouseResource::make($house);
    }

    public function houses(): JsonResource
    {
        $houses = auth()->user()->houses()->get();

        return HouseResource::collection($houses);
    }

    public function updateProfile(SellerUpdateProfileRequest $request): Response
    {
        auth()->user()->update($request->validated());

        if ($request->hasFile('avatar')) {
            auth()->user()->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return response()->noContent();
    }

    public function profile(): SellerResource
    {
        $user = auth()->user();

        return SellerResource::make($user);
    }

    public function bookings(): JsonResource
    {
        $bookings = auth()->user()->bookings()->get();

        $bookings->loadMissing(['bookable']);

        return BookingListResource::collection($bookings);
    }

    public function viewBooking(Booking $booking): BookingResource
    {
        $this->authorize('view', [$booking, auth()->user()]);

        $booking->load(['bookable']);

        return BookingResource::make($booking, [], []);
    }

    public function terminateBooking(TerminateBookingRequest $request, Booking $booking): Response
    {
        $this->authorize('view', [$booking, auth()->user()]);

        $booking->update(['note' => $request->validated('note'), 'status' => BookingStatus::COMPLETED]);

        $bookable = Relation::$morphMap[$booking->bookable_type->value]::find($booking->bookable_id);

        $bookable->update(['status' => Status::PUBLISHED]);

        if (filled($request->validated('images'))) {
            $booking->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('reclamations');
                });
        }

        event(new BookingTerminated($booking->toArray()));

        return response()->noContent();
    }
}
