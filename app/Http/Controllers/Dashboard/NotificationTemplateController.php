<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushNotificationRequest;
use App\Support\RecipientNotificationDispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        return view('pages.notificationTemplate.index');
    }

    public function push(PushNotificationRequest $request): Response
    {
        (new RecipientNotificationDispatcher($request->validated('title'), $request->validated('body'), $request->validated('to'), []))->send();

        return response()->noContent();
    }
}
