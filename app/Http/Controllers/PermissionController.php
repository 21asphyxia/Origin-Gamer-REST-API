<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->pluck('name');

        return response()->json([
            "status" => "success",
            "permissions" => $permissions
        ], 200);
    }
}
