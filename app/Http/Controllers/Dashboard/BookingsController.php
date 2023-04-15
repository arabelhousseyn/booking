<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingsController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['bookable', 'user', 'seller'])->paginate();

        return view('pages.bookings.index', compact('bookings'));
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Booking $booking)
    {
        //
    }

    public function accept(Booking $booking)
    {

    }

    public function decline(Booking $booking)
    {

    }
}
