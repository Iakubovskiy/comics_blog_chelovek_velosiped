<?php
namespace App\Http\Controllers\API;

use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function __construct(protected RoleService $roleService){}

    public function getAllRoles()
    {
        try {
            $roles = $this->roleService->getAllRoles();
            return $this->sendResponse($roles, 'Roles retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve Roles', ['error' => $e->getMessage()]);
        }
    }

    public function getRoleById(int $id)
    {
        try {
            $role = $this->roleService->getRoleById($id);
            return $this->sendResponse($role, 'Role retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve Role', ['error' => $e->getMessage()]);
        }
    }

    public function createRole(Request $request)
    {
        try {
            $roleData = [                
                'name' => $request->input('name'),
            ];

            $role = $this->roleService->createRole($roleData);
            return $this->sendResponse($role, 'Role created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create Role', ['error' => $e->getMessage()]);
        }
    }

    public function updateRole(Request $request, int $id)
    {
        try {
            $roleData = [
                'name'=> $request->input('name'),
            ];

            $Role = $this->roleService->updateRole($id, $roleData);
            return $this->sendResponse($Role, 'Role updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update Role', ['error' => $e->getMessage()]);
        }
    }

    public function deleteRole(int $id)
    {
        try {
            $this->roleService->deleteRole($id);
            return $this->sendResponse(null, 'Role deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete Role', ['error' => $e->getMessage()]);
        }
    } 
}
