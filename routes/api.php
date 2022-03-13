<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get-client', function () {
    $client = DB::table('oauth_clients')->find(2);
    return response()->json(
        [
            'data' => [
                'client_id' => $client->id,
                'client_secret' => $client->secret
            ], 
            'code' => 200
        ]
    );
})->name('get-client');

Route::middleware('auth:api')->group(function() {
    Route::get('events', [EventApiController::class, 'get_events_without_pendaftar']);
    Route::get('rekap-daftar-hadir/{id}', [EventApiController::class, 'rekap_daftar_hadir']);
});