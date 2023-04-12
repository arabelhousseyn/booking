<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(): View
    {
        $admins = Admin::latest('created_at')->whereNot('id',auth()->id())->with('roles')->paginate();
        return view('pages.admins.index', compact('admins'));
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('pages.admins.create', compact('roles'));
    }

    public function store(AdminRequest $request): RedirectResponse
    {
        $password = ['password' => Hash::make($request->validated('password'))];

        $admin = Admin::create(array_merge($password, $request->safe()->only(['full_name', 'email'])));

        $admin->assignRole($request->validated('role'));

        return response()->redirectTo('/dashboard/admins');
    }

    public function show(Admin $admin)
    {
        //
    }

    public function edit(Admin $admin): View
    {
        $roles = Role::all();
        return view('pages.admins.edit',compact('admin',['roles']));
    }

    public function update(AdminRequest $request, Admin $admin) : RedirectResponse
    {
        $admin->update($request->safe()->only(['full_name','email']));

        $admin->syncRoles($request->validated('role'));

        return response()->redirectTo('/dashboard/admins');
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        $admin->delete();

        return response()->redirectTo('/dashboard/admins');
    }
}
