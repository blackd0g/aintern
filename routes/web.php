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
use Illuminate\Http\Request;

Route::group(['prefix' => 'gallery'], function () {
        
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
});

Route::group(['prefix' => 'sync'], function () {
    Route::post('/upload','UploadFileController@postResizeImage');
    Route::post('/setting','UploadFileController@settingUpload');
    Route::get('/history', function () {
        $dummyHistory = array(
            array(
                "user_id"=>1,
                "actions"=>"UPLOAD FILE",
                "status"=>"SUCCESS",
                "target"=>"file_upload",
                "target_id"=>101,
                "tag"=>"wedding, beauty, light",
                "time"=>"2017-11-31 23:59:59"
            ), array(
                "user_id"=>1,
                "actions"=>"CREATE GALLERY",
                "status"=>"SUCCESS",
                "target"=>"gallery",
                "target_id"=>11,
                "tag"=>"dark",
                "time"=>"2017-12-31 23:59:59"
            )
        );
        $token = request()->header('Authorization');
        if($token != 'Bearer  exampleToken') {
            return response()->json([
                'error'=>'Wrong token'
            ], 401);
        }
        if(request()->query('filter')) {
            function filter($var)
            {
                $filter_field = request()->query('filter');
                $filter_text = request()->query('filter_text');
                return(strtolower($var[$filter_field]) == strtolower($filter_text));
            }

            $dummyHistory = array_filter($dummyHistory, "filter");
        }
        if(request()->query('search')) {
            function search_array($var)
            {
                $search_field = request()->query('search');
                $search_text = request()->query('search_text');
                if (stripos(strtolower($var[$search_field]), strtolower($search_text)) !== false) {
                    return true;
                }
                return false;
            }

            $dummyHistory = array_filter($dummyHistory, "search_array");
        }
        if(request()->query('sort')) {
            function basic_sort($var_1, $var_2)
            {
                $sort_field = request()->query('sort');
                $desc = request()->query('desc');
                if ($var_1[$sort_field] == $var_2[$sort_field]) return 0;
                if($desc == 'true') return ($var_1[$sort_field] > $var_2[$sort_field]) ? -1 : 1;
                return ($var_1[$sort_field] < $var_2[$sort_field]) ? -1 : 1;
            }

            usort($dummyHistory, "basic_sort");
        }
        if(request()->query('limit')) {
            $limit = request()->query('limit');
            $dummyHistory = array_slice($dummyHistory, 0, $limit); 
        }
        return response()->json($dummyHistory, 200);
    });
    Route::get('/gallery', function () {
        $dummyHistory = array(
            array(
                "id"=>1,
                "name"=>"wedding",
                "description"=>"wedding gallery",
                "background_color"=>"#FFFFFF",
                "fontcolor"=>"#000000",
                "created_time"=>"2017-12-31 23:59:59"
            ), array(
                "id"=>2,
                "name"=>"graduate",
                "description"=>"graduate gallery",
                "background_color"=>"#FFFFFF",
                "fontcolor"=>"#000000",
                "created_time"=>"2017-11-31 23:59:59"
            )
        );
        $token = request()->header('Authorization');
        if($token != 'Bearer  exampleToken') {
            return response()->json([
                'error'=>'Wrong token'
            ], 401);
        }
        if(request()->query('search')) {
            function search_array($var)
            {
                $search_field = request()->query('search');
                $search_text = request()->query('search_text');
                if (stripos(strtolower($var[$search_field]), strtolower($search_text)) !== false) {
                    return true;
                }
                return false;
            }

            $dummyHistory = array_filter($dummyHistory, "search_array");
        }
        if(request()->query('sort')) {
            function basic_sort($var_1, $var_2)
            {
                $sort_field = request()->query('sort');
                $desc = request()->query('desc');
                if ($var_1[$sort_field] == $var_2[$sort_field]) return 0;
                if($desc == 'true') return ($var_1[$sort_field] > $var_2[$sort_field]) ? -1 : 1;
                return ($var_1[$sort_field] < $var_2[$sort_field]) ? -1 : 1;
            }

            usort($dummyHistory, "basic_sort");
        }
        if(request()->query('limit')) {
            $limit = request()->query('limit');
            $dummyHistory = array_slice($dummyHistory, 0, $limit); 
        }
        return response()->json($dummyHistory, 200);
    });
});

Route::group(['prefix' => 'authen'], function () {
    
    Route::post('/login', function () {
        if (request('email') != 'testemail' || request('password') != 'password') {
            return response()->json([
                'error'=>'Unauthorised'
            ], 401);
        }
        return response()->json([
            'success'=>'exampleToken'
        ], 200);
    });

    Route::get('/user_details', function () {
        $test = request()->header('Authorization');
        if($test != 'Bearer  exampleToken') {
            return response()->json([
                'error'=>'Wrong token'
            ], 401);
        }
        return response()->json([
            'success'=>'exampleToken',
            'email'=>'testemail',
            'password'=>'password'
        ], 200);
    });

});
