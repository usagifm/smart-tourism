<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\Request;

class ManageAdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('permissions')->get();

        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        $permissions = Permission::all()->pluck('name', 'id');

        return view('admin.create', compact('permissions'));
    }

    public function store(AdminStoreRequest $adminStoreRequest)
    {
        $admin = Admin::create(array_merge($adminStoreRequest->validated(), [
            'password' => bcrypt($adminStoreRequest->password)
        ]));

        $admin->permissions()->sync($adminStoreRequest->input('permissions', []));

        return redirect()->route('admin.index');
    }

    public function edit(Admin $admin)
    {
        $permissions = Permission::all()->pluck('name', 'id');

        return view('admin.edit', compact('admin', 'permissions'));
    }

    public function update(AdminUpdateRequest $adminUpdateRequest, Admin $admin)
    {
        $admin->update(array_merge($adminUpdateRequest->validated(), [
            'password' => $adminUpdateRequest->filled('password') ? bcrypt($adminUpdateRequest->password) : $admin->password
        ]));

        $admin->permissions()->sync($adminUpdateRequest->input('permissions', []));

        return redirect()->route('admin.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index');
    }
}
