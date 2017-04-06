<?php namespace App\Repositories\Frontend;
use Redirect;
use Input;
use File;
use App\Models\Gallery;
use URL;
use Auth;
use Session;

/**
 * Class Sliderupload
 * @package App\Repositories\Frontend
 */
class Sliderupload {

private $_result;


  public function postImages() {
        
          $userid = access()->user()->id;
          $dir = 'Slider';
          $path = config('access.uploadDir').'/'.$dir;
          $extension = Input::file('image')->getClientOriginalExtension();
          $file = Input::file('image');
          $caption = Input::get('caption');
          $result = false;
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
       
          $error_message = '';
         try {
              
             //$this->doDirectory($path);
           
             Input::file('image')->move($path, $filename);

             $gallery = Gallery::create([
              'user_id' => $userid,
              'caption' => $caption,
              'path' => $filenameWithPath,
              'type' => 'slider'
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
    
  public function result() {

    $result = $this->_result;
    $this->_result = [];
    return response()->json($result);

    }

    public function delete($id)
    {
      $gallery = Gallery::find($id);
      if($gallery->delete()){
        $img = File::delete($gallery->path);
        return true;
      }
        
       return false;
    }

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    
}