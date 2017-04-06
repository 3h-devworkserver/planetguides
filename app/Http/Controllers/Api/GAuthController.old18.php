<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
//use Response;
use Log;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Access\User\User;
use App\Models\Language;
use App\Models\Review;
use App\Models\Contact;
use App\Models\GuideArea;
use App\Models\Booking;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\Guide;
use App\Models\Setting;
//use App\Models\Assign_role;
use Input;
use App\Http\Requests;
//use App\Repositories\Backend\Pages\PageContract;
//use App\Repositories\Backend\User\UserContract;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use App\Http\Requests\Frontend\Access\LoginRequest;
//use App\Repositories\Frontend\Auth\AuthenticationContract;
use Illuminate\Support\Facades\Validator;
use DB;
//use Datatable;
use Hash;
Use Auth;
use JWTAuth;
//use Tymon/JWTAuth/JWTAuth;
//use Tymon\JWTAuth\Facades\JWTAuth;

//use Illuminate \ Session \ TokenMismatchException;
use App\Http\Requests\Frontend\Access\ResetPasswordRequest;
use Cookie;


class GAuthController extends Controller
{
      use ResetsPasswords;
       protected $user; 
        protected $auth;
	 public function __construct(Request $request, Guard $auth, User $user) {
        $this->request = $request;
         $this->user = $user; 
        $this->auth = $auth;
       // $this->auth = $auth;
    }

    public function getToken(){
    return Response::json(['token'=>csrf_token()]);

}   

