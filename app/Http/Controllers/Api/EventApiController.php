<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Exports\EventExport;
use Carbon\Carbon;
use DB;
use Excel;

class EventApiController extends Controller
{
    public function find_by_id($id) {
        $event = Event::find($id);
        return $event;
    }

    public function get_events() {
        return Event::with('pendaftaran')->get();
    }

    public function create_event(Request $request) {
        DB::beginTransaction();
        
        try {
            $event = Event::create([
                'name'                      => $request->name,
                'registration_start_date'   => Carbon::parse($request->registration_start_date)->format('Y-m-d H:i:s'),
                'registration_end_date'     => Carbon::parse($request->registration_end_date)->format('Y-m-d H:i:s'),
                'start_date'                => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
                'end_date'                  => Carbon::parse($request->end_date)->format('Y-m-d H:i:s'),
                'lokasi'                    => $request->lokasi,
                'limit'                     => $request->limit,
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
            'data' => $event,
            'code' => 200,
        ], 200);
    }

    public function edit_event(Request $request, $id) {
        DB::beginTransaction();

        try {
            $event = Event::find($id);

            if($request->has('name')) {
                if($request->name != null) {
                    $event->name = $request->name;
                }
            }

            if($request->has('registration_start_date')) {
                if($request->registration_start_date != null) {
                    $event->registration_start_date = Carbon::parse($request->registration_start_date)->format('Y-m-d H:i:s');
                }
            }

            if($request->has('registration_end_date')) {
                if($request->registration_end_date != null) {
                    $event->registration_end_date = Carbon::parse($request->registration_end_date)->format('Y-m-d H:i:s');
                }
            }

            if($request->has('start_date')) {
                if($request->start_date != null) {
                    $event->start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
                }
            }

            if($request->has('end_date')) {
                if($request->end_date != null) {
                    $event->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
                }
            }

            if($request->has('lokasi')) {
                if($request->lokasi != null) {
                    $event->lokasi = $request->lokasi;
                }
            }

            if($request->has('limit')) {
                if($request->limit != null) {
                    $event->limit = $request->limit;
                }
            }
            $event->save();

            DB::commit();
        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ], 400);
        }

        return response()->json([
            'data' => $event,
            'code' => 200,
        ], 200);
    }

    public function delete_event($id) {
        DB::beginTransaction();

        try {
            $event = Event::find($id);
            $event->delete();

            DB::commit();

        } catch(\Exception $error) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $error->errorInfo[2],
            ], 400);
        }

        return response()->json([
            'data' => $event,
            'code' => 200,
        ], 200);
    }

    public function get_daftar_hadir($id) {
        $nama_file = "DAFTAR HADIR " . Event::find($id)->name . ".xlsx";
        return Excel::download(new EventExport($id), $nama_file);
    }
}
