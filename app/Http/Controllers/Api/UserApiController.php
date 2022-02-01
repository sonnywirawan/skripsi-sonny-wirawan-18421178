<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Traits\HasRoles;

class UserApiController extends Controller
{
    public function find_by_id($id) {
        $user = User::where('id', $id)->with('roles')->get()->first();
        return $user;
    }

    public function find_by_email($email) {
        $user = User::where('email', '=', $email)->first();
        if($user == null) {
            return response()->json([
                'error' => true,
                'message' => 'User not registered!',
            ], 400);
        }

        return $user->getOriginal();
    }

    public function get_users() {
        return User::with('roles')->get();
    }

    public function create_user(Request $request) {
        $validator = $this->validateRequest($request);
        if($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->messages()->first()
            ], 400);
        }
        DB::beginTransaction();
        try {

            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
            ]);

            $user->syncRoles($request->roles);
            $permissionsByRole = $user->getPermissionsViaRoles()->pluck('id');
            $user->syncPermissions($permissionsByRole);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $user,
            'code' => 200,
        ], 200);
    }

    public function edit_user(Request $request, $id) {
        DB::beginTransaction();

        try {
            $user = User::find($id);

            if($request->has('name')) {
                if($request->name != null) {
                    $user->name = $request->name;
                }
            }

            if($request->has('email')) {
                if($request->email != null) {
                    $user->email = $request->email;
                }
            }

            if($request->has('password')) {
                if($request->password != null) {
                    $user->password = Hash::make($request->password);
                }
            }

            if($request->has('roles')) {
                $user->syncRoles($request->roles);
                $permissionsByRole = $user->getPermissionsViaRoles()->pluck('id');
                $user->syncPermissions($permissionsByRole);
            }

            $user->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $user,
            'code' => 200,
        ], 200);
    }

    public function delete_user($id) {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $user->syncRoles();
            $user->syncPermissions();
            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $user,
            'code' => 200,
        ], 200);
    }

    private function validateRequest(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|unique:users',
            'password'      => 'required',
            'roles'         => 'required',
        ]);

        return $validator;
    }
}
