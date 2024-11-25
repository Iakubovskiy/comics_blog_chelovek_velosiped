<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $result = $this->roleService->createRole($data);

        if ($result) {
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
        }

        return back()->with('error', 'Error creating role');
    }

    public function edit($id)
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return redirect()->route('admin.roles.index')->with('error', 'Role not found');
        }

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $result = $this->roleService->updateRole($id, $data);

        if ($result) {
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
        }

        return back()->with('error', 'Error updating role');
    }

    public function delete($id)
    {
        $result = $this->roleService->deleteRole($id);

        if ($result) {
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
        }

        return back()->with('error', 'Error deleting role');
    }
}
