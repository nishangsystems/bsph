<?php

use App\Http\Controllers\ApiContoller;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('application_status', function(){
    $cyear = \App\Helpers\Helpers::instance()->getCurrentAccademicYear();
    $config = \App\Models\Config::where('year_id', $cyear)->select(['id', 'year_id', 'start_date', 'end_date'])->first()->toArray();
    if(now()->isBefore($config['start_date']))
    $config['status'] = "NOT OPENED";
    elseif(now()->isAfter($config['end_date']))
    $config['status'] = "CLOSED";
    else
    $config['status'] = "OPEN";
    $config['start_date'] = now()->parse($config['start_date'])->format('d/m/Y');
    $config['end_date'] = now()->parse($config['end_date'])->format('d/m/Y');
    return response()->json($config);
});