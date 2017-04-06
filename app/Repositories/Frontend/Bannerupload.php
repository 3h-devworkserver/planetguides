<?php namespace App\Repositories\Frontend;

use Input;
use File;
use App\Models\Profile;
use Image;
use URL;



/**
 * Class Bannerupload
 * @package App\Repositories\Frontend
 */
class Bannerupload {

private $_result;


	public function upload() {
        
          $userid = access()->user()->id;

          $dir = 'banner';
          $path = config('access.uploadDir').'/'.$userid.'/'.$dir;
          $extension = Input::file('bannerPic')->getClientOriginalExtension();
          //$file_size = Input::file('bannerPic')->getSize();
          $file = Input::file('bannerPic');
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
       
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
           
             Input::file('bannerPic')->move($path, $filename);
            
             Profile::where('user_id',$userid)->update(['bannerImg'=>$filenameWithPath]);


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

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    

    public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }
        return File::cleanDirectory($path);
        

    }

    public function result() {

        $result = $this->_result;
        $this->_result = [];
        return response()->json($result);

    }

 

}