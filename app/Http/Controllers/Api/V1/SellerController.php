<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\FileUploadedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleDocumentsRequest;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Seller;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SellerController extends Controller
{
    public function storeVehicle(StoreVehicleRequest $request, Seller $seller): VehicleResource
    {
        $vehicle = $seller->vehicles()->create($request->validated());

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

    public function vehicles(Seller $seller): JsonResource
    {
        $vehicles = $seller->vehicles;

        return VehicleResource::collection($vehicles);
    }
}
