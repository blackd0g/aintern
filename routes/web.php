<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

Route::get('/', function () {
    $data = DB::connection('mysql')->select('select * from gallery where 1');
    return view('layouts.gallery', ['images' => $data]);
});

// Route::get('/showimage/{id}', function ($id) {
//     $data = DB::connection('mysql')->select('select * from gallery where id = '.$id);
//     return view('files.showimage', ['image' => $data]);
// });

// Route::get('/uploadfile',['as'=>'intervention.getresizeimage','uses'=>'UploadFileController@getResizeImage']);
// Route::post('/uploadfile',['as'=>'intervention.postresizeimage','uses'=>'UploadFileController@postResizeImage']);