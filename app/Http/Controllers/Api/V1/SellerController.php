<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\FileUploadedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerUpdateProfileRequest;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\StoreVehicleDocumentsRequest;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\HouseResource;
use App\Http\Resources\VehicleResource;
use App\Models\Seller;
use App\Models\Vehicle;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SellerController extends Controller
{
    use PasswordCanBeUpdated;

    public function storeVehicle(StoreVehicleRequest $request): VehicleResource
    {
        // todo : add authorization here for seller can rent vehicle
        $vehicle = auth()->user()->vehicles()->create($request->validated());

        $vehicle->addMultipleMediaFromRequest(['photos'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('photos');
            });

        return VehicleResource::make($vehicle);
    }

    public function storeVehicleDocuments(StoreVehicleDocumentsRequest $request, Seller $seller, Vehicle $vehicle): Response
    {
        $documents = $request->validated('documents');

        try {
            foreach ($documents as $document) {
                $unique = uniqid().'.jpg';
                $document['document_image']->storeAs('public/documents', $unique);
                $image = env('APP_URL').'/storage/documents/'.$unique;
                $vehicle->documents()->create(['document_type' => $document['document_type'], 'document_url' => $image, 'expiry_date' => $document['expiry_date']]);
            }
        } catch (\Exception $exception) {
            throw new FileUploadedException();
        }

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
                $fileAdder->toMediaCollection('photos');
            });

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
}
