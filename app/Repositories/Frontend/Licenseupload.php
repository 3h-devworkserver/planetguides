<?php namespace App\Repositories\Frontend;

use Input;
use File;
use App\Models\Gallery;
use Image;
use URL;



/**
 * Class Licenseupload
 * @package App\Repositories\Frontend
 */
class Licenseupload {

private $_result;


	public function upload() {
        
          $userid = access()->user()->id;

          $dir = 'license';
          $path = config('access.uploadDir').'/'.$userid.'/'.$dir;
          $extension = Input::file('licensePic')->getClientOriginalExtension();
          //$file_size = Input::file('licensePic')->getSize();
          $file = Input::file('licensePic');
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
       
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
           
             Input::file('licensePic')->move($path, $filename);
             $image = Image::make($filenameWithPath);
             $image = $image->resize(640, null, function ($constraint) {
                  $constraint->aspectRatio();
              });
             $image->save($filenameWithPath);
             $gallery = Gallery::create([
                'user_id' => $userid,
                'path' => $filenameWithPath,
                'type' => 'license'
                
              ]);


             $result = true;

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

    public function delete($id)
    {
      $license = Gallery::find($id);
      if($license->delete()){
        $img = File::delete($license->path);
        return true;
      }
        
       return false;
    }

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }

    }

    public function result() {

        $result = $this->_result;
        $this->_result = [];
        return response()->json($result);

    }

 

}