<?php

use App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::post('/send_data',[Home::class,'sendData']);
Route::get('/get_data',[Home::class,'getData'])->name('get');
Route::get('/get_data_table',[Home::class,'getDataToTable'])->name('getTable');