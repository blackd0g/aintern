<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Image;
use App\User;
use App\Gallery;
use Illuminate\Support\Facades\Auth;
use Validator;

class UploadFileController extends Controller {

    public function getResizeImage()
    {
        return view('files.uploadpage');
    }

    public function postResizeImage(Request $request)
    {

        $user = Auth::user();
        $currentTime = time();
        $dateNow = date('Y-m-d H:i:s', strtotime($currentTime));
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        
        if( $validator->fails())
        {
            DB::table('upload_log')->insertGetId(
                array(
                    'user_id' => $user['id'],
                    'actions' => 'ADD DATA',
                    'time' => $dateNow,
                    'target' => 'file_upload',
                    'target_id' => NULL,
                    'status' => 'ERROR : FILE WRONG TYPE OR MORE THAN MAXIMUM',
                )
            );
            return response()->json(
                $validator->errors()
            , 200);
        }
        $photo = $request->file('file');

        $realName = $photo->getClientOriginalName();
        
        $destinationPath = public_path('/thumbnail_images');
        $size = getimagesize($photo->getRealPath());
        $width = $size[0];
        $height = $size[1];
        $thumbnailName = $currentTime.'.'.$photo->getClientOriginalExtension();
        $all_path = [];
        for($i = 1;$i <= 5;$i += 1) {
            $thumb_img = Image::make($photo->getRealPath())->resize(intval($width/$i), intval($height/$i));
            $thumb_img->save($destinationPath.'/size_'.$i.'/'.$thumbnailName,80);
            array_push($all_path, 'public/size_'.$i.'/'.$thumbnailName);
        }
        
        $destinationPath = public_path('/normal_images');

        $photo->move($destinationPath, $thumbnailName);
        $gallery = Gallery::find($request->input('gallery_id'));
        if(!$gallery) {
            return response()->json([
                'error'=>'gallery not found',
            ], 404);
            DB::table('upload_log')->insertGetId(
                array(
                    'user_id' => $user['id'],
                    'actions' => 'ADD DATA',
                    'time' => $dateNow,
                    'target' => 'file_upload',
                    'target_id' => NULL,
                    'status' => 'ERROR : GALLERY NOT FOUND',
                )
            );
        }
        // return response()->json($gallery, 200);
        $id = DB::table('file_upload')->insertGetId(
            array(
                'real_name' => $realName,
                'thumbnail_name' => $thumbnailName,
                'time' => $dateNow,
                'width' => $width,
                'height' => $height,
                'gallery_id' => $request->input('gallery_id'),
                'user_id' => $user['id'],
            )
        );
        error_log($id);
        DB::table('upload_log')->insert(
            array(
                'user_id' => $user['id'],
                'actions' => 'ADD DATA',
                'time' => $dateNow,
                'target' => 'file_upload',
                'target_id' => $id,
                'status' => 'SUCCESS',
            )
        );
        // $result = DB::insert(
        //     'insert into file_upload (real_name, thumbnail_name, time, width, height, gallery_id, user_id) values (?, ?, ?, ?, ?, ?, ?)',
        //     [$realName, $thumbnailName, $dateNow, $width, $height, $request->input('gallery_id'), $user['id']]
        // );
        // DB::insert(
        //     'insert into upload_log (user_id, actions, status, target, target_id, time) values (?, ?, ?, ?, ?, ?)',
        //     [$realName, $thumbnailName, $dateNow, $width, $height, $request->input('gallery_id'), $user['id']]
        // );
        
        return response()->json([
            'status'=>'success',
            'gallery_id'=>$request->input('gallery_id'),
            'thumbnailName'=>$thumbnailName,
            'realName'=>$realName,
            'width_image'=>$width,
            'height_image'=>$height,
            'path_picture'=>$all_path,
            'user_id' => $user['id'],
        ], 200);
    }

    public function settingUpload(Request $request)
    {
        return response()->json([
            'status'=>'success',
            'maximumFileSize'=>$request->input('maximumfilesize'),
            'scale'=>$request->input('scale')
        ], 200);
    }
    
}
