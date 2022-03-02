<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Event;
use DB;
use Auth;
use Validator;
use PDF;
use Carbon\Carbon;

class PendaftaranApiController extends Controller
{
    public function find_by_id($id) {
        $pendaftar = Pendaftaran::where('id', $id)->with('event')->get()->first();
        return $pendaftar;
    }

    public function get_pendaftaran($event_id) {
        return Pendaftaran::where('event_id', $event_id)->with('event')->get();
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
        // if(Carbon::now() < Carbon::parse($event->registration_start_date)) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => "Pendaftaran Belum Dibuka!"
        //     ], 400);
        // } else if(Carbon::now() > Carbon::parse($event->registration_end_date)) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => "Pendaftaran Telah Ditutup!"
        //     ], 400);
        // } else if(Pendaftaran::where('event_id', $event_id)->count() >= $event->limit) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => "Pendaftaran Event Penuh!"
        //     ], 400);
        // }

        // Error if age < 18
        if(Carbon::parse($request->tgl_lahir)->age < 18) {
            return response()->json([
                'error' => true,
                'message' => 'Maaf, umur minimum vaksinasi adalah 18 tahun.'
            ], 400);
        }

        // Check antrian
        $antrian = Pendaftaran::where('tgl_daftar', today()->format('Y-m-d'))
                                ->where('jenis_pendaftaran', $request->jenis_pendaftaran)
                                ->max('nomor_antrian');
        if($antrian != null) {
            if($antrian == $event->limit && $request->jenis_pendaftaran == 'Online') {
                return response()->json([
                    'error' => true,
                    'message' => 'Maaf, antrian sudah penuh.'
                ], 400);
            } else {
                $nomor_antrian = $antrian + 1;
            }
        } else {
            $nomor_antrian = 1;
        }

        // Check NIK
        $nip = Pendaftaran::where('event_id', $event_id)
                        ->where('nik', $request->nik)
                        ->get();
        if(count($nip) != 0) {
            return response()->json([
                'error' => true,
                'message' => "NIK sudah terdaftar pada event ini!"
            ], 400);
        }
        DB::beginTransaction();
        try {
            $pendaftar = Pendaftaran::create([
                'user_id'                       => Auth::user()->id,
                'event_id'                      => $event_id,
                'nik'                           => $request->nik,
                'nama_lengkap'                  => $request->nama_lengkap,
                'no_hp'                         => $request->no_hp,
                'jk'                            => $request->jk,
                'tempat_lahir'                  => $request->tempat_lahir,
                'tgl_lahir'                     => Carbon::parse($request->tgl_lahir)->format('Y-m-d'),
                'alamat'                        => $request->alamat,
                'tgl_daftar'                    => today()->format('Y-m-d'),
                'nomor_antrian'                 => $nomor_antrian,
                'jenis_pendaftaran'             => $request->jenis_pendaftaran,
                'status_kedatangan'             => 0,
                'status_keberhasilan_vaksinasi' => 0,
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

            if($request->has('nik')) {
                if($request->nik != null) {
                    $pendaftar->nik = $request->nik;
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

            if($request->has('jk')) {
                if($request->jk != null) {
                    $pendaftar->jk = $request->jk;
                }
            }

            if($request->has('tempat_lahir')) {
                if($request->tempat_lahir != null) {
                    $pendaftar->tempat_lahir = $request->tempat_lahir;
                }
            }

            if($request->has('tgl_lahir')) {
                if($request->tgl_lahir != null) {
                    $pendaftar->tgl_lahir = Carbon::parse($request->tgl_lahir)->format('Y-m-d');
                }
            }

            if($request->has('alamat')) {
                if($request->alamat != null) {
                    $pendaftar->alamat = $request->alamat;
                }
            }

            if($request->has('status_kedatangan')) {
                $pendaftar->status_kedatangan = 1;
            } else {
                $pendaftar->status_kedatangan = 0;
            }

            if($request->has('status_keberhasilan_vaksinasi')) {
                $pendaftar->status_keberhasilan_vaksinasi = 1;
            } else {
                $pendaftar->status_keberhasilan_vaksinasi = 0;
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

    public function pendaftar_berhasil_datang($id) {
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftaran::find($id);
            $pendaftar->status_kedatangan = 1;

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

    public function pendaftar_berhasil_vaksin($id) {
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftaran::find($id);
            $pendaftar->status_keberhasilan_vaksinasi = 1;

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

    public function get_formulir_pendaftaran($id) {
        $pendaftar = Pendaftaran::where('id', $id)->with('event')->first();
        $file_name = 'Formulir Pendaftaran '. $pendaftar->nik . ' - ' . $pendaftar->tgl_daftar;
        $umur = Carbon::parse($pendaftar->tgl_lahir)->age;
        if($umur < 50) {
            $kategori_umur = 1;
        } else if($umur >= 50 && $umur <= 60) {
            $kategori_umur = 2;
        } else {
            $kategori_umur = 3;
        }

        if($pendaftar->jenis_pendaftaran == "Online") {
            if($pendaftar->nomor_antrian <= 100) {
                $rentang_waktu = "10.30 s/d 11.30";
            } else if($pendaftar->nomor_antrian <= 200) {
                $rentang_waktu = "13.00 s/d 14.00";
            } else if($pendaftar->nomor_antrian <= 300) {
                $rentang_waktu = "14.00 s/d 15.00";
            }
        } else {
            $rentang_waktu = "-";
        }
        $pdf = PDF::loadView('layouts.pendaftaran.formulir', compact('pendaftar', 'file_name', 'kategori_umur', 'rentang_waktu'))->setPaper('legal', 'portrait');
        return $pdf->download($file_name . '.pdf');
    }

    private function validateRequest(Request $request) {
        $validator = Validator::make($request->all(), [
            'nik'               => 'required|min:16|max:16',
            'nama_lengkap'      => 'required',
            'no_hp'             => 'required',
            'jk'                => 'required',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required|date',
            'alamat'            => 'required',
            'jenis_pendaftaran' => 'required',
        ]);

        return $validator;
    }
}
