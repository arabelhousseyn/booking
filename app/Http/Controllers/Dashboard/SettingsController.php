<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoreRequest;
use App\Models\Core;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function general(): View
    {
        $core = Core::first();

        return view('pages.general.index', compact('core'));
    }

    public function updateCore(CoreRequest $request): Response
    {
        $core = Core::first();

        $data = [];

        if ($request->has('commission')) {
            $data = [
                'commission_updated_by' => auth()->id(),
            ];
        }

        $core->update(array_merge($data, $request->validated()));

        return response()->noContent();
    }
}
