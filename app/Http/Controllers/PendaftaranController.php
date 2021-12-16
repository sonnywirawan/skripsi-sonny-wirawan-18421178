<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\PendaftaranApiController;
use App\Models\Event;
use App\Models\Pekerjaan;
use App\Models\Kabupaten;
use Auth;
use Alert;
use Validator;

class PendaftaranController extends PendaftaranApiController
{
    public function index($event_id) {
        $event = Event::find($event_id);
        $pendaftaran = $this->get_pendaftaran($event_id);
        $username = Auth::user()->username;
        return view('layouts.pendaftaran.index', compact('event_id', 'event', 'pendaftaran', 'username'));
    }

    public function form($event_id, $id = null) {
        $username = Auth::user()->username;

        $pekerjaan_all = Pekerjaan::all();
        $kabupaten_all = Kabupaten::all();
        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.pendaftaran.form', compact('username', 'pekerjaan_all', 'kabupaten_all', 'event_id', 'id', 'data'));
        } else {
            return view('layouts.pendaftaran.form', compact('username', 'pekerjaan_all', 'kabupaten_all', 'event_id', 'id'));
        }
    }

    public function store($event_id, Request $request) {
        $data = $this->create_pendaftar($event_id, $request)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
        }

        if(Auth::user()->roles[0]->name == "Admin") {
            return redirect()->route('pendaftaran.index', $event_id);
        } else {
            return redirect()->route('home');
        }
    }

    public function edit($event_id, Request $request, $id) {
        $data = $this->edit_pendaftar($request, $id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
        }
        return redirect()->route('pendaftaran.index', $event_id);
    }

    public function delete($event_id, $id) {
        $data = $this->delete_pendaftar($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        }
        return redirect()->route('pendaftaran.index', $event_id);
    }

    public function daftar_ulang($event_id, $id) {
        $data = $this->daftar_ulang_pendaftar($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Pendaftar Berhasil Mendaftar Ulang');
        }
        return redirect()->route('pendaftaran.index', $event_id);
    }
}
