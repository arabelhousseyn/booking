<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponsController extends Controller
{
    public function index(): View
    {
        $coupons = Coupon::all();

        return view('pages.coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('pages.coupons.create');
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        $coupon = Coupon::create($request->validated());

        return response()->redirectTo('/dashboard/coupons');
    }

    public function show($id)
    {
        //
    }

    public function edit(Coupon $coupon)
    {
        return view('pages.coupons.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $coupon->update($request->validated());

        return response()->redirectTo('/dashboard/coupons');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return response()->redirectTo('/dashboard/coupons');
    }
}
