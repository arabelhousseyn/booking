<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserHandleDocumentRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest('created_at')->with('validatedBy')->paginate();

        return view('pages.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('pages.users.create');
    }


    public function store(UserRequest $request): RedirectResponse
    {
        $data = ['password' => Hash::make($request->validated('password')), 'email_verified_at' => now(), 'phone_verified_at' => now()];

        $user = User::create(array_merge($data, $request->safe()->except('password')));

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.users.index');
    }

    public function show(User $user): View
    {
        $user->load(['documents']);

        return view('pages.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.users.index');
    }

    public function document(UserHandleDocumentRequest $request, User $user, UserDocument $document): RedirectResponse
    {
        $document->update($request->validated());

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.users.index');
    }

    public function validation(User $user): RedirectResponse
    {
        $user->update(['validated_at' => Carbon::now(),'validated_by' => auth()->id()]);

        Session::put('created','Opération effectué');

        return redirect()->route('dashboard.users.index');
    }
}
