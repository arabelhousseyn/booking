<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SellerController extends Controller
{

    public function index(): View
    {
        $sellers = Seller::latest('created_at')->paginate();

        return view('pages.sellers.index', compact('sellers'));
    }


    public function create(): View
    {
        return view('pages.sellers.create');
    }


    public function store(SellerRequest $request): RedirectResponse
    {
        $data = ['password' => Hash::make($request->validated('password')), 'email_verified_at' => now(), 'phone_verified_at' => now()];

        $seller = Seller::create(array_merge($data, $request->safe()->except('password')));

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.sellers.index');
    }

    public function show($id)
    {
        //
    }


    public function edit(Seller $seller): View
    {
        return view('pages.sellers.edit', compact('seller'));
    }


    public function update(SellerRequest $request, Seller $seller): RedirectResponse
    {
        $seller->update($request->validated());

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.sellers.index');
    }


    public function destroy(Seller $seller): RedirectResponse
    {
        $seller->delete();

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.sellers.index');
    }
}
