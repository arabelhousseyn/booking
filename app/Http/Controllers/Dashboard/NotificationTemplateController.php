<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotificationRequest;
use App\Support\RecipientNotificationDispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class NotificationTemplateController extends Controller
{
    public function index(): View
    {
        return view('pages.notificationTemplate.index');
    }

    public function push(PushNotificationRequest $request): RedirectResponse
    {
        (new RecipientNotificationDispatcher($request->validated('title'), $request->validated('body'), $request->validated('to'), []))->send();

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.notificationTemplate.index');
    }
}
