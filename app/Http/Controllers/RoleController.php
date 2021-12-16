<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\RoleApiController;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Auth;
use Alert;

class RoleController extends RoleApiController
{
    public function index() {
        $username = Auth::user()->username;
        $roles = $this->get_roles();
        return view('layouts.role.index', compact('username', 'roles'));
    }

    public function form($id = null) {
        $username = Auth::user()->username;
        $permissions = Permission::all();

        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.role.form', compact('username', 'id', 'permissions', 'data'));
        } else {
            return view('layouts.role.form', compact('username', 'id', 'permissions'));
        }
    }

    public function store(Request $request) {
        $data = $this->create_role($request)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
        }
        return redirect()->route('role.index');
    }

    public function edit(Request $request, $id) {
        $data = $this->edit_role($request, $id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
        }
        return redirect()->route('role.index');
    }

    public function delete($id) {
        $data = $this->delete_role($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        }
        return redirect()->route('role.index');
    }
}
