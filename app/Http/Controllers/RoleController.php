<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleAssignRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            "status" => "success",
            "roles" => $roles
        ], 200);
    }

    public function assignPermissionsToRole(RoleAssignRequest $request, Role $role)
    {
        $role->givePermissionTo($request->permissions);

        return response()->json([
            "status" => "success",
            "message" => "Permissions assigned to role successfully",
            "role" => $role
        ], 200);
    }

    public function revokePermissionsFromRole(Request $request, Role $role)
    {
        $role->revokePermissionTo($request->permissions);

        return response()->json([
            "status" => "success",
            "message" => "Permissions revoked from role successfully",
            "role" => $role
        ], 200);
    }
}
