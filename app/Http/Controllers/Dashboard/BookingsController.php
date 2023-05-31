<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\BookingStatus;
use App\Enums\ModelType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\SetRefundRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\House;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

    public function show(Booking $booking): View
    {
        return view('pages.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        $properties = [];

        if ($booking->bookable_type == ModelType::VEHICLE) {
            $properties = Vehicle::where('status', '=', Status::PUBLISHED)->with('seller')->get();
        } elseif ($booking->bookable_type == ModelType::HOUSE) {
            $properties = House::where('status', '=', Status::PUBLISHED)->with('seller')->get();
        }

        return view('pages.bookings.edit', compact('booking', 'properties'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $status = ['status' => BookingStatus::ACCEPTED];

        $booking->update(array_merge($request->validated(), $status));

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.bookings.index');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.bookings.index');
    }

    public function accept(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => BookingStatus::ACCEPTED]);

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.bookings.index');
    }

    public function decline(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => BookingStatus::DECLINED]);

        Session::put('created', 'Opération effectué');

        return redirect()->route('dashboard.bookings.index');
    }

    public function bookingState(Booking $booking): View
    {
        return view('pages.bookings.state', compact('booking'));
    }

    public function viewRefund(Booking $booking)
    {
        return view('pages.bookings.refund', compact('booking'));
    }

    public function setRefund(SetRefundRequest $request, Booking $booking): RedirectResponse
    {
        // todo implement the refund api
        $booking->update($request->validated());

        return redirect()->route('dashboard.bookings.index');
    }
}
