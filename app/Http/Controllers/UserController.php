<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

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

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => [
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],  
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if($request->has('password')){
            $request['password'] = Hash::make($request->password);
        }

        $user->update($request->all());

        return response()->json([
            "status" => "success",
            "message" => "Profile updated successfully",
            "user" => $user], 200);
    }

    public function assignRoleToUser(Request $request, User $user)
    {
        $role = Role::findByName($request->role);

        $user->syncRoles($role);

        return response()->json([
            "status" => "success",
            "message" => "Role assigned to user successfully",
            "user" => $user], 200);
    }

    public function revokeRoleFromUser(Request $request, User $user)
    {
        $role = Role::findByName($request->role);

        $user->removeRole($role);

        return response()->json([
            "status" => "success",
            "message" => "Role revoked from user successfully",
            "user" => $user], 200);
    }
}
