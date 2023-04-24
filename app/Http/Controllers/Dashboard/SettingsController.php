<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoreRequest;
use App\Models\Core;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function general(): View
    {
        $core = Core::first();

        return view('pages.general.index', compact('core'));
    }

    public function updateCore(CoreRequest $request): RedirectResponse
    {
        $core = Core::first();

        $data = [];

        if ($request->has('commission')) {
            $data = [
                'commission_updated_by' => auth()->id(),
            ];
        }

        $core->update(array_merge($data, $request->validated()));

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.settings.general');
    }
}
