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
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $data = DB::connection('mysql')->select('select * from gallery where 1');
    return view('layouts.gallery', ['images' => $data]);
});

Route::get('/showimage/{id}', function ($id) {
    $data = DB::connection('mysql')->select('select * from gallery where id = '.$id);
    return view('files.showimage', ['image' => $data]);
});

Route::get('/createdatabase/{database}', function ($database) {
    DB::connection('mysql')->statement('CREATE DATABASE '.$database);
    return 'Setup success';
});

Route::get('/uploadfile',['as'=>'intervention.getresizeimage','uses'=>'UploadFileController@getResizeImage']);
Route::post('/uploadfile',['as'=>'intervention.postresizeimage','uses'=>'UploadFileController@postResizeImage']);