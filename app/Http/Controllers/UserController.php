<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return response()->json([
            "status" => "success",
            "users" => $users], 200);
    }

    public function assignRoleToUser(Request $request, User $user)
    {
        $user->assignRole($request->role);

        return response()->json([
            "status" => "success",
            "message" => "Role assigned to user successfully",
            "user" => $user], 200);
    }

    public function revokeRoleFromUser(Request $request, User $user)
    {
        $user->removeRole($request->role);

        return response()->json([
            "status" => "success",
            "message" => "Role revoked from user successfully",
            "user" => $user], 200);
    }
}
