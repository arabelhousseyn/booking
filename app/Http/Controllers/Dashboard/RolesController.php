<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index(): View
    {
        $roles = Role::where('is_protected', '=', 0)->get();

        return view('pages.roles.index', compact('roles'));
    }


    public function create(): View
    {
        $permissions = Permission::all();

        return view('pages.roles.create', compact('permissions'));
    }


    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => $request->validated('name'),
            'guard_name' => 'admin',
        ]);

        foreach ($request->validated('permissions') as $permission) {
            $role->givePermissionTo($permission);
        }

        return response()->redirectTo('/dashboard/roles');
    }


    public function show(Role $role): View
    {
        $role->load(['permissions']);

        return view('pages.roles.show', compact('role'));
    }


    public function edit(Role $role): View
    {
        $permissions = Permission::all();

        $role->load(['permissions']);

        return view('pages.roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update(['name' => $request->validated('name')]);

        $role->syncPermissions($request->validated('permissions'));

        return response()->redirectTo('/dashboard/roles');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return response()->redirectTo('/dashboard/roles');
    }
}
