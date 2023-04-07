<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReasonRequest;
use App\Models\Reason;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReasonsController extends Controller
{
    public function index(): View
    {
        $reasons = Reason::latest('created_at')->get();

        return view('pages.reasons.index', compact('reasons'));
    }


    public function create(): View
    {
        return view('pages.reasons.create');
    }

    public function store(ReasonRequest $request): RedirectResponse
    {
        $reason = Reason::create($request->validated());

        return response()->redirectTo('/dashboard/reasons');
    }

    public function show($id)
    {
        //
    }

    public function edit(Reason $reason)
    {
        return view('pages.reasons.edit', compact('reason'));
    }

    public function update(ReasonRequest $request, Reason $reason): RedirectResponse
    {
        $reason->update($request->validated());

        return response()->redirectTo('/dashboard/reasons');
    }

    public function destroy(Reason $reason): RedirectResponse
    {
        $reason->delete();

        return response()->redirectTo('/dashboard/reasons');
    }
}
