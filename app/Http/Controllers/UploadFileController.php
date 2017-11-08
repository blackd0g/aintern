<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $photo = $request->file('photo');

        $realName = $photo->getClientOriginalName();
        
        $destinationPath = public_path('/thumbnail_images');
        $size = getimagesize($photo->getRealPath());
        $width = $size[0];
        $height = $size[1];
        $currentTime = time();
        $dateNow = date('Y-m-d H:i:s', strtotime($currentTime));
        $thumbnailName = $currentTime.'.'.$photo->getClientOriginalExtension();
        for($i = 1;$i <= 5;$i += 1) {
            $thumb_img = Image::make($photo->getRealPath())->resize(intval($width/$i), intval($height/$i));
            $thumb_img->save($destinationPath.'/size_'.$i.'/'.$thumbnailName,80);
        }
        
        $destinationPath = public_path('/normal_images');
        echo $width.'</br>';
        echo $height.'</br>';
        echo $thumbnailName.'</br>';
        echo $realName.'</br>';
        echo $destinationPath.'/'.$thumbnailName.'</br>';
        $photo->move($destinationPath, $thumbnailName);
        DB::insert('insert into gallery (real_name, thumbnail_name, time, width, height) values (?, ?, ?, ?, ?)', [$realName, $thumbnailName, $dateNow, $width, $height]);
        return back()
            ->with('success','Image Upload successful')
            ->with('thumbnailName',$thumbnailName)
            ->with('width_image',$width)
            ->with('height_image',$height);
    }
    
}
