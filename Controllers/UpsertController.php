<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\CredentialForUser;
use App\Models\CredentialForServer;
use App\Models\AdditionalInformation;
use App\Models\UserRole;
use App\Models\Permission;


class UpsertController extends Controller
{

    public function upsertMenu(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:menus,name,' . $request->input('menuId'),
                'link' => 'required|string|max:255|unique:menus,link,' . $request->input('menuId'),
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            }

            $id = $request->input('menuId');

            if (empty($id)) {
                // Insertion
                $menu = new Menu();
                $rolePermission = new Permission();
                $menu->name = $request->name;
                $menu->link = $request->link;
                $menu->save();

                $menuId = $menu->id;
                $rolePermission->role_id = 1;
                $rolePermission->menu_id = $menuId;
                $rolePermission->read = 'yes';
                $rolePermission->create = 'yes';
                $rolePermission->edit = 'yes';
                $rolePermission->delete = 'yes';

                // Save the role permission
                $rolePermission->save();
            } else {
                // Update
                $menu = Menu::find($id);
                if (!$menu) {
                    return response()->json(['success' => false, 'message' => 'Id in Menu table not found']);
                }

                $menu->name = $request->name;
                $menu->link = $request->link;
                $menu->save();
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Menu ' . ($id ? 'updated' : 'added') . ' successfully']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function upsertRole(Request $request)
    {
        try {
            // Retrieve the id from the request
            $id = $request->input('roleId');
            $validator = Validator::make($request->all(), [
                'role' => 'required|string|max:255|unique:roles,role,' . $id,
                'description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            }

            if (empty($id)) {
                // Insertion
                $role = new Role();
                $role->role = $request->role;
                $role->description = $request->description;
                $roleResult = $role->save();

                // Return response for insertion
                if ($roleResult) {
                    return response()->json(['success' => true, 'message' => 'Role added successfully.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to add role.']);
                }
            } else {
                // Update
                $role = Role::find($id);
                $role->role = $request->role;
                $role->description = $request->description;
                $roleResult = $role->save();

                // Return response for update
                if ($roleResult) {
                    return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to update role.']);
                }
            }
        } catch (Exception $e) {
            // Handle the exception
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function insertPermission(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer',
                'menu' => 'required|string',
                'read' => 'nullable|string',
                'create' => 'nullable|string',
                'edit' => 'nullable|string',
                'delete' => 'nullable|string',
                'permissionId' => 'nullable|integer', // Add validation for permissionId
            ]);

            $validator->after(function ($validator) use ($request) {
                $roleId = $request->input('role_id');
                $menuId = $request->input('menu');
                $permissionId = $request->input('permissionId');

                // Build the unique rule with the ignore parameter if permissionId exists
                $uniqueRule = Rule::unique('permissions')->where(function ($query) use ($roleId, $menuId) {
                    $query->where('role_id', $roleId)->where('menu_id', $menuId);
                });

                if ($permissionId) {
                    $uniqueRule->ignore($permissionId);
                }

                // Apply the unique rule to check composite uniqueness
                $validator->addRules(['role_id' => $uniqueRule]);
            });

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            }

            $id = $request->input('permissionId');

            if (empty($id)) {
                // Insertion
                $rolePermission = new Permission();
            } else {
                // Update
                $rolePermission = Permission::find($id);
                if (!$rolePermission) {
                    return response()->json(['success' => false, 'message' => 'Role permission not found']);
                }
            }

            // Update the role permission attributes
            $rolePermission->role_id = $request->input('role_id');
            $rolePermission->menu_id = $request->input('menu');
            $rolePermission->read = $request->input('read') ?? 'no';
            $rolePermission->create = $request->input('create') ?? 'no';
            $rolePermission->edit = $request->input('edit') ?? 'no';
            $rolePermission->delete = $request->input('delete') ?? 'no';

            // Save the role permission to the database
            if ($rolePermission->save()) {
                return response()->json(['success' => true, 'message' => 'Permission added successfully']);
            } else {
                // Permission denied
                return response()->json(['success' => false, 'message' => 'Failed to add permission']);
            }
        } catch (Exception $e) {
            // Handle the exception
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function checkPermission(Request $request)
    {
        $menuId = $request->input('menuId');
        $action = $request->input('action');
        $userId = Auth::id();


        // Retrieve the user's role ID from the user_role pivot table
        $userRole = UserRole::where('user_id', $userId)->first();

        if (!$userRole) {
            return response()->json(['success' => false, 'message' => 'User role not found']);
        }

        $roleId = $userRole->role_id;

        // Check if the user's role has the specified permission for the specified module
        $permissions = Permission::where('role_id', $roleId)
            ->where('menu_id', $menuId)
            ->first();

        if ($permissions && $permissions->$action === 'yes') {
            // User has permission
            return response()->json(['success' => true]);
        } else {
            // Permission denied
            return response()->json(['success' => false]);
        }
    }
}
