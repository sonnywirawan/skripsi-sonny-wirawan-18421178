<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\EventApiController;
use App\Models\User;
use Auth;
use Alert;
use Carbon\Carbon;

class EventController extends EventApiController
{
    public function index() {
        $username = Auth::user()->name;
        $events = $this->get_events();
        
        return view('layouts.event.index', compact('username', 'events'));
    }

    public function form($id = null) {
        $username = Auth::user()->name;

        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.event.form', compact('username', 'id', 'data'));
        } else {
            return view('layouts.event.form', compact('username', 'id'));
        }
    }

    public function store(Request $request) {
        $data = $this->create_event($request)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
        }
        return redirect()->route('event.index');
    }

    public function edit(Request $request, $id) {
        $data = $this->edit_event($request, $id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
        }
        return redirect()->route('event.index');
    }

    public function delete($id) {
        $data = $this->delete_event($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Gagal', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        }
        return redirect()->route('event.index');
    }

    public function cetak_daftar_hadir($id) {
        return $this->get_daftar_hadir($id);
    }
}
