<?php namespace App\Repositories\Frontend;

use Input;
use File;
use App\Models\Gallery;
use URL;
use Image;



/**
 * Class Galleryupload
 * @package App\Repositories\Frontend
 */
class Galleryupload {

private $_result;

//edited by --yojan, commented previous code below this function
 public function upload() {
          $userid = Input::get('id');
          $dir = 'gallery';
          $file = Input::file('galleryPic');
          $path = config('access.uploadDir').'/'.$userid.'/original/'.$dir;
          $pathResize = config('access.uploadDir').'/'.$userid.'/'.'resize'.'/'.$dir;
          $extension = Input::file('galleryPic')->getClientOriginalExtension();
          $file = Input::file('galleryPic');
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
          $filenameWithPathResize = $pathResize .'/'.$filename;
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
             $this->doDirectory($pathResize);

             $move = Input::file('galleryPic')->move($path, $filename);
               $ratio=0.3; 
               if($move){         
              $img = Image::make($filenameWithPath);
                 $height = $img->height();
                 $width = $img->width();

                    $img->resize($width* $ratio,  $height* $ratio);
                    $img->save($filenameWithPathResize);

              $mainPath = asset($filenameWithPath);
              $mainImagesmall = asset($filenameWithPathResize);

              $gallery = Gallery::create([
                'user_id' => $userid,
                'path' => $mainPath,
                'imagesmall' => $mainImagesmall,
                'type' => 'image'
              ]);
             // $gallery = Gallery::create([
             //    'user_id' => $userid,
             //    'path' => 'http://www.guidenp.com/'.$filenameWithPath,
             //    'imagesmall' => 'http://www.guidenp.com/'.$filenameWithPathResize,
             //    'type' => 'image'
             //  ]);

             $result = true;
             }

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            $filename = null;
           

        }

          $this->_result = [
            'result' => $result,
            'insertId' => $userid,
            'imgPath' => URL::to($filenameWithPath),
            'saveMode' => 'insert'
        ];

        if(!empty($error_message)) {

            $this->_result['error_message'] = $error_message;

        }

        return $result;

       
        

    }

//previous code
  // public function upload() {
  //         $userid = Input::get('id');
  //         $dir = 'gallery';
  //         $file = Input::file('galleryPic');
  //         $path = config('access.uploadDir').'/'.$userid.'/'.$dir;
  //         $extension = Input::file('galleryPic')->getClientOriginalExtension();
  //         $file = Input::file('galleryPic');
  //         $result = false;
          
  //         /////before upload filename
  //         $filename = $this->filename($extension);
  //         $filenameWithPath = $path.'/'.$filename;
       
  //         $error_message = '';
      

  //        try {
              
  //            $this->doDirectory($path);
           
  //            Input::file('galleryPic')->move($path, $filename);
             
  //            $gallery = Gallery::create([
  //               'user_id' => $userid,
  //               'path' => $filenameWithPath,
  //               'type' => 'image'
  //             ]);


  //            $result = true;

  //       } catch (Exception $e) {

  //           $error_message = $e->getMessage();
  //           $filename = null;
           

  //       }

  //         $this->_result = [
  //           'result' => $result,
  //           'insertId' => $userid,
  //           'imgPath' => URL::to($filenameWithPath),
  //           'saveMode' => 'insert'
  //       ];

  //       if(!empty($error_message)) {

  //           $this->_result['error_message'] = $error_message;

  //       }

  //       return $result;

       
        

  //   }

//edited by -- yojan , previous function is commented below
  public function delete($id)
    {
      $gallery = Gallery::find($id);
      $image = $gallery->path;
      $imagesmall = $gallery->imagesmall;
      if($gallery->delete()){

          if (!empty($image)) {
           $image =  strstr($image, 'uploads/');
           // $image =  str_replace('http://www.guidenp.com/uploads/', 'uploads/', $image);
            if (File::exists($image)) {
                unlink($image);
            }
        }
        if (!empty($imagesmall)) {
           $imagesmall =  strstr($imagesmall, 'uploads/');
          // $imagesmall =  str_replace('http://www.guidenp.com/uploads/', 'uploads/', $imagesmall);
            if (File::exists($imagesmall)) {
                unlink($imagesmall);
            }
        }
        // $img = File::delete($gallery->path);
        return true;
      }
        
       return false;
    }
//previous code
    // public function delete($id)
    // {
    //   $gallery = Gallery::find($id);
    //   if($gallery->delete()){
    //     $img = File::delete($gallery->path);
    //     return true;
    //   }
        
    //    return false;
    // }


    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

//edited by --yojan , commented previous function below this function
 public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }
    }

    // public function doDirectory($path) {

    //     if(!File::exists($path)) {
    //      return File::makeDirectory($path,0775,true);
    //     }
    // }

    public function result() {

        $result = $this->_result;
        $this->_result = [];
        return response()->json($result);

    }

 

}