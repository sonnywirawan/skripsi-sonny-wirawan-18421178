<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionApiController extends Controller
{
    public function find_by_id($id) {
        $permission = Permission::find($id);
        return $permission;
    }

    public function get_permissions() {
        return Permission::all();
    }

    public function create_permission(Request $request) {
        DB::beginTransaction();
        
        try {
            $permission = Permission::create([
                'name' => $request->name
            ]);


            DB::commit();
        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ], 400);
        }

        return response()->json([
            'data' => $permission,
            'code' => 200,
        ], 200);
    }

    public function edit_permission(Request $request, $id) {
        DB::beginTransaction();

        try {
            $permission = Permission::where('id', '=', $id)->first();
            $permission->name = $request->name;
            $permission->save();

            DB::commit();
        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ], 400);
        }

        return response()->json([
            'data' => $permission,
            'code' => 200,
        ], 200);
    }

    public function delete_permission($id) {
        DB::beginTransaction();

        try {
            $permission = Permission::find($id);
            $permission->delete();

            DB::commit();

        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ], 400);
        }

        return response()->json([
            'data' => $permission,
            'code' => 200,
        ], 200);
    }
}
