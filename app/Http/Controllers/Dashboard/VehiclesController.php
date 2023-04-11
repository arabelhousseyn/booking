<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehiclesController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with(['reviews', 'seller'])->paginate();

        return view('pages.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Vehicle $vehicle): View
    {
        $vehicle->load(['documents']);

        return view('pages.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('pages.vehicles.edit', compact('vehicle'));
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        //
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();

        return redirect()->route('dashboard.vehicles.index');
    }

    public function publish(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update(['status' => Status::PUBLISHED]);

        return redirect()->route('dashboard.vehicles.index');
    }

    public function decline(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update(['status' => Status::DECLINED]);

        return redirect()->route('dashboard.vehicles.index');
    }
}
