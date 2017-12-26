<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Image;

class UploadFileController extends Controller {

    public function getResizeImage()
    {
        return view('files.uploadpage');
    }

    public function postResizeImage(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != 'Bearer  exampleToken') {
            return response()->json([
                'error'=>'Wrong token'
            ], 401);
        }
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        $photo = $request->file('file');

        $realName = $photo->getClientOriginalName();
        
        $destinationPath = public_path('/thumbnail_images');
        $size = getimagesize($photo->getRealPath());
        $width = $size[0];
        $height = $size[1];
        $currentTime = time();
        $dateNow = date('Y-m-d H:i:s', strtotime($currentTime));
        $thumbnailName = $currentTime.'.'.$photo->getClientOriginalExtension();
        $all_path = [];
        for($i = 1;$i <= 5;$i += 1) {
            $thumb_img = Image::make($photo->getRealPath())->resize(intval($width/$i), intval($height/$i));
            $thumb_img->save($destinationPath.'/size_'.$i.'/'.$thumbnailName,80);
            array_push($all_path, 'public/size_'.$i.'/'.$thumbnailName);
        }
        
        $destinationPath = public_path('/normal_images');

        $photo->move($destinationPath, $thumbnailName);
        DB::insert('insert into file_upload (real_name, thumbnail_name, time, width, height, gallery_id) values (?, ?, ?, ?, ?, ?)', [$realName, $thumbnailName, $dateNow, $width, $height, $request->input('gallery_id') ]);
        
        return response()->json([
            'status'=>'success',
            'galler_id'=>$request->input('gallery_id'),
            'thumbnailName'=>$thumbnailName,
            'realName'=>$realName,
            'width_image'=>$width,
            'height_image'=>$height,
            'path_picture'=>$all_path
        ], 200);
    }

    public function settingUpload(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != 'Bearer  exampleToken') {
            return response()->json([
                'error'=>'Wrong token'
            ], 401);
        }
        return response()->json([
            'status'=>'success',
            'maximumFileSize'=>$request->input('maximumfilesize'),
            'scale'=>$request->input('scale')
        ], 200);
    }
    
}