	public function getApiSignup (Request $request)
	{	
		$input = $request->all();   
    $oldemail=  User::where('email', $input['uemail'])->value('email');
    //var_dump($oldemail); die();
		//$value=	count($input);
        $validator = Validator::make($input, [        
        'ufirstname' => 'required',
        'ulastname' => 'required',
        'ugender' => 'required',
        'upassword' => 'required|min:6',
        //'email' => $input['uemail'],
        'uemail' => 'required|email'
        ]);    

	if (!$validator->fails()){
    if($oldemail != $input['uemail'] && $oldemail='null'){     
        $User = new User;
        $Lang =new Language;
        $Gidarea =new GuideArea;
        $Profile =new Profile;
        $Guide =new Guide;
       // $Assign_role = new Assign_role;
        $token = $request->session()->token();      
    $User->fname = $input['ufirstname'];
    $User->lname =$input['ulastname'];
    $User->username ='Guide';    
    $User->email =$input['uemail'];
    $User->password =Hash::make($input['upassword']);    
    $User->gender = $input['ugender'];
    $User->remember_token =$token;
    //var_dump($User); die();
    $User->save();  

    $regid=User::where('email', $input['uemail'])->value('id');
    if (!(empty($regid))){
    //var_dump($regid); die();
    $Profile->user_id = $regid;
    $Profile->phone =$input['umobile'];
    if($input['ulang']=='en'){
    $Profile->language='1';
    }
    if ($input['ulang']=='fr') {
    $Profile->language='2';
    }
    if($input['ulang']=='cn'){
    $Profile->language='40';
    }
    $Profile->save();
    $Guide->user_id = $regid;
    $Guide->gid = $regid;
    $Guide->save();

    $webid=Language::all('id', 'language');    
    $Guidearea= Guidearea::all('id', 'guide_area');    

    //$json = json_decode($Guidearea);     
    $json= json_encode($Guidearea);
    $json = preg_replace('/guide_area/', 'name', $json);
    $json=json_decode($json);    
            
    $date=date_create();
    $date= date_format($date,"Y-m-d");

    $charge = DB::table('settings')->select('charges')->where('id', 1)->get();
    $charge=$charge[0]->charges;
            
    	return response()->json([                
                "response"=>[
                [                
                "rcode" => 0,
                "rmessage" =>"Register successfully",
                "id"=>$regid,
       		 	    "today"=> $date,
                "servicecharge"=>$charge, 
       		 	    "websitelanguages"=>$webid,
			          "guidingareas"=>$json					
				        ]]
               ])->header('Content-Type', 'application/json;charset=utf-8');	
			}else{  
              return response()->json([
          "response"=>[
          [
            "rcode" => 1,
            "rmessage" =>"Sorry Server Problem Could not Register..!"
          ]]            
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }else{
      return response()->json([
          "response"=>[
          [
            "rcode" => 1,
            "rmessage" =>"Email already Registered ["  .$input['uemail'] ."] Try Again with new Email..."
          ]]            
          ])->header('Content-Type', 'application/json;charset=utf-8');
    }
      }
		 else {  
		  return response()->json([
		  		"response"=>[
		  		[
            "rcode" => 1,
            "rmessage" =>"Validation Fail Register Fail"
        	]]          	
          ])->header('Content-Type', 'application/json;charset=utf-8');
          }
          
      //User::create($request->all());
	}

    public function getApiLogin(Request $request){
      $credentials = $request->all();
       //$credentials = json_encode($credentials);
      
     
      //$json = Input::all();       
    // Applying validation rules.

    $rules = array(
        'uemail' => 'required|email',
        'upassword' => 'required|min:6',
         );   
    $validator = Validator::make($credentials, $rules);
    //var_dump($validator); die();
    if ($validator->fails($credentials, $rules)){
      // If validation falis redirect back to login.
        return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Not Parameters Found!"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
     
    }
    else {     
       
        $date=date_create();
        $date= date_format($date,"Y-m-d");  
         
        $utype=0;
           
        if (Auth::attempt(['email' => $request->uemail, 'password' => $request->upassword])) {          
          
             $mailid=User::where('email', $request->uemail)->value('id');
            if($mailid==Guide::where('gid', $mailid)->value('gid')){              
        $vid=User::where('email', $request->uemail)->value('id');
        $vfname=User::where('email', $request->uemail)->value('fname');
        $vlname=User::where('email', $request->uemail)->value('lname');
        $vgender=User::where('email', $request->uemail)->value('gender');
        if($vgender=='male' || $vgender=='Male'){
          $vgender=0;
        }elseif($vgender="female" || $vgender=='Female'){
          $vgender=1;
        }else{
          $vgender=2;
        }
        $vconfirm=User::where('email', $request->uemail)->value('confirmed');
        if($vconfirm==0)
        {
          $vconfirm="False";
        }else{
          $vconfirm ="True";
        }

        $videourl = DB::table('gallerys')
            ->join('users', 'users.id', '=', 'gallerys.user_id') 
            ->where('users.id' , '=', $vid)
            ->where('gallerys.type', '=', 'video')                 
            ->select('gallerys.id', 'gallerys.path')
            ->get();

            $videourl= json_encode($videourl);           
            $videourl = preg_replace('/path/', 'video', $videourl);
            $videourl=json_decode($videourl);
            //var_dump($videourl); die();

       // $mguidearea =Guidearea::all('id', )
        $mguidearea = DB::table('profiles')
            ->join('users', 'users.id', '=', 'profiles.user_id') 
            ->where('users.id' , '=', $vid)                 
            ->select('profiles.*')
            ->get();            
            //var_dump($mguidearea); die();
            $skill=$mguidearea[0]->specilizedarea;           
            $about=$mguidearea[0]->about;
            $experience=$mguidearea[0]->experience;
            $languageid=$mguidearea[0]->language;
            $languageid = (int)$languageid;
            $profile_img = $mguidearea[0]->profileImg;
            $profilebusydate = $mguidearea[0]->busydate;

             


                       
            
            $mainguidingareaid=$mguidearea[0]->mGuidingArea; 
            $mainguidingareaid = (int)$mainguidingareaid;

            //var_dump($mainguidingareaid); die();
            $otherguidingareaid=Guidearea::all('id');

            
            $rate = DB::table('guides')
            ->join('users', 'users.id', '=', 'guides.user_id') 
            ->where('users.id' , '=', $vid)                 
            ->select('guides.price')
            ->get();
            $rate=$rate[0]->price;              

            $users = DB::table('gallerys')->select('id', 'type')->where('user_id', $vid)->get();
           // $lic=array();
            foreach ($users as $name => $value) {
              $users= $value->type;
               if (($value->type=='license')) {
             $lic = $value->type;
            }
            if (($value->type=='image')) {
             $img = $value->type;
            }
            if (($value->type=='video')) {
             $vido = $value->type;
            }
            }          
           
           if(!empty($lic)){
            $gallerycret = DB::table('gallerys')
            ->join('users', 'users.id', '=', 'gallerys.user_id')            
            ->where('users.id' , '=', $vid)
            ->where ('type' , '=' , $lic)                 
            ->select('gallerys.id', 'gallerys.path')
            ->get();
           // var_dump($gallerycret); die();
            //$gallerycret= json_encode($gallerycret);           
            //$gallerycret = preg_replace('/path/', 'image', $gallerycret);              
           
            $gallerycret= json_encode($gallerycret);           
            $gallerycret = preg_replace('/path/', 'image', $gallerycret);
            $gallerycret=json_decode($gallerycret); 
            //var_dump($gallerycret); die();

             
            
           // $gallerycret= stripslashes($gallerycret, '/'); 
          }else{
            $gallerycret= [];
          }

          if(!empty($img)){
            $galleryimg = DB::table('gallerys')
            ->join('users', 'users.id', '=', 'gallerys.user_id')            
            ->where('users.id' , '=', $vid)
            ->where ('type' , '=' , $img)                 
            ->select('gallerys.id', 'gallerys.path')
            ->get();
          $galleryimg= json_encode($galleryimg);           
            $galleryimg = preg_replace('/path/', 'image', $galleryimg); 
            $galleryimg=json_decode($galleryimg);
             
            
            //var_dump($gallerycret); die();
             
          }else{
            $galleryimg= [];
          }

          if(!empty($vido)){
            $galleryvido = DB::table('gallerys')
            ->join('users', 'users.id', '=', 'gallerys.user_id')            
            ->where('users.id' , '=', $vid)
            ->where ('type' , '=' , $vido)                 
            ->select('gallerys.id', 'gallerys.path')
            ->get(); 
             $galleryvido= json_encode($galleryvido);           
            $galleryvido = preg_replace('/path/', 'image', $galleryvido); 
            $galleryvido=json_decode($galleryvido);
          }else{
            $galleryvido =[];
          } 

          $booked = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.uid')
            ->join('guides', 'guides.gid' , '=', 'bookings.gid')
            ->where('users.id' , '=', $vid)                              
            ->select('bookings.dates')
            ->get();  
            //var_dump($booked); die();      
           
            $bookedjson= json_encode($booked);           
            $bookedjson = preg_replace('/dates/', 'day', $bookedjson);
            $bookedjson= json_decode($bookedjson); 
            //$bookedjson = explode(',', $bookedjson);
            //$array= array();
            //foreach($bookedjson as $bookedjson)
            //{
            //  $bookedjson=trim($bookedjson);
            //  $array[]= $bookedjson;
           // }
           //  var_dump($array);
           //  die();
                     
            
       // var_dump($jsondates); die();
//die();
            //$json=json_decode($json); 
          //  var_dump($bookedjson);die();
        $Guidearea= Guidearea::all('id', 'guide_area');
        $Weblang= Language::all('id', 'language');

    $Webjson = json_decode($Weblang);     
    $Webjson= json_encode($Webjson);
    $Webjson = preg_replace('/language/', 'name', $Webjson);
    $Webjson=json_decode($Webjson); 
     
     

    $json = json_decode($Guidearea);     
    $json= json_encode($json);
    $json = preg_replace('/guide_area/', 'name', $json);
    $json=json_decode($json); 

    $charge = DB::table('settings')->select('charges')->where('id', 1)->get();
    $charge=$charge[0]->charges;  
    //var_dump($charge);die();   
        return response()->json([        
        "response"=>[
                [                
                "rcode" => 0,
                "rmessage" =>"Login successfully",
               // "id"=>$val,
          "today"=> $date,
          "servicecharge"=>$charge,          
          "websitelanguages"=>$Webjson,
          "guidingareas"=>$json ,
          "usertype"=> $utype,
          "id" =>$vid,
          "isverified" => $vconfirm,
          "profileimage"=> $profile_img,
          "firstname" => $vfname ,
          "lastname"=> $vlname,
          "mobile"=> "999999999",
          "gender"=> $vgender,
          "userlanguages"=> [
          ["id" =>$languageid
          ] 
          ],
          "mainguidingarea" => $mainguidingareaid,
          "otherguidingareas"=>$otherguidingareaid,
          "specializedskill" => $skill,
          "aboutme" => $about,
          "experiencesince"=> $experience,
          "rate"=> $rate,
          "youtube" => $videourl,
        "bookeddays"=>$bookedjson,    
        "busydays"=>[
          [
        "day" => $date
          ]
                    ],
        "certificates"=> $gallerycret,
        "gallery"=>$galleryimg,
        "reviews"=>[  
        [  
        "id" =>$vid,
        "date" => $date,
        "travelerid" =>$vid,
        "nickname" =>'admin',
        "profileimage" =>"http://www.guidenp.com/traveler/traveler_1.jpg",
        "rating" =>4,
        "review" =>"new images"
        ]
                  ]
        ]
        ]])->header('Content-Type', 'application/json;charset=utf-8');
            }else{
              return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Your Guide..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
            }   
    }else
    {
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"These credentials do not match our records Try Again.. !"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}
}

public function getApiContact(Request $request){

    $input = $request->all();     
    //var_dump($input);die();  
          $Contact = new Contact;
           //Auth::logout();
   $user= Auth::User();    

    $validator = Validator::make($input, [
    'uname' => 'required',   
    'uemail' => 'required|email',
        ]);
if (Auth::check()) {
   if (!$validator->fails()){ 
      $Contact = new Contact;
      //var_dump('a'); die();
    
    $Contact->user_id= $user->id;
    $Contact->gid= $user->id;       
    $Contact->name = $input['uname'];
    $Contact->email =$input['uemail'];
    $Contact->comment =$input['umessage'];
    //var_dump($Contact); die();
    $Contact->save();

    return response()->json([
            "response"=>[
                [
                "rcode" => 0,
               "rmessage" =>"Message Send successfully."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Contact Message not Send. "
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
    
}else{
   if (!$validator->fails()){ 
      $Contact = new Contact;
      //var_dump('a'); die();
     
    $Contact->user_id= 0;
    $Contact->gid= 0;       
    $Contact->name = $input['uname'];
    $Contact->email =$input['uemail'];
    $Contact->comment =$input['umessage'];
    //var_dump($Contact); die();
    $Contact->save();

    return response()->json([
            "response"=>[
                [
                "rcode" => 0,
               "rmessage" =>"Message Send successfully."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Contact Message not Send. "
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}
   

}

public function getApiChangePassword(Request $request){

    $input = $request->all();      
    $user= Auth::User();
   // Auth::logout();
    //var_dump($user); die();

    $validator = Validator::make($input, [
    'uoldpassword' => 'required|min:6', 
    'unewpassword' => 'required|min:6',
        ]);  

    if (!$validator->fails()){       
    //var_dump('aaaa');die(); 
    $credentials = $request->only('ulang', 'utype','uid','uoldpassword', 'unewpassword');
    $oldpassword= $credentials['uoldpassword'];
    //var_dump($oldpassword);die();

   // $user = User::where('id', $credentials['uid'])->value('password');
   // var_dump($credentials['uid']); die();
    if (!empty($credentials['uid'])) {
      //var_dump('aaa'); die();
    if (empty($credentials['uid'])) 
        {
            return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Your Password Dont Match..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
            
        }
        else
        {    
            //$user= Auth::User();
            //var_dump($user); die();
            DB::table('users')
            ->where('id', $credentials['uid'])
            ->update(['password' => Hash::make($credentials['unewpassword'])]);             
             return response()->json([
            "response"=>[
                [
                "rcode" => 0,
               "rmessage" =>"Your successfully Change Password"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
        }
      }else{
        return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Session time out....Sorry please login!!!"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
      }
   
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}


public function getApiGuidebusydays(Request $request){
    $input = $request->all();   
    //$user= Auth::User();   
    $validator = Validator::make($input, [
    'uid' => 'required',
    'ubusydays' => 'required', 
    ]);  

    if (!$validator->fails()){ 
      if (!empty($input['uid'])){ 
      $Profile = Profile::firstOrNew(array(
      'user_id' => $input['uid']));    
    $Profile->busydate = $input['ubusydays']; 
    //var_dump($Booking); die();      
    $Profile->save();       
          
             return response()->json([
            "response"=>[
                [
                "rcode" => 0,
               "rmessage" =>"Your successfully Change Days"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');   
    }else{
      return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Session time out....Sorry please login!!!"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');

    }
  }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong Busydays..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}

public function getApiProfileimage(Request $request){
     $input = $request->only('ulang', 'utype','uid','ufilename');
    $file = $_FILES['ufilename']['name'];
    //$filename = preg_replace('"\.gni$"', '.jpg', $file);
          
     //$user= Auth::User();   
    //var_dump($input); die();   
    $validator = Validator::make($input, [
    'uid' => 'required',
    'ufilename' => 'required'
    ]);  

    if (!$validator->fails()){  
      if (!empty($input['uid'])){      
            $target_path = "uploads_app/profile/";
            $target_path= $target_path .basename($_FILES['ufilename']['name']);
            move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);
            $Profiles= DB::table('profiles')
            ->where('user_id', $input['uid'])
            ->update(['profileImg' => 'http://www.guidenp.devworkserver.com/uploads_app/profile/'. $file]);
                  
          return response()->json([
            "response"=>[
           [
            "rcode" => 0,            
            "rmessage" =>"Your successfully Upload Profile Images..!"
           // "id" =>$Profiles,
            //"image" =>$Profiles->profileImg          
            ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
         
          }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again or try again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong... Try Again...!"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}

public function getApiAddCertificate(Request $request){
    $input = $request->only('ulang','uid','ufilename');
    $file = $_FILES['ufilename']['name'];
    $filename = preg_replace('"\.gni$"', '.jpg', $file);
    
       
    //$user= Auth::User();    
  
    $validator = Validator::make($input, [
      'uid' => 'required',
      'ufilename' => 'required'
    ]);  

    if (!$validator->fails()){  
    if (!empty($input['uid'])){
       
        if (file_exists("uploads_app/license" . $_FILES["ufilename"]["name"]))
          {
          return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Image already Contains"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
          }
        else
          {
            $target_path = "uploads_app/license/";
            $target_path= $target_path .basename($_FILES['ufilename']['name']);
          move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);
          $Gallery = new Gallery; 
    //var_dump($Gallery); die();
    $Gallery->user_id = $input['uid'];
    //$Gallery->caption =$input['caption'];       
    $Gallery->path = 'http://www.guidenp.devworkserver.com/uploads_app/license/'. $file;
    $Gallery->type ='license';
   
    $Gallery->save();       
    return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Upload License Images..!",
          "id" =>$Gallery->id,
          "image" =>$Gallery->path
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
          }
       //move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);
       //move_uploaded_file($_FILES['file']['name'], $target_path);
      //$tmp_name = $_FILES["ufilename"]["name"];
     // $name = basename($_FILES["ufilename"]["name"]);
      //$target_path = "http://guidenp.devworkserver.com/public/uploads/";
      //move_uploaded_file($target_path, $name);
    //$target_path = "http://guidenp.devworkserver.com/public/uploads/";
    //$target_path = $target_path .basename($_FILES['ufilename']['name']);
   //$profiePic->move($target_path, $profiePic);
     
    
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}

public function getApiAddGallery(Request $request){
    $input = $request->only('ulang','uid','ufilename');
    $file = $_FILES['ufilename']['name'];
    //$filename = preg_replace('"\.gni$"', '.jpg', $file);      
    //$user= Auth::User();   
    $validator = Validator::make($input, [
      'uid' => 'required',
      'ufilename' => 'required'
    ]);  

    if (!$validator->fails()){  
    if (!empty($input['uid'])){       
        if (file_exists("uploads_app/gallery/" . $_FILES["ufilename"]["name"]))
          {
          return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Image already Contains"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
          }
        else
          {
            $target_path = "uploads_app/gallery/";
            $target_path= $target_path .basename($_FILES['ufilename']['name']);
          move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);
          $Gallery = new Gallery; 
    //var_dump($Gallery); die();
    $Gallery->user_id = $input['uid'];
    //$Gallery->caption =$input['caption'];       
    $Gallery->path = 'http://www.guidenp.devworkserver.com/uploads_app/gallery/'. $file;
    $Gallery->type ='image';
   
    $Gallery->save();       
    return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Upload License Images..!",
          "id" =>$Gallery->id,
          "image" =>$Gallery->path
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
          }
       //move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);
       //move_uploaded_file($_FILES['file']['name'], $target_path);
      //$tmp_name = $_FILES["ufilename"]["name"];
     // $name = basename($_FILES["ufilename"]["name"]);
      //$target_path = "http://guidenp.devworkserver.com/public/uploads/";
      //move_uploaded_file($target_path, $name);
    //$target_path = "http://guidenp.devworkserver.com/public/uploads/";
    //$target_path = $target_path .basename($_FILES['ufilename']['name']);
   //$profiePic->move($target_path, $profiePic);
     
    
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}


public function getApiDeleteCertificate(Request $request){
    $input = $request->only('ulang','uid','uimageid');       
    //$user= Auth::User();  
    $validator = Validator::make($input, [
      'uid' => 'required',
      'uimageid' => 'required', 
    ]);  

    if (!$validator->fails()){  
       if (!empty($input['uid'])){                 
          $Gallery= Gallery::find($input['uimageid']);          
          $Gallery-> delete();
      return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Deleted License Images..!"          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8'); 
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}


public function getApiDeleteGallery(Request $request){
    $input = $request->only('ulang','uid','uimageid');   
    //$user= Auth::User(); 
    $validator = Validator::make($input, [
      'uid' => 'required',
      'uimageid' => 'required', 
    ]);  

    if (!$validator->fails()){  
      if (!empty($input['uid'])){               
          $Gallery= Gallery::find($input['uimageid']);          
          $Gallery-> delete();
      return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Deleted Gallery Images..!"          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
  
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}

public function getApiSaveInfo(Request $request){  
    $input = $request->all(); 
    //Auth::logout();
    //var_dump($input); die();    
    //$user= Auth::User();    
    $validator = Validator::make($input, [
    'uid' => 'required', 
    ]);  

    if (!$validator->fails()){  
      if (!empty($input['uid'])){
            $User = User::firstOrNew(array(
            'id' => $input['uid']));
            $User->fname = $input['ufirstname'];
            $User->lname = $input['ulastname'];
            $User->gender = $input['ugender'];
            $User->save();
                       
    $Profile = Profile::firstOrNew(array(
      'user_id' => $input['uid']));    
    $Profile->phone = $input['umobile'];
    //$Profile->status = $input['status'];
    //$Profile->city = $input['uid'];
    //$Profile->country = $input['uid'];
    //$Profile->address = $input['uid'];
    $Profile->experience = $input['uexperience'];
    $Profile->mGuidingArea = $input['umainguidingarea'];
    $Profile->oGuidingArea = $input['uotherguidingareas'];
    $Profile->language = $input['ulanguages'];
    $Profile->specilizedarea = $input['uspecializedskilllocation'];
    $Profile->about = $input['uaboutme'];   
    $Profile->save();

    $Guides = Guide::firstOrNew(array(
      'user_id' => $input['uid']));
    $Guides->price = $input['urate'];
    $Guides->save();   
    //var_dump($Profile); die();       
    return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Save Profile..!"
          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}


public function getApiAddVideo(Request $request){
    $input = $request->only('ulang','uid','uvideourl');
    //$file = $_FILES['uvideourl']['name'];
    //$filename = preg_replace('"\.gni$"', '.jpg', $file);      
    //$user= Auth::User();   
    $validator = Validator::make($input, [
      'uid' => 'required',
      'uvideourl' => 'required'
    ]);  

    if (!$validator->fails()){  
    if (!empty($input['uid'])){
      $videourl=Gallery::where('user_id', $input['uid'])->where('path', $input['uvideourl'])->value('path');
      //var_dump($videourl); die();
            if($videourl== $input['uvideourl'])        
          {
          return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Video already Contains..!"
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
          }
        else
          {            
          $Gallery = new Gallery; 
          $Gallery->user_id = $input['uid'];           
          $Gallery->path = $input['uvideourl'];
          $Gallery->type ='video';   
          $Gallery->save();       
    return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Upload Youtube Video..!",
          "id" =>$Gallery->id,
          "image" =>$Gallery->path
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
          }  
    
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}

public function getApiDeleteVideo(Request $request){
    $input = $request->only('ulang','uid','uvideoid');   
    //$user= Auth::User(); 
    $validator = Validator::make($input, [
      'uid' => 'required',
      'uvideoid' => 'required' 
    ]);  

    if (!$validator->fails()){  
      if (!empty($input['uid'])){               
          $Gallery= Gallery::find($input['uvideoid']);          
          $Gallery-> delete();
      return response()->json([
      "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Deleted Youtube Video..!"          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
  
    }else{
       return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Session time out Login Again..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }  
    }else
    {
return response()->json([
            "response"=>[
                [
                "rcode" => 1,
               "rmessage" =>"Sorry Somethings went Wrong..."
                ]  
                ]           
               ])->header('Content-Type', 'application/json;charset=utf-8');
    }
}


}
        
        