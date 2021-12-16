<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Event;
use DB;
use Auth;
use Validator;
use Carbon\Carbon;

class PendaftaranApiController extends Controller
{
    public function find_by_id($id) {
        $pendaftar = Pendaftaran::where('id', $id)->with(['event'])->get()->first();
        return $pendaftar;
    }

    public function get_pendaftaran($event_id) {
        return Pendaftaran::where('event_id', $event_id)->with(['event', 'pekerjaan', 'kabupaten'])->get();
    }

    public function create_pendaftar($event_id, Request $request) {
        $validator = $this->validateRequest($request);
        if($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->messages()->first()
            ], 400);
        }
        // Check Waktu Pendaftaran & Limit
        $event = Event::find($event_id);
        if(Carbon::now() < Carbon::parse($event->registration_start_date)) {
            return response()->json([
                'error' => true,
                'message' => "Pendaftaran Belum Dibuka!"
            ], 400);
        } else if(Carbon::now() > Carbon::parse($event->registration_end_date)) {
            return response()->json([
                'error' => true,
                'message' => "Pendaftaran Telah Ditutup!"
            ], 400);
        } else if(Pendaftaran::where('event_id', $event_id)->count() >= $event->limit) {
            return response()->json([
                'error' => true,
                'message' => "Pendaftaran Event Penuh!"
            ], 400);
        }

        // Check NIP
        $nip = Pendaftaran::where('event_id', $event_id)
                        ->where('nip', $request->nip)
                        ->get();
        if(count($nip) != 0) {
            return response()->json([
                'error' => true,
                'message' => "NIP sudah terdaftar pada event ini!"
            ], 400);
        }
        DB::beginTransaction();
        try {

            $pendaftar = Pendaftaran::create([
                'user_id'                   => Auth::user()->id,
                'event_id'                  => $event_id,
                'nip'                       => $request->nip,
                'nama_lengkap'              => $request->nama_lengkap,
                'no_hp'                     => $request->no_hp,
                'tempat_lahir'              => $request->tempat_lahir,
                'tgl_lahir'                 => $request->tgl_lahir,
                'jk'                        => $request->jk,
                'pekerjaan_id'              => $request->pekerjaan_id,
                'pangkat'                   => $request->pangkat,
                'jabatan'                   => $request->jabatan,
                'instansi'                  => $request->instansi,
                'kabupaten_id'              => $request->kabupaten_id,
                'npwp'                      => $request->npwp,
                'nama_bank'                 => $request->nama_bank,
                'no_rekening'               => $request->no_rekening,
                'biaya_perjalanan'          => join("", explode(",", $request->biaya_perjalanan)),
                'status_pendaftaran_ulang'  => 0,
            ]);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $pendaftar,
            'code' => 200,
        ], 200);
    }

    public function edit_pendaftar(Request $request, $id) {
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftaran::find($id);

            if($request->has('nip')) {
                if($request->nip != null) {
                    $pendaftar->nip = $request->nip;
                }
            }
            if($request->has('nama_lengkap')) {
                if($request->nama_lengkap != null) {
                    $pendaftar->nama_lengkap = $request->nama_lengkap;
                }
            }
            if($request->has('no_hp')) {
                if($request->no_hp != null) {
                    $pendaftar->no_hp = $request->no_hp;
                }
            }
            if($request->has('tempat_lahir')) {
                if($request->tempat_lahir != null) {
                    $pendaftar->tempat_lahir = $request->tempat_lahir;
                }
            }
            if($request->has('tgl_lahir')) {
                if($request->tgl_lahir != null) {
                    $pendaftar->tgl_lahir = $request->tgl_lahir;
                }
            }
            if($request->has('pekerjaan_id')) {
                if($request->pekerjaan_id != null) {
                    $pendaftar->pekerjaan_id = $request->pekerjaan_id;
                }
            }
            if($request->has('jk')) {
                if($request->jk != null) {
                    $pendaftar->jk = $request->jk;
                }
            }
            if($request->has('pangkat')) {
                if($request->pangkat != null) {
                    $pendaftar->pangkat = $request->pangkat;
                }
            }
            if($request->has('jabatan')) {
                if($request->jabatan != null) {
                    $pendaftar->jabatan = $request->jabatan;
                }
            }
            if($request->has('instansi')) {
                if($request->instansi != null) {
                    $pendaftar->instansi = $request->instansi;
                }
            }
            if($request->has('kabupaten_id')) {
                if($request->kabupaten_id != null) {
                    $pendaftar->kabupaten_id = $request->kabupaten_id;
                }
            }
            if($request->has('npwp')) {
                if($request->npwp != null) {
                    $pendaftar->npwp = $request->npwp;
                }
            }
            if($request->has('nama_bank')) {
                if($request->nama_bank != null) {
                    $pendaftar->nama_bank = $request->nama_bank;
                }
            }
            if($request->has('no_rekening')) {
                if($request->no_rekening != null) {
                    $pendaftar->no_rekening = $request->no_rekening;
                }
            }
            if($request->has('biaya_perjalanan')) {
                if($request->biaya_perjalanan != null) {
                    $pendaftar->biaya_perjalanan = join("", explode(",", $request->biaya_perjalanan));
                }
            }
            if($request->has('status_pendaftaran_ulang')) {
                if($request->status_pendaftaran_ulang != null) {
                    $pendaftar->status_pendaftaran_ulang = $request->status_pendaftaran_ulang;
                }
            }

            $pendaftar->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $pendaftar,
            'code' => 200,
        ], 200);
    }

    public function delete_pendaftar($id) {
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftaran::find($id);
            $pendaftar->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $pendaftar,
            'code' => 200,
        ], 200);
    }

    public function daftar_ulang_pendaftar($id) {
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftaran::find($id);
            $pendaftar->status_pendaftaran_ulang = 1;

            $pendaftar->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->errorInfo[2],
            ], 403);
        }

        return response()->json([
            'data' => $pendaftar,
            'code' => 200,
        ], 200);
    }

    private function validateRequest(Request $request) {
        $validator = Validator::make($request->all(), [
            'nip'               => 'required',
            'nama_lengkap'      => 'required',
            'no_hp'             => 'required',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|date',
            'jk'                => 'required',
            'pekerjaan_id'      => 'required',
            'pangkat'           => 'required',
            'jabatan'           => 'required',
            'instansi'          => 'required',
            'kabupaten_id'      => 'required',
            'npwp'              => 'required',
            'nama_bank'         => 'required',
            'no_rekening'       => 'required',
            'biaya_perjalanan'  => 'required',
        ]);

        return $validator;
    }
}
