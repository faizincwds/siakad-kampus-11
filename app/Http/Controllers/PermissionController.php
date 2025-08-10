<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        \Gate::authorize('view permission');
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        \Gate::authorize('create permission');
        return view('admin.permissions.create');
    }

    public function manage(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode(' ', $perm->name)[0]; // Group by 'view', 'create', etc.
        });

        $selectedRole = null;

        if ($request->ajax()) {
            $role = Role::with('permissions')->where('id', $request->get('role_id'))->first();
            if (!$role) {
                return response()->json(['error' => 'Role not found'], 404);
            }

            return response()->json([
                'permissions' => $role->permissions->pluck('id')
            ]);
        }

        $selectedRole = Role::with('permissions')->where('id', $request->get('role_id'))->first() ?? Role::with('permissions')->first();

        return view('admin.permissions.manage', compact('roles', 'permissions', 'selectedRole'));
    }

    public function update_manage(Request $request)
    {
        \Gate::authorize('update manage');
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.permissions.manage', ['role_id' => $role->id])->with('success', 'Permission berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        \Gate::authorize('create permission');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cek = Permission::create($request->only('name', 'description'));
        // dd($cek);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission ditambahkan.');
    }

    public function show(Request $request)
    {
        // $this->manage();
    }
    public function edit(Permission $permission)
    {
        \Gate::authorize('edit permission');
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        // \Gate::authorize('edit permission');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission->update($request->only('name', 'description'));
        return redirect()->route('admin.permissions.index')->with('success', 'Permission diperbarui.');
    }

    public function destroy(Permission $permission)
    {
        \Gate::authorize('delete permission');
        $permission->delete();
        return back()->with('success', 'Permission dihapus.');
    }


}
