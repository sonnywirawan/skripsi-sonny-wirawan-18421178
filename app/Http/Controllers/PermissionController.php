<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\PermissionApiController;
use App\Models\User;
use Auth;
use Alert;

class PermissionController extends PermissionApiController
{
    public function index() {
        $username = Auth::user()->username;
        $permissions = $this->get_permissions();
        
        return view('layouts.permission.index', compact('username', 'permissions'));
    }

    public function form($id = null) {
        $username = Auth::user()->username;

        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.permission.form', compact('username', 'id', 'data'));
        } else {
            return view('layouts.permission.form', compact('username', 'id'));
        }
    }

    public function store(Request $request) {
        $data = $this->create_permission($request)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
        }
        return redirect()->route('permission.index');
    }

    public function edit(Request $request, $id) {
        $data = $this->edit_permission($request, $id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
        }
        return redirect()->route('permission.index');
    }

    public function delete($id) {
        $data = $this->delete_permission($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        }
        return redirect()->route('permission.index');
    }
}
