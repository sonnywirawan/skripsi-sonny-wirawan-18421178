<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RoleApiController extends Controller
{
    public function find_by_id($id) {
        $role = Role::where('id', $id)->with('permissions')->get()->first();
        return $role;
    }

    public function get_roles() {
        return Role::with('permissions')->get();
    }

    public function create_role(Request $request) {
        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => $request->name
            ]);

            if($request->has('permissions')) {
                $role->givePermissionTo($request->permissions);
            }

            DB::commit();
        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ]);
        }

        return response()->json([
            'data' => $role,
            'code' => 200,
        ], 200);
    }

    public function edit_role(Request $request, $id) {
        DB::beginTransaction();

        try {
            $role = Role::where('id', '=', $id)->first();
            $role->name = $request->name;

            $users = User::with('roles')->get();
            foreach($users as $user) {
                if($user->hasRole($role->id)) {
                    $user->syncPermissions($request->permissions);
                }
            }
            $role->syncPermissions($request->permissions);
            $role->save();

            DB::commit();
        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ]);
        }

        return response()->json([
            'data' => $role,
            'code' => 200,
        ], 200);;
    }

    public function delete_role($id) {
        DB::beginTransaction();

        try {
            $role = Role::find($id);
            $permissionsViaRole = $role->permissions()->pluck('name')->toArray();

            $users = User::role($role)->get();

            foreach($users as $user) {
                $user->revokePermissionTo($permissionsViaRole);
            }
            
            $role->delete();

            DB::commit();

        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ]);
        }

        return response()->json([
            'data' => $role,
            'code' => 200,
        ], 200);;
    }

    public function get_permissions_by_role($id) {
        $role = Role::find($id);
        return $role->permissions()->pluck('id');
    }
}
