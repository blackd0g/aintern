<?php

use Illuminate\Http\Request;
use App\User;
use App\Gallery;
use App\UploadLog;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');


Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user_details', 'API\UserController@details');

    Route::group(['prefix' => 'sync'], function () {
        Route::post('/upload','UploadFileController@postResizeImage');
        Route::post('/setting','UploadFileController@settingUpload');
        Route::get('/history', function () {
            $user = Auth::user();
            if(!request()->query('filter')) {
                $filter = [
                    ['user_id', $user['id']],
                ];
            } else {
                $filter = [
                    ['user_id', $user['id']],
                    [request()->query('filter'), request()->query('filter_text')]
                ];
            }
            if(request()->query('search')) {
                array_push($filter, [request()->query('search'), 'LIKE', "%".request()->query('search_text')."%"]);
            }
            
            $histories = UploadLog::where($filter);
            if(request()->query('sort')) {
                if(request()->query('desc') == 'true') $histories  = $histories -> orderBy(request()->query('sort'), 'desc');
                else $histories = $histories -> orderBy(request()->query('sort'));
            }
            if(request()->query('limit')) {
                $histories = $histories ->take(request()->query('limit'));
            }
            $histories = $histories -> get();
            return response()->json($histories, 200);
        });
        Route::get('/gallery', function () {
            $user = Auth::user();
            $filter = [
                ['user_id', $user['id']],
            ];
            if(request()->query('search')) {
                array_push($filter, [request()->query('search'), 'LIKE', "%".request()->query('search_text')."%"]);
            }
            $galleries = Gallery::where($filter);
            if(request()->query('sort')) {
                if(request()->query('desc') == 'true') $galleries  = $galleries -> orderBy(request()->query('sort'), 'desc');
                else $galleries = $galleries -> orderBy(request()->query('sort'));
            }
            if(request()->query('limit')) {
                $galleries = $galleries ->take(request()->query('limit'));
            }
            $galleries = $galleries -> get();
            return response()->json($galleries, 200);
        });
    });
});
