<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserApiController;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Auth;
use Alert;
use Validator;

class UserController extends UserApiController
{
    public function index() {
        $users = $this->get_users();
        $username = Auth::user()->username;
        return view('layouts.user.index', compact('users', 'username'));
    }

    public function form($id = null) {
        $username = Auth::user()->username;
        $roles = Role::all();

        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.user.form', compact('username', 'id', 'data', 'roles'));
        } else {
            return view('layouts.user.form', compact('username', 'id', 'roles'));
        }
    }

    public function store(Request $request) {
        // Check password confirmation
        if($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'confirmed',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', $validator->messages()->first());
                return redirect()->route('user.index');
            }
        }

        // If password confirmation qualified, go
        $data = $this->create_user($request)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
        }
        return redirect()->route('user.index');
    }

    public function edit(Request $request, $id) {
        // Check password confirmation
        if($request->password != null) {
            $validator = Validator::make($request->all(), [
                'password' => 'confirmed',
            ]);
            if ($validator->fails()) {
                Alert::error('Error', $validator->messages()->first());
                return redirect()->route('user.index');
            }
        }

        // If password confirmation qualified, go
        $data = $this->edit_user($request, $id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
        }
        return redirect()->route('user.index');
    }

    public function delete($id) {
        $data = $this->delete_user($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        }
        return redirect()->route('user.index');
    }
}
