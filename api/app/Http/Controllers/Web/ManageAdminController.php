<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ManageAdminController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admins = Admin::with('permissions')->get();

        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        abort_if(Gate::denies('manage_admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('manage_admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('manage_admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();

        return redirect()->route('admin.index');
    }
}
