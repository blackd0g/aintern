<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $data = DB::connection('mysql')->select('select * from gallery where 1');
    return view('welcome', ['users' => $data[0]]);
});

// Route::get('/uploadfile','UploadFileController@index');
// Route::post('/uploadfile','UploadFileController@showUploadFile');

Route::get('/uploadfile',['as'=>'intervention.getresizeimage','uses'=>'UploadFileController@getResizeImage']);
Route::post('/uploadfile',['as'=>'intervention.postresizeimage','uses'=>'UploadFileController@postResizeImage']);