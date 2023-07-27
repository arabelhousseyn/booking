<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdController extends Controller
{
    public function index(): View
    {
        $ads = Ad::all();

        return view('pages.ads.index', compact('ads'));
    }

    public function create(): View
    {
        return view('pages.ads.create');
    }

    public function store(AdRequest $request): RedirectResponse
    {
        $photos = $request->validated('photos');

        foreach ($photos as $photo) {
            $ad = Ad::create();
            $ad->addMedia($photo)->toMediaCollection('ads');
        }

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.ads.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.ads.index');
    }
}
