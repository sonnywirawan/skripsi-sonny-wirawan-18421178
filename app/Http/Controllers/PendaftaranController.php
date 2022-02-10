<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\PendaftaranApiController;
use App\Models\Event;
use Auth;
use Alert;
use Validator;

class PendaftaranController extends PendaftaranApiController
{
    public function index($event_id) {
        $event = Event::find($event_id);
        $pendaftaran = $this->get_pendaftaran($event_id);
        $username = Auth::user()->name;
        return view('layouts.pendaftaran.index', compact('event_id', 'event', 'pendaftaran', 'username'));
    }

    public function form($event_id, $id = null) {
        $username = Auth::user()->name;

        if($id != null) {
            $data = $this->find_by_id($id);
            return view('layouts.pendaftaran.form', compact('username', 'event_id', 'id', 'data'));
        } else {
            return view('layouts.pendaftaran.form', compact('username', 'event_id', 'id'));
        }
    }

    public function store($event_id, Request $request) {
        $role = auth()->user()->roles()->first();
        if($role->name == 'Pendaftar') {
            $jenis_pendaftaran = 'Online';
        } else {
            $jenis_pendaftaran = 'OTC';
        }
        $request->request->add([
            'jenis_pendaftaran' => $jenis_pendaftaran
        ]);

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

    public function berhasil_datang($event_id, $id) {
        $data = $this->pendaftar_berhasil_datang($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Pendaftar telah sampai ke lokasi');
        }
        return redirect()->route('pendaftaran.index', $event_id);
    }

    public function berhasil_vaksin($event_id, $id) {
        $data = $this->pendaftar_berhasil_vaksin($id)->getData('data');
        if(array_key_exists('error', $data)) {
            Alert::error('Error', $data['message']);
        } else {
            Alert::success('Berhasil', 'Pendaftar Berhasil Vaksinasi');
        }
        return redirect()->route('pendaftaran.index', $event_id);
    }

    public function formulir_pendaftaran($event_id, $id) {
        return $this->get_formulir_pendaftaran($id);
    }
}
