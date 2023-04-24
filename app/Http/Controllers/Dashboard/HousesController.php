<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\HouseRequest;
use App\Models\House;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class HousesController extends Controller
{
    public function index(): View
    {
        $houses = House::with(['seller', 'reviews'])->paginate();

        return view('pages.houses.index', compact('houses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(House $house)
    {
        return view('pages.houses.edit', compact('house'));
    }

    public function update(HouseRequest $request, House $house): RedirectResponse
    {
        $house->update($request->validated());

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.houses.index');
    }

    public function destroy(House $house): RedirectResponse
    {
        $house->delete();

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.houses.index');
    }

    public function publish(House $house): RedirectResponse
    {
        $house->update(['status' => Status::PUBLISHED]);

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.houses.index');
    }

    public function decline(House $house): RedirectResponse
    {
        $house->update(['status' => Status::DECLINED]);

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.houses.index');
    }
}
