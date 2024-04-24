<?php

namespace App\Http\Controllers;

use App\Models\CredentialForServer;
use App\Models\CredentialForUser;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function deleteCredential(Request $request)
    {
        return $this->deleteData($request, CredentialForServer::class);
    }

    public function deleteCredentialForUserData(Request $request)
    {
        return $this->deleteData($request, CredentialForUser::class);
    }

    public function deleteUserData(Request $request)
    {
        return $this->deleteData($request, User::class);
    }

    public function deleteMenuData(Request $request)
    {
        return $this->deleteData($request, Menu::class);
    }

    public function deleteRoleData(Request $request)
    {
        return $this->deleteData($request, Role::class);
    }

    public function deletePermissionData(Request $request)
    {
        return $this->deleteData($request, Permission::class);
    }

    public function deleteData(Request $request, $model)
    {
        $id = $request->input('id');
        $menu_id = $request->input('menuId');
        $userId = Auth::id();

        // Retrieve the user's role ID from the user_role pivot table
        $userRole = UserRole::where('user_id', $userId)->first();

        if (!$userRole) {
            return response()->json(['success' => false, 'message' => 'User role not found']);
        }

        $roleId = $userRole->role_id;

        // Check if the user's role has the 'delete' permission for the specified module
        $permissions = Permission::where('role_id', $roleId)
            ->where('menu_id', $menu_id)
            ->first();

        if ($permissions && $permissions->delete === 'yes') {
            // User has permission, proceed with deletion
            $record = $model::find($id);
            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }

            $record->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully']);
        } else {
            // Permission denied
            return response()->json(['success' => false, 'message' => 'Permission denied']);
        }
    }
}
