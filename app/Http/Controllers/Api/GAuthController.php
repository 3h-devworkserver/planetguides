<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
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
use App\Classes\MCrypt;
use Carbon\Carbon;
//use App\Models\Assign_role;
use Input;
//use App\Http\Requests;
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
//Use Auth;
//use JWTAuth;
//use Tymon/JWTAuth/JWTAuth;
//use Tymon\JWTAuth\Facades\JWTAuth;

//use Illuminate \ Session \ TokenMismatchException;
//use App\Http\Requests\Frontend\Access\ResetPasswordRequest;
//use Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Mail;
use Image;

use File; 
//use list;
//use Intervention\Image\Facades\Image;


class GAuthController extends Controller
{
      //use ResetsPasswords;
   /*   public function __construct()
   {
       $this->middleware('guest');
   }
   */
       //protected $user; 
        //protected $auth;

   // hours used to invalidate token
   public $sessionTime = 1; // in hrs

   // public $siteUrl = 'http://www.guidenp.com/uploads/';
   // public $siteUrl = 'http://guidenp.devworkserver.com/uploads/';
   public $siteUrl = 'http://192.168.0.23/guidenplive3/uploads/';

   public function __construct(Request $request,  User $user) {
    $this->request = $request;
    $this->user = $user; 
        //$this->auth = $auth;
       // $this->auth = $auth;
  }


  public function getApiSignup (Request $request)
  {	
  //   $mcryptPass = new MCrypt();
  // $decryptedPass = $mcryptPass->encrypt('yojansh50@gmail.com');
  // // $decryptedPass = $mcryptPass->decrypt('aaaaa');
  // return $decryptedPass;

    $input = $request->all();
   // var_dump("服务器无法处理您的请求。 请再试一次。"); die();
    //$email =$input['uemail'];
    //var_dump($input['uemail']); die(); 
    $validator = Validator::make($input, [ 
      'ulang'       =>'required',       
      'ufirstname'  =>'required',
      'ulastname'   =>'required',
      'umobile'     =>'required|regex:/^\+?[^a-zA-Z]{10,}$/',
      'ugender'     =>'required',                       
        // 'uemail'      =>'required|email',
      'uemail'      =>'required',
      // 'upassword'   =>'required|min:6'
      'upassword'   =>'required'
      ]);   
    //condtion for message
    if(strtolower(trim($input['ulang'])) == 'fr'){
      $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";
      $notverifiedrmessage = "Cet e-mail est déjà enregistré. Nous vous avons envoyé un courriel à votre adresse e-mail. Veuillez confirmer votre e-mail pour continuer.";
      $verifiedrmessage = "Cette adresse e-mail est déjà enregistrée, veuillez choisir une adresse e-mail différente.";
      $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    }elseif (strtolower(trim($input['ulang']))== 'cn') {
      $prmessage= "服务器无法处理您的请求。 请再试一次。";
      $notverifiedrmessage = "此邮箱号已被注册。 我们已向您的电子邮件地址发送了一封电子邮件。 请验证您的电子邮件以继续。";
      $verifiedrmessage = "此电子邮件地址已注册，请选择其他电子邮件地址。";
      $otherrmessage = "服务器上发生未知错误。请再试一次。";
    }else{
      $prmessage= "Server is unable to process your request. Please try again.";
      $notverifiedrmessage = "This email is already registered. We have sent you an email to your email address. Please verify your email to continue.";
      $verifiedrmessage = "This email address is already registered, please choose a different email address.";
      $otherrmessage = "Unknown error occurred on server. Please try again.";
    }
    //condition for message end  

    

	if (!$validator->fails()){ //condition for validation start    

    //checking for valid email
    $email = $this->pre_test_email($input['uemail']);
        // return $email;
    if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (strlen($this->pre_test_password($input['upassword'])) < 6) ) {
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$prmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');   
    }


    $oldemail=  User::where('email', $email)->value('email');
    $emailconfirmed=  User::where('email', $email)->value('confirmed');  
    //var_dump($emailconfirmed); die();
    if($oldemail ==$email && $emailconfirmed== 0){ //condition for email and confirmed=0 start if
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$notverifiedrmessage
        ]]            
        ])->header('Content-Type', 'application/json;charset=utf-8');
      //condition for email and confirmed=0 end if
    }elseif ($oldemail ==$email && $emailconfirmed== 1) {//condition for email and confirmed=1start elseif
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$verifiedrmessage
        ]]            
        ])->header('Content-Type', 'application/json;charset=utf-8');
      //condition for email and confirmed=1 end elseif
    }else{ //condition for email and confirmed is not present previous start else
      if($oldemail != $email && $oldemail='null'){   //condition for email and confirmed is not present previous start if
        $User = new User;
        $Lang =new Language;
        $Gidarea =new GuideArea;
        $Profile =new Profile;
        $Guide =new Guide;       
        $token = $request->session()->token();
        $confirmation_code = str_random(30);
        Mail::send('email.verify', ['confirmation_code' =>$confirmation_code, 'fname'=>$input['ufirstname'], 'lname'=>$input['ulastname']], function($message) use($email)
        {
          $message
          ->to($email)            
          ->subject('GUIDENP - confirm your account');
        });   
    //Create new user and save in user table    
        $User->fname              =trim($input['ufirstname']);
        $User->lname              =trim($input['ulastname']);
        $User->username           =trim('Guide');    
    // $User->email              =trim($input['uemail']);
        $User->email              =$email;
        $User->password           =Hash::make($this->pre_test_password($input['upassword']));    
        $User->gender             =trim($input['ugender']);
        $User->remember_token     =trim($token);
        $User->confirmation_code  =trim($confirmation_code);    
        $User->save();   
    //end of create and save user   
    //Create profile of guide/traveller start with user table id
        $regid=User::where('email', $email)->value('id');
    if (!(empty($regid))){ //condition for user save id empty start if   
      $Profile->user_id   = trim($regid);
      $Profile->phone     =trim($input['umobile']);

      if(strtolower(trim($input['ulang']))=='en'){
        $Profile->language='1';
      }
      if (strtolower(trim($input['ulang']))=='fr') {
        $Profile->language='2';
      }
      if(strtolower(trim($input['ulang'])) =='cn'){
        $Profile->language='40';
      }
      $Profile->save();
    //end of profile create with user id

    //start of create guide with user id
      $Guide->user_id = $regid;
      $Guide->gid = $regid;
      $Guide->save();
    //end of create guide with user id

    //start assign role of create user with user id
      DB::table('assigned_roles')->insert(
        ['user_id' => $regid, 'role_id' => 2]);
    //end of  create user role with user id
/*
    $webid=Language::all('id', 'language');
    $webid= json_encode($webid);
    $webid = preg_replace('/language/', 'name', $webid);
    $webid=json_decode($webid); 

    $Guidearea= Guidearea::all('id', 'guide_area');      
    $Guidearea= json_encode($Guidearea);
    $Guidearea = preg_replace('/guide_area/', 'name', $Guidearea);
    $Guidearea=json_decode($Guidearea);    
            
    $date=date_create();
    $date= date_format($date,"Y-m-d");

    $charge = DB::table('settings')->select('charges')->where('id', 1)->get();
    $charge=$charge[0]->charges;
    */

    return response()->json([                
      "response"=>[
      [                
      "rcode" => 0,
      "rmessage" =>"User successfully Register.",
                //"id"=>$regid,
                //"today"=> $date,
                //"servicecharge"=>$charge, 
                //"websitelanguages"=>$webid,
                //"guidingareas"=>$Guidearea          
      ]]
      ])->header('Content-Type', 'application/json;charset=utf-8'); 
               //condition for user save id empty end if  

      }else{  //condition for user save id empty/not start else 
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]]            
          ])->header('Content-Type', 'application/json;charset=utf-8');
        //condition for user save id empty/not start else 
      }

    //condition for email and confirmed is not present previous end if
    }else{ //condition for email confirmed no present previous state else
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$otherrmessage
           // "rmessage" =>"Email already Registered ["  .$input['uemail'] ."] Try Again with new Email..."
        ]]            
        ])->header('Content-Type', 'application/json;charset=utf-8');
      //condition for email and confirmed is not present previous end else
    }
  } //condtion of else end  
}else {  
  return response()->json([
    "response"=>[
    [
    "rcode" => 1,
    "rmessage" =>$prmessage
    ]]          	
    ])->header('Content-Type', 'application/json;charset=utf-8');
}    
}

//decrpyt email
public function pre_test_email($data) {
  $data = trim($data);
    // $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $mcrypt = new MCrypt();
  $decryptedEmail = $mcrypt->decrypt($data);
  return $decryptedEmail;
} 

  //decrypt password
public function pre_test_password($data) {
  $data = trim($data);
  $mcryptPass = new MCrypt();
  $decryptedPass = $mcryptPass->decrypt($data);
  return $decryptedPass;
}

public function getApiLogin(Request $request){
  //    $mcryptPass = new MCrypt();
  // $decryptedPass = $mcryptPass->encrypt('aaaaaa');
  // // $decryptedPass = $mcryptPass->decrypt('aaaaa');
  // return $decryptedPass;

      // $mcrypt = new MCrypt();
    // return $decryptedEmail = $mcrypt->decrypt($request->upassword);
  $input = $request->all();
      //var_dump($input); die();
  $rules = array(
    'ulang'     =>'required',
        // 'uemail'    => 'required|email',
    'uemail'    => 'required',
    'upassword' => 'required|min:6',
        // 'uapptype'     =>'required',
        // 'uappversion'     =>'required'
    );

  $rules0 = array(
    'uapptype'     =>'required',
    'uappversion'     =>'required'
    );

         //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";
    $emailnotregisterrmessage = "Cette adresse e-mail n'est pas enregistrée. Veuillez vous inscrire pour créer un nouveau compte.";
    $emailregisternotverifiedrmessage = "Nous vous avons envoyé un courriel à votre adresse e-mail. Veuillez confirmer votre e-mail pour continuer.";
    $emailregisterverifiednopasswordrmessage = "Le mot de passe ne correspond pas. S'il vous plaît essayer à nouveau. Si vous avez oublié votre mot de passe, vous pouvez utiliser l'option Mot de passe oublié et nous vous enverrons un lien de réinitialisation à votre adresse e-mail.";
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $apptypeversion = "Une nouvelle version de l'application est disponible. Veuillez mettre à jour l'application pour continuer. Pour mettre à jour, ouvrez l'application Google Play Store, puis recherche guidenp et cliquez sur l'application et cliquez sur le bouton Mettre à jour.";
  }elseif (strtolower(trim($input['ulang'])) == 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";
    $emailnotregisterrmessage = "此电子邮件地址未注册。 请注册以创建新帐户。";
    $emailregisternotverifiedrmessage = "我们已向您的电子邮件地址发送了一封电子邮件。 请验证您的电子邮件以继续。";
    $emailregisterverifiednopasswordrmessage = "密码不匹配，请重试。 如果您忘记了密码，那么您可以使用忘记密码选项，我们将发送重置链接到您的电子邮件地址。";
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $apptypeversion = "有新版本的应用程序可用，请更新应用程序以继续。要更新，打开Play Store应用程序，然后搜索guidenp并单击该应用程序，然后单击更新按钮。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";
    $emailnotregisterrmessage = "This email address is not registered. Please sign up to create new account.";
    $emailregisternotverifiedrmessage = "We have sent you an email to your email address. Please verify your email to continue.";
    $emailregisterverifiednopasswordrmessage = "Password doesn't matches, please try again. If you forgot your password, then you may use forgot password option and we will send a reset link to your email address.";
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $apptypeversion = "A new version of application is available, Please update the application to continue. To update, open Google Play Store app, then search guidenp and click on the app and click Update button.";
  }
    //condition for message end 

    //checking if appversion and apptype is available or not   
  $validator0 = Validator::make($input, $rules0);
  if ($validator0->fails($input, $rules0)){
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$apptypeversion
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');  
  }


  $validator = Validator::make($input, $rules);   
  if ($validator->fails($input, $rules)){
      // If validation falis redirect back to login.
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');     
  }else { 
        //checking for valid email
    $email = $this->pre_test_email($input['uemail']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$prmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');   
    }
        // else{
        //   return "valid";
        // }
        //end of email validation

    $date=date_create();
    $date= date_format($date,"Y-m-d");        
        //var_dump($request->uemail); die(); 
       // var_dump(Auth::attempt('email'=>$request->uemail)); die();  
    $oldemail=  User::where('email', $email)->value('email');
    $emailconfirmed=  User::where('email', $email)->value('confirmed');
    $password=  User::where('email', $email)->value('password');  
    if ($oldemail != $email) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$emailnotregisterrmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }elseif ($oldemail ==$email && $emailconfirmed== 0) {
     return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$emailregisternotverifiedrmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   }elseif(($oldemail ==$email) && (($emailconfirmed== 1) && (!Hash::check($this->pre_test_password($input['upassword']) ,$password )))) {
     return response()->json([
       "response"=>[
       [
       "rcode" => 1,
       "rmessage" =>$emailregisterverifiednopasswordrmessage
       ]  
       ]           
       ])->header('Content-Type', 'application/json;charset=utf-8');
   }else{            
    $mailid=User::where('email', $email)->value('id');
        //var_dump($mailid); die();



        if($mailid==Guide::where('gid', $mailid)->value('gid')){//checking guide
       // var_dump('a'); die();

//generating api token and storing in db
    $apiUser = User::where('email', $email)->first();
    $apiToken = $apiUser->api_token = str_random(60);
    $apiUser->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
    // return Carbon::now()->addHours($this->sessionTime);
    $apiUser->save();

          $utype=0;               
          $vid=User::where('email', $email)->value('id');
          $vfname=User::where('email', $email)->value('fname');
          $vlname=User::where('email', $email)->value('lname');
          $vgender=User::where('email', $email)->value('gender');
        // if($vgender=='male' || $vgender=='Male'){
        //   $vgender=0;
        // }elseif($vgender="female" || $vgender=='Female'){
        //   $vgender=1;
        // }else{
        //   $vgender=2;
        // }
        // edited by yojan
          if($vgender=='0'){
            $vgender=0;
          }elseif($vgender=='1'){
            $vgender=1;
          }else{
            $vgender=2;
          }
        //end of editing by yojan

        //addition of country, state, city --yojan
          $profile = Profile::where('user_id', $mailid)->first();
          $country = $profile->country;
          $state = $profile->state;
          $city = $profile->city;


          $vconfirm=User::where('email', $email)->value('confirmed');
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

          // $mguidearea =Guidearea::all('id', )
          $mguidearea = DB::table('profiles')
          ->join('users', 'users.id', '=', 'profiles.user_id') 
          ->where('users.id' , '=', $vid)                 
          ->select('profiles.*')
          ->get(); 
          $skill=$mguidearea[0]->specilizedarea;           
          $about=$mguidearea[0]->about;
          $experience=$mguidearea[0]->experience;
          $languageid=$mguidearea[0]->language;
            //$languageid = (int)$languageid;
          $languageid = explode(',', $languageid);            
          $arraylang = array();            
          foreach($languageid as $key=>$languageid) {              
            $outlang['id'] = $languageid;                        
            $arraylang[]= $outlang;            
          }  

          if($languageid== null)
          {
            $languageid= [];
          }else{              
            $languageid= json_encode($arraylang);                  
            $languageid=json_decode($languageid);
          }         

          $profile_img = $mguidearea[0]->profileImg;

          if($profile_img==null){
            $profile_img="";
          }else{
            $profile_img=$profile_img;
          }
          $profile_smallimg =$mguidearea[0]->profilesmallImg;
          if($profile_smallimg==null){
            $profile_smallimg="";
          }else{
            $profile_smallimg=$profile_smallimg;
          }

          $profilebusydate = $mguidearea[0]->busydate;
          $profilebusydate =str_replace('/', '-', $profilebusydate);          
          $profilebusydate = explode(',', $profilebusydate);
            // var_dump($profilebusydate); die();
          $count =count($profilebusydate);

            //var_dump($profilebusydate);die();            
          $array = array();
          foreach($profilebusydate as $key=>$profilebusydate) {              
            $out['day'] = $profilebusydate;                            
            $array[]= $out;             
          }          
          if (empty($profilebusydate['day'][0])) {
            $profilebusydate=[];                            
          }else{
            $profilebusydate= json_encode($array);                  
            $profilebusydate=json_decode($profilebusydate);
          }                       

          $mainguidingareaid=$mguidearea[0]->mGuidingArea;
          $otherguidingareaid=$mguidearea[0]->oGuidingArea;
          $otherguidingareaid = explode(',', $otherguidingareaid);            
          $array1 = array();            
          foreach($otherguidingareaid as $key=>$otherguidingareaid) {              
            $out1['id'] = $otherguidingareaid;                        
            $array1[]= $out1;             
          }  

          if($otherguidingareaid== null)
          {
            $otherguidingareaid= [];
          }else{

            $otherguidingareaid= json_encode($array1);                  
            $otherguidingareaid=json_decode($otherguidingareaid);
          }
          $mobile=$mguidearea[0]->phone;
          if($mobile==null){
            $mobile ="";
          }else{
            $mobile =$mobile;
          }
          $mainguidingareaid = (int)$mainguidingareaid;
            //var_dump($mainguidingareaid); die();
            //$otherguidingareaid=Guidearea::all('id');            
          $rate = DB::table('guides')
          ->join('users', 'users.id', '=', 'guides.user_id') 
          ->where('users.id' , '=', $vid)                 
          ->select('guides.price')
          ->get();
          $rate=$rate[0]->price;              

          $users = DB::table('gallerys')->select('id', 'type')->where('user_id', $vid)->get();

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
          ->select('gallerys.id', 'gallerys.path', 'gallerys.imagesmall')
          ->get();         
            //$gallerycret= json_encode($gallerycret);           
            //$gallerycret = preg_replace('/path/', 'image', $gallerycret);           
          $gallerycret= json_encode($gallerycret);           
          $gallerycret = preg_replace('/path/', 'image', $gallerycret);
            //$gallerycret = preg_replace('/small_path/', 'imagesmall', $gallerycret);
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
          ->select('gallerys.id', 'gallerys.path', 'gallerys.imagesmall')
          ->get();
          $galleryimg= json_encode($galleryimg);           
          $galleryimg = preg_replace('/path/', 'image', $galleryimg); 
            //$galleryimg = preg_replace('/small_path/', 'imagesmall', $galleryimg); 
          $galleryimg=json_decode($galleryimg);           
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
        if($charge==null){
          $charge= "";
        }else{
         $charge=$charge[0]->charges; 
       } 

        //edited-- yojan , for app version info
       $settings = DB::table('settings')->first();
       // var_dump($settings);die();

        //review
       $reviews = DB::table('reviews')
       ->join('users', 'users.id', '=', 'reviews.user_id')
       ->join('profiles', 'profiles.user_id' , '=', 'reviews.user_id')
       ->where('reviews.guide_id' , '=', $vid)                              
       ->select('reviews.id', 'reviews.date','reviews.user_id', 'users.fname',  'profiles.profileImg', 'reviews.rating', 'reviews.comment')
       ->orderBy('id', 'asc')
       ->get();

       $reviews= json_encode($reviews);
       $reviews = preg_replace('/user_id/', 'travelerid', $reviews);
       $reviews = preg_replace('/fname/', 'nickname', $reviews);
       $reviews = preg_replace('/profileImg/', 'profileimage', $reviews);
       $reviews = preg_replace('/profileImg/', 'profileimage', $reviews);
       $reviews = preg_replace('/comment/', 'review', $reviews);
       $reviews=json_decode($reviews); 
    //var_dump($reviews);die();   
       return response()->json([        
        "response"=>[
        [                
        "rcode" => 0,
        "rmessage" =>"Login successfully",
        "utoken" =>$apiToken,
               // "id"=>$val,
        "today"=> $date,
        "servicecharge"=>$charge,
        "androidversion"=> $settings->android_latest_version,
        "iphoneversion"=> $settings->iphone_latest_version,
        "websitelanguages"=>$Webjson,
        "guidingareas"=>$json ,
        "usertype"=> $utype,
        "id" =>$vid,
        "isverified" => $vconfirm,
        "profileimage"=> $profile_img,
        "profileimagesmall"=> $profile_smallimg,
        "firstname" => $vfname ,
        "lastname"=> $vlname,
        "mobile"=> $mobile,
        "gender"=> $vgender,
        "country"=> $country,
        "state"=> $state,
        "city"=> $city,
        "userlanguages"=>$languageid,
        "mainguidingarea" => $mainguidingareaid,
        "otherguidingareas"=>$otherguidingareaid,
        "specializedskill" => $skill,
        "aboutme" => $about,
        "experiencesince"=> $experience,
        "rate"=> $rate,
        "youtube" => $videourl,
        "bookeddays"=>$bookedjson,    
        "busydays"=>$profilebusydate,
        "certificates"=> $gallerycret,
        "gallery"=>$galleryimg,
        "reviews"=>$reviews
        ]
        ]])->header('Content-Type', 'application/json;charset=utf-8');
}else{
  return response()->json([
    "response"=>[
    [
    "rcode" => 1,
    "rmessage" =>$otherrmessage
    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
}   
}
}
}

public function getApiContact(Request $request){
  $input = $request->all();      
  $Contact = new Contact;           
    //$user= Auth::User();
    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";      
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
  }elseif (strtolower(trim($input['ulang'])) == 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";      
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $otherrmessage = "Unknown error occurred on server. Please try again.";
  }
    //condition for message end  
  $validator = Validator::make($input, [
    'ulang' =>'required',
    'uname' => 'required',   
    'uemail' => 'required|email',
    'umessage' => 'required'
    ]);
  if (Auth::check()) {
   if (!$validator->fails()){ 
    $Contact = new Contact;    
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
  try {
    $Contact = new Contact;    
    $Contact->user_id= 0;
    $Contact->gid= 0;       
    $Contact->name = $input['uname'];
    $Contact->email =$input['uemail'];
    $Contact->comment =$input['umessage'];    
    $Contact->save();

    return response()->json([
      "response"=>[
      [
      "rcode" => 0,
      "rmessage" =>"Message Send successfully."
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  } catch (Exception $e) {
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$otherrmessage
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
    "rmessage" =>$prmessage
    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
}
}
}

public function getApiChangePassword(Request $request){

  $input = $request->all();      
  $user= Auth::User(); // i think it is useless in this context --yojan
   // Auth::logout();

    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";
    $oldpasswordnotmatch = "L'ancien mot de passe que vous avez fourni ne correspond pas. S'il vous plaît essayer à nouveau.";    
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";
    $oldpasswordnotmatch = "未经授权的请求。";   
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";
    $oldpasswordnotmatch = "The old password you provided doesn't match. Please try again";
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end  
  $validator = Validator::make($input, [
    'uid' =>'required',
    'ulang'=>'required',
    'utoken'=>'required|size:60',
    // 'uoldpassword' => 'required|min:6', 
    'uoldpassword' => 'required', 
    // 'unewpassword' => 'required|min:6'
    'unewpassword' => 'required'
    ]);  

  if (!$validator->fails()){ 

    //$credentials = $request->only('ulang', 'utype','uid','uoldpassword', 'unewpassword');
    $oldpassword= $this->pre_test_password($input['uoldpassword']);
    // return $oldpassword;
    $newpassword= $this->pre_test_password($input['unewpassword']);

//check if old and new password has min length of 6
    if ((strlen($oldpassword)<6 ) || (strlen($newpassword)<6 ) ){
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$prmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

//check if user exists or not
    $exists = User::find(trim($input['uid']));
    if (empty($exists)) {
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    //var_dump($oldpassword);die();
    $epassword = User::where('id', trim($input['uid']))->value('password');
    //$oldemail=  User::where('email', trim($input['uemail']))->value('email');
    //$emailconfirmed=  User::where('email', trim($input['uemail']))->value('confirmed');
   // $password=  User::where('email', trim($input['uemail']))->value('password');
    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
    //var_dump($role_id); die();

    if (empty(trim($input['uid'])) && $role_id==1) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }elseif ((!Hash::check($oldpassword ,$epassword ))) {
     return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$oldpasswordnotmatch
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   }else{
    try {
     DB::table('users')
     ->where('id', trim($input['uid']))
     ->update(['password' => Hash::make($newpassword),
               'api_token_expiry_date' => Carbon::now()->addHours($this->sessionTime)
            ]);             
     return response()->json([
      "response"=>[
      [
      "rcode" => 0,
      // "rmessage" =>"Your successfully Change Password"
      "rmessage" =>"Your Password has been successfully Changed"
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   } catch (Exception $e) {
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$otherrmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}       
}else{
  return response()->json([
    "response"=>[
    [
    "rcode" => 1,
    "rmessage" =>$prmessage
    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
}
}


public function getApiGuidebusydays(Request $request){
  $input = $request->all();   
    //$user= Auth::User(); 
     //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang'])) == 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end    
  $validator = Validator::make($input, [
    'uid'       => 'required',
    'ulang'     =>'required',
    'ubusydays' => 'required',
    'utoken' => 'required|size:60'
    ]);  

  if (!$validator->fails()){ 

    //check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    
   $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
    //var_dump($role_id); die();

   //check if user exists or not
   $exists = User::find(trim($input['uid']));

   // if (empty($input['uid']) && ($role_id==1 && $role_id==3)) {  //error in logic
   if (empty($exists) || $role_id==1 || $role_id==3 ) { 
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$userid_adminid
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }else{ 
    try {
      $Profile = Profile::firstOrNew(array(
        'user_id' => trim($input['uid'])));    
      $Profile->busydate = trim($input['ubusydays']); 
    //var_dump($Booking); die();      
      $Profile->save();   

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save();

      return response()->json([
        "response"=>[
        [
        "rcode" => 0,
        // "rmessage" =>"Your successfully Change Days"
        "rmessage" =>"You have successfully changed Days"
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');   
    } catch (Exception $e) {
     return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$otherrmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');  
   }  
 }
}else
{
  return response()->json([
    "response"=>[
    [
    "rcode" => 1,
    "rmessage" =>$prmessage
    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
}
}

// edited by -- yojan, ishwor dai's code is commented below
public function getApiProfileimage(Request $request){
  // return "here";
  $input = $request->only('ulang', 'utype','uid','ufilename', 'utoken');
    //$file = $_REQUEST['ufilename'];
   // $image = $request->file('ufilename');
    //$file =$request->file('ufilename')->getClientOriginalName();

 //   //$file = $_FILES['ufilename']['name']; 
    //$imagename = time().'.'.$file->getClientOriginalExtension(); 

// return response()->json([
//              "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$file
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');



    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end     
  $validator = Validator::make($input, [
    'uid'       => 'required',
    'ulang'     =>'required',
    'ufilename' => 'required',
    'utoken' => 'required|size:60'
    ]);

  if (!$validator->fails()){

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');

     //check if user exists or not
   $exists = User::find(trim($input['uid']));

    if (empty($exists) || $role_id==1) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
      try {
        $file   = $_FILES['ufilename']['name'];
            //$image1   = $_FILES['ufilename']['name'];
        $uploadedfilename = $_FILES['ufilename']['tmp_name'];
            // $uploadedfilename1 = $_FILES['ufilename']['tmp_name']; 

            //$filename = stripslashes($_FILES['ufilename']['name']);//whole filename e.g-123123123.jpg

            //$extension = strtolower(getExtension($filename));
            //$extension  = pathinfo($filename, PATHINFO_EXTENSION);//give extension name e.g-jpg
           // $pathfilename = pathinfo($filename, PATHINFO_FILENAME);//givefilename e.g-123123123

            //$filenames  = pathinfo($filename, PATHINFO_FILENAME);
           // $imageRealPath  =   $image->getRealPath();//notworking

        $new        = rand(0000,9999);
            //$newfilename=$new.$filename;           

            //$size=filesize($_FILES['ufilename']['tmp_name']);
            //$wh =getimagesize($uploadedfilename);
           // $img_width =$wh[0];
           // $img_height =$wh[1];
        $random = time();
            //$target_path = 'uploads_app/profile/';
            //$target_pathsmall ='uploads_appresize/profile/';
           // $move =move_uploaded_file($uploadedfilename,$target_path.$new.$image);
           // $target_pathsmall ='uploads_appresize/profile/'. $random.'_'. $image1;
//$extension = $uploadedfilename->getClientOriginalExtension();
            //$result = File::makeDirectory('/uploads/'.$input['uid']);

        $path ='uploads/'.trim($input['uid']).'/original/profilePic/';
        $pathresize ='uploads/'.trim($input['uid']).'/resize/profilePic/';
        if(!File::exists($path) && !File::exists($pathresize)) {
          File::makeDirectory('uploads/'.trim($input['uid']).'/original/profilePic/', 0775, true);
          File::makeDirectory('uploads/'.trim($input['uid']).'/resize/profilePic/', 0775, true);
          $target_path = 'uploads/'.trim($input['uid']).'/original/profilePic/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/profilePic/'. $random.'_'. $file;

          $move = move_uploaded_file($uploadedfilename, $target_path);

        }else{
          $target_path = 'uploads/'.trim($input['uid']).'/original/profilePic/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/profilePic/'. $random.'_'. $file;
          $move =move_uploaded_file($uploadedfilename,$target_path);
        }
        if ($move) {
          $target_path = 'uploads/'.trim($input['uid']).'/original/profilePic/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/profilePic/'. $random.'_'. $file;
               // $ratio=0.3;          
               // $target_width =$img_width*$ratio;
               // $target_width =intval($target_width); 
              //  $target_height =$img_height*$ratio;
              //  $target_height =intval($target_height);

          $ratio=0.3;          
                // $target_width =$img_width*$ratio;
                // $target_width =intval($target_width); 
                // $target_height =$img_height*$ratio;
                // $target_height =intval($target_height);

          $img = Image::make($target_path);
          $height = $img->height();
          $width = $img->width();

          $img->resize($width* $ratio,  $height* $ratio);
          $img->save($target_pathsmall);

                  //$img = Image::make($target_path.$new.'_'.$image);
                 // $img->resize($target_width,  $target_height);
                 // $img->save($target_pathsmall);



          $Profiles= DB::table('profiles')         
          ->where('user_id', trim($input['uid']))
          ->update(['profileImg' => $this->siteUrl.trim($input['uid']).'/original/profilePic/'.$new.'_'.$file,
            'profilesmallImg' =>$this->siteUrl.trim($input['uid']).'/resize/profilePic/'.$random.'_'.$file]);
          $profileImg =DB::table('profiles')->where('user_id' , trim($input['uid']))->value('profileImg');
          $profilesmallImg =DB::table('profiles')->where('user_id' , trim($input['uid']))->value('profilesmallImg');
          
          //update token expiry date  
          $updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
          $updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
          $updateTokenDate->save();
          
          return response()->json([
            "response"=>[
            [
            "rcode" => 0,            
            "rmessage" =>"Your successfully Upload Profile Images..!",
            "id" =>trim($input['uid']),
            "image" =>$profileImg,
            "imagesmall" =>$profilesmallImg                
            ]  
            ]           
            ])->header('Content-Type', 'application/json;charset=utf-8');
        }else{
          return response()->json([
           "response"=>[
           [
           "rcode" => 1,
           "rmessage" =>$otherrmessage
           ]  
           ]           
           ])->header('Content-Type', 'application/json;charset=utf-8');
        }

      } catch (Exception $e) {
        return response()->json([
         "response"=>[
         [
         "rcode" => 1,
         "rmessage" =>$otherrmessage
         ]  
         ]           
         ])->header('Content-Type', 'application/json;charset=utf-8');
      } 
    }       
  }else{
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}

//done by --ishwor dai
// public function getApiProfileimage(Request $request){
//     $input = $request->only('ulang', 'utype','uid','ufilename');
//     //$file = $_REQUEST['ufilename'];
//    // $image = $request->file('ufilename');
//     //$file =$request->file('ufilename')->getClientOriginalName();

//  //   //$file = $_FILES['ufilename']['name']; 
//     //$imagename = time().'.'.$file->getClientOriginalExtension(); 
// /*    
// return response()->json([
//              "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$file
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');

//     */           

//     //condtion for message
//     if(trim($input['ulang']) == 'fr'){
//       $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
//       $userid_adminid = "Demande non autorisée.";          
//       $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
//     }elseif (trim($input['ulang'])== 'cn') {
//       $prmessage= "服务器无法处理您的请求。 请再试一次。";   
//       $userid_adminid = "未经授权的请求。";       
//       $otherrmessage = "服务器上发生未知错误。请再试一次。";
//     }else{
//       $prmessage= "Server is unable to process your request. Please try again.";      
//       $userid_adminid = "Unauthorized request";     
//       $otherrmessage = "Unknown error occurred on server. Please try again.";
//     }       
//     //condition for message end     
//     $validator = Validator::make($input, [
//     'uid'       => 'required',
//     'ulang'     =>'required',
//     'ufilename' => 'required'
//     ]);

//     if (!$validator->fails()){
//       $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
//       if (empty($input['uid']) && $role_id==1) { 
//           return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$userid_adminid
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//         }else{
//           try {
//            // $file = $_FILES['ufilename']['name'];

//             //resize
//             //$thumb_img = Image::make($file)->resize(100, 100);
//            // $thumb_img->save('uploads_appresize/profile/'.$file ,80);
//             //$uploadedfile = $_FILES['ufilename']['name'];

//             $image   = $_FILES['ufilename']['name'];
//             $image1   = $_FILES['ufilename']['name'];
//             $uploadedfilename = $_FILES['ufilename']['tmp_name'];
//             $uploadedfilename1 = $_FILES['ufilename']['tmp_name']; 

//             $filename = stripslashes($_FILES['ufilename']['name']);//whole filename e.g-123123123.jpg

//             //$extension = strtolower(getExtension($filename));
//             $extension  = pathinfo($filename, PATHINFO_EXTENSION);//give extension name e.g-jpg
//             $pathfilename = pathinfo($filename, PATHINFO_FILENAME);//givefilename e.g-123123123

//             //$filenames  = pathinfo($filename, PATHINFO_FILENAME);
//            // $imageRealPath  =   $image->getRealPath();//notworking

//             $new        = rand(0000,9999);
//             $newfilename=$new.$filename;           

//             $size=filesize($_FILES['ufilename']['tmp_name']);
//             $wh =getimagesize($uploadedfilename);
//             $img_width =$wh[0];
//             $img_height =$wh[1];
//             $random = time();
//             $target_path = 'uploads_app/profile/';
//             //$target_pathsmall ='uploads_appresize/profile/';
//            // $move =move_uploaded_file($uploadedfilename,$target_path.$new.$image);
//             $target_pathsmall ='uploads_appresize/profile/'. $random.'_'. $image1;
// //$extension = $uploadedfilename->getClientOriginalExtension();


//             $move1 =move_uploaded_file($uploadedfilename1,$target_pathsmall);
//             $move =move_uploaded_file($uploadedfilename,$target_path.$new.'_'.$image);




//               if ($move1) {
//                 //$random = time();
//                // $file_resizename =$request->file('ufilename')->getClientOriginalName();
//                // $filename_resize = $random . '_' . $file_resizename;
//                 //$target_pathsmall ='uploads_appresize/profile/'. $filename_resize;
//                 //$image1   = $_FILES['ufilename']['name'];
//                 //$uploadedfilename1 = $_FILES['ufilename']['tmp_name']; 

//                // $target_pathsmall ='uploads_appresize/profile/'. $image1;

//                // move_uploaded_file($uploadedfilename1,$target_pathsmall);



// //$file =$request->file('ufilename')->getRealPath();

//                 // $img =Image::make($target_path.$new.'_'.$image);
//                 // $img->resize(200, 200);
//                 // $img->insert('public/watermark.png');
//                 // $img->save($target_pathsmall);

//                // $target_path = 'uploads_app/profile/';
//                 //$image   = $_FILES['ufilename']['name'];


//                // $path =getimagesize('uploads_app/profile/'.$new.'_'.$image);
//                // $file ='uploads_app/profile/'.$newfilename;
//               //$file_basename =basename($file);
//           //$file_real= $file_basename->getRealPath();

//          // $filename = $_FILES['ufilename']['name'];
//           //$info = pathinfo($filename);       
//           //$file_name = $info['filename'];          
//           //$img_width =$path['0'];
//           //$img_height =$path['1'];

//           //var_dump($img_width.'/'.$img_height ); die(); 
//           $ratio=0.3;          
//           $target_width =$img_width*$ratio;
//           $target_width =intval($target_width); 
//           $target_height =$img_height*$ratio;
//           $target_height =intval($target_height);
//           //$uploadedfilename1 = $_FILES['ufilename']['tmp_name']; 
//           // $movesmall =move_uploaded_file($uploadedfilename1,$target_pathsmall.$random.$image);

//           // $img =Image::make($target_path.$new.$image);  

//           // $img->resize(100, 100);
//           //$img->save($target_pathsmall.$random.$image);
//                  //$movesmall =move_uploaded_file($uploadedfilename,$target_pathsmall.$random.$image);


//               // $imagedata =Image::make($target_pathsmall.$new.$image, $target_path.$new.'_'.$image)->resize(200,200)->save(); 
//                // $new = imagecreatetruecolor($target_width, $target_height);
//           //$movesmall =move_uploaded_file($uploadedfilename1,$target_pathsmall.$random.'_'.$image);
//                 // $img =imagecopyresampled($new, $uploadedfilename1,0, 0, 0, 0,$target_width, $target_height, $img_width, $img_height);
//               //  move_uploaded_file($img, "uploads_appresize/$profile");

//            $Profiles= DB::table('profiles')         
//             ->where('user_id', trim($input['uid']))
//             ->update(['profileImg' => 'http://www.guidenp.com/uploads_app/profile/'.$new.'_'.$image,
//               'profilesmallImg' =>'http://www.guidenp.com/uploads_appresize/profile/'.$random.'_'.$image1]);
//         // $profileImg =DB::table('profiles')->where('user_id' , trim($input['uid']))->value('profileImg');
//          // $profilesmallImg =DB::table('profiles')->where('user_id' , trim($input['uid']))->value('profilesmallImg');


//            return response()->json([
//             "response"=>[
//            [
//             "rcode" => 0,            
//             "rmessage" =>"Your successfully Upload Profile Images..!",
//             "id" =>$input['uid'],
//             "image" =>'http://www.guidenp.com/uploads_app/profile/'.$new.'_'.$image,
//             "imagesmall" =>'http://www.guidenp.com/uploads_appresize/profile/'.$random.'_'.$image1                
//             ]  
//           ]           
//           ])->header('Content-Type', 'application/json;charset=utf-8');
// }else{
//               return response()->json([
//              "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$otherrmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//             }

//             //imagecopyresampled($uploadedfilename,0,0,0,0,0,20,20, $img_width,$img_height);
//            //$filename = "uploads_appresize/profile/".$newfilename;

//             //imagejpeg(0,$filename,100);


//             //Image::make($_FILES['ufilename']['tmp_name'])->resize(468, 249)->save($target_pathsmall);





//             /*die();
//            // move_uploaded_file($_FILES['ufilename']['tmp_name'], $target_path);

//            $Profiles= DB::table('profiles')
//             ->where('user_id', $input['uid'])
//             ->update(['profileImg' => 'http://www.guidenp.com/uploads_app/profile/'. $newfilename]);

//           //$src = imagecreatefromjpeg($uploadedfile);

//           $path =getimagesize('uploads_app/profile/'.$file);
//          // $file = $_FILES['ufilename']['name'];
//           $info = pathinfo($file);

//           // from PHP 5.2.0 :
//           $file_name = $info['filename'];


//           $img_width =$path['0'];
//           $img_height =$path['1'];

//           //var_dump($img_width.'/'.$img_height ); die(); 
//           $ratio=0.3;          
//           $target_width =$img_width*$ratio;
//           $target_width =intval($target_width); 
//           $target_height =$img_height*$ratio;
//           $target_height =intval($target_height);

//           //$img_src = imagecreatefromjpeg($file);
//           //$img_dst = imagecreatetruecolor($target_width, $target_height); 
// //thumbnail( $file, 'uploads_app/profile/', 'uploads_appresize/profile', 20, 20 );
//            //imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $target_width, $target_height, $img_width, $img_height);
//            //imagejpeg($img_dst, $new_img);
//           //$info = pathinfo($file);

//           // from PHP 5.2.0 :
//           //$file_name = $info['filename'];

//            //var_dump($image .$target_width); die();
//           //$image = Image::make($file_name);
//          // $image->resize($target_width, $target_height);
//           // $image->save('uploads_appresize/profile/'.$file_name);

//           return response()->json([
//             "response"=>[
//            [
//             "rcode" => 1,            
//             "rmessage" =>"Your successfully Upload Profile Images..!"
//             //"id" =>$input['uid'],
//            // "image" =>"http://www.guidenp.devworkserver.com/uploads_app/profile/".$file
//            "imagesmall" =>"http://www.guidenp.devworkserver.com/uploads_appresize/profile/".$file        
//             ]  
//           ]           
//           ])->header('Content-Type', 'application/json;charset=utf-8');
//           */
//          // Image::make($file)->resize(10, 10)->save('uploads_appresize/profile/' .str_random(11). '.'. 'jpg');
//           //$image = new Imagick($file);
//           //$image->thumbnailImage(20, 20);
//           //move_uploaded_file($image, 'uploads_appresize/profile/');


//           } catch (Exception $e) {
//             return response()->json([
//              "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$otherrmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//           } 
//         }       
//     }else{
// return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$prmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//     }
// }

// by -- yojan, commented code of ishwor dai below
public function getApiAddCertificate(Request $request){
  $input = $request->only('ulang','uid','ufilename','utoken');


 //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end    
  $validator = Validator::make($input, [
    'uid'       => 'required',
    'ulang'     =>'required',
    'ufilename' => 'required',
    'utoken' => 'required|size:60'
    ]);  

  if (!$validator->fails()){ 

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
     
     //check if user exists or not
     $exists = User::find(trim($input['uid']));

    if (empty($exists) || $role_id==1 || $role_id==3) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
      try {
        $file = $_FILES['ufilename']['name'];
        $uploadedfilename = $_FILES['ufilename']['tmp_name'];
              // $file1 = $_FILES['ufilename']['name'];
              // $uploadedfilename1 = $_FILES['ufilename']['tmp_name'];
             //$target_path = "uploads_app/license/";
             //$target_path1 = "uploads_appresize/license/";
        $new        = rand(0000,9999);
        $random = time();

            //$target_path= $target_path .basename($_FILES['ufilename']['name']);
          // move_uploaded_file($uploadedfilename1, $target_pathsmall);
        $path ='uploads/'.trim($input['uid']).'/original/license/';
        $pathresize ='uploads/'.trim($input['uid']).'/resize/license/';
        if(!File::exists($path) && !File::exists($pathresize)) {
          File::makeDirectory('uploads/'.trim($input['uid']).'/original/license/', 0775, true);
          File::makeDirectory('uploads/'.trim($input['uid']).'/resize/license/', 0775, true);
          $target_path = 'uploads/'.trim($input['uid']).'/original/license/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/license/'. $random.'_'. $file;

          $move = move_uploaded_file($uploadedfilename, $target_path);

        }else{
          $target_path = 'uploads/'.trim($input['uid']).'/original/license/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/license/'. $random.'_'. $file;

          $move = move_uploaded_file($uploadedfilename, $target_path);

        }


 // return "test1";
        if ($move) {
          $target_path = 'uploads/'.trim($input['uid']).'/original/license/'. $new. '_'. $file;
          $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/license/'. $random.'_'. $file;
                // return "here";
          $ratio=0.3;          
                // $target_width =$img_width*$ratio;
                // $target_width =intval($target_width); 
                // $target_height =$img_height*$ratio;
                // $target_height =intval($target_height);

          $img = Image::make($target_path);
          $height = $img->height();
          $width = $img->width();

          $img->resize($width* $ratio,  $height* $ratio);
          $img->save($target_pathsmall);


          $Gallery = new Gallery;   
          $Gallery->user_id = trim($input['uid']);
          //$Gallery->caption =$input['caption'];       
          $Gallery->path = $this->siteUrl.trim($input['uid']).'/original/license/'. $new.'_'. $file;
          $Gallery->imagesmall  = $this->siteUrl.trim($input['uid']).'/resize/license/'. $random. '_'. $file;
          $Gallery->type ='license';   
          $Gallery->save();

          //update token expiry date  
          $updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
          $updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
          $updateTokenDate->save();

          //$path =getimagesize('uploads_app/license/'.$file);
         // $file = $_FILES['ufilename']['name'];
          //$info = pathinfo($file);

          // from PHP 5.2.0 :
         // $file_name = $info['filename'];

          
         // $img_width =$path['0'];
         // $img_height =$path['1'];
          
          //var_dump($img_width.'/'.$img_height ); die(); 
          //$ratio=0.3;          
          //$target_width =$img_width*$ratio;
          //$target_width =intval($target_width); 
         // $target_height =$img_height*$ratio;
         // $target_height =intval($target_height);       
          return response()->json([
            "response"=>[
            [
            "rcode" => 0,
            "rmessage" =>"Your successfully Upload License Images..!",
            "id" =>$Gallery->id,
            "image" =>$Gallery->path,
            "imagesmall" =>$Gallery->imagesmall 
            ]  
            ]           
            ])->header('Content-Type', 'application/json;charset=utf-8');
        }

      } catch (Exception $e) {
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }

       /*
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
      */ 
        }else{
          return response()->json([
            "response"=>[
            [
            "rcode" => 1,
            "rmessage" =>$prmessage
            ]  
            ]           
            ])->header('Content-Type', 'application/json;charset=utf-8');
        }
      }

// by ---ishwor dai
// public function getApiAddCertificate(Request $request){
//     $input = $request->only('ulang','uid','ufilename');


//  //condtion for message
//     if(trim($input['ulang']) == 'fr'){
//       $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
//       $userid_adminid = "Demande non autorisée.";          
//       $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
//     }elseif (trim($input['ulang'])== 'cn') {
//       $prmessage= "服务器无法处理您的请求。 请再试一次。";   
//       $userid_adminid = "未经授权的请求。";       
//       $otherrmessage = "服务器上发生未知错误。请再试一次。";
//     }else{
//       $prmessage= "Server is unable to process your request. Please try again.";      
//       $userid_adminid = "Unauthorized request";     
//       $otherrmessage = "Unknown error occurred on server. Please try again.";
//     }       
//     //condition for message end    
//     $validator = Validator::make($input, [
//       'uid'       => 'required',
//       'ulang'     =>'required',
//       'ufilename' => 'required'
//     ]);  

//     if (!$validator->fails()){ 
//       $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
//       if (empty($input['uid']) && ($role_id==1 && $role_id==3)) { 
//           return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$userid_adminid
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//         }else{
//           try {
//               $file = $_FILES['ufilename']['name'];
//               $uploadedfilename = $_FILES['ufilename']['tmp_name'];
//               $file1 = $_FILES['ufilename']['name'];
//               $uploadedfilename1 = $_FILES['ufilename']['tmp_name'];
//              $target_path = "uploads_app/license/";
//              $target_path1 = "uploads_appresize/license/";
//              $new        = rand(0000,9999);
//               $random = time();
//               $target_path = 'uploads_app/license/'. $new. '_'. $file;
//               $target_pathsmall ='uploads_appresize/license/'. $random.'_'. $file1;

//             //$target_path= $target_path .basename($_FILES['ufilename']['name']);
//           move_uploaded_file($uploadedfilename1, $target_pathsmall);
//            move_uploaded_file($uploadedfilename, $target_path);
//           $Gallery = new Gallery;   
//           $Gallery->user_id = $input['uid'];
//           //$Gallery->caption =$input['caption'];       
//           $Gallery->path = 'http://www.guidenp.com/uploads_app/license/'. $new.'_'. $file;
//           $Gallery->imagesmall  = 'http://www.guidenp.com/uploads_appresize/license/'. $random. '_'. $file1;
//           $Gallery->type ='license';   
//           $Gallery->save();
//           //$path =getimagesize('uploads_app/license/'.$file);
//          // $file = $_FILES['ufilename']['name'];
//           //$info = pathinfo($file);

//           // from PHP 5.2.0 :
//          // $file_name = $info['filename'];


//          // $img_width =$path['0'];
//          // $img_height =$path['1'];

//           //var_dump($img_width.'/'.$img_height ); die(); 
//           //$ratio=0.3;          
//           //$target_width =$img_width*$ratio;
//           //$target_width =intval($target_width); 
//          // $target_height =$img_height*$ratio;
//          // $target_height =intval($target_height);       
//     return response()->json([
//       "response"=>[
//           [
//           "rcode" => 0,
//           "rmessage" =>"Your successfully Upload License Images..!",
//           "id" =>$Gallery->id,
//           "image" =>$Gallery->path,
//           "imagesmall" =>$Gallery->imagesmall 
//           ]  
//           ]           
//           ])->header('Content-Type', 'application/json;charset=utf-8');
//           } catch (Exception $e) {
//             return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$otherrmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//           }
//         }

//        /*
//         if (file_exists("uploads_app/license" . $_FILES["ufilename"]["name"]))
//           {
//           return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>"Image already Contains"
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//           }
//       */ 
//     }else{
// return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$prmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//     }
// }

 // edited by --yojan, commented below code of ishwor dai
      public function getApiAddGallery(Request $request){
        $input = $request->only('ulang','uid','ufilename', 'utoken');
        // $file = $_FILES['ufilename']['name'];
    //condition for message
        if(strtolower(trim($input['ulang'])) == 'fr'){
          $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
          $userid_adminid = "Demande non autorisée.";          
          $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
          $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
        }elseif (strtolower(trim($input['ulang']))== 'cn') {
          $prmessage= "服务器无法处理您的请求。 请再试一次。";   
          $userid_adminid = "未经授权的请求。";       
          $otherrmessage = "服务器上发生未知错误。请再试一次。";
          $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
        }else{
          $prmessage= "Server is unable to process your request. Please try again.";      
          $userid_adminid = "Unauthorized request";     
          $otherrmessage = "Unknown error occurred on server. Please try again.";
          $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
        }       
    //condition for message end   
        $validator = Validator::make($input, [
          'uid'       => 'required',
          'ulang'     =>'required',
          'ufilename' => 'required',
          'utoken' => 'required|size:60'
          ]); 
        if (!$validator->fails()){

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

          $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
       
//check if user exists or not
   $exists = User::find(trim($input['uid']));

          if (empty($exists) || $role_id==1 || $role_id==3 ) { 
            return response()->json([
              "response"=>[
              [
              "rcode" => 1,
              "rmessage" =>$userid_adminid
              ]  
              ]           
              ])->header('Content-Type', 'application/json;charset=utf-8');
          }else{
            try {

            //$target_path = "uploads_app/gallery/";
            //$target_path= $target_path .basename($_FILES['ufilename']['name']);

             $file = $_FILES['ufilename']['name'];
             $uploadedfilename = $_FILES['ufilename']['tmp_name'];
              // $file1 = $_FILES['ufilename']['name'];
              // $uploadedfilename1 = $_FILES['ufilename']['tmp_name'];
            // $target_path = "uploads_app/gallery/";
            // $target_path1 = "uploads_app/gallery/";
             $new        = rand(0000,9999);
             $random = time();
              //$target_path = 'uploads_app/gallery/'. $new. '_'. $file;
              //$target_pathsmall ='uploads_appresize/gallery/'. $random.'_'. $file;
            // move_uploaded_file($uploadedfilename1, $target_pathsmall);
             $path ='uploads/'.trim($input['uid']).'/original/gallery/';
             $pathresize ='uploads/'.trim($input['uid']).'/resize/gallery/';
             if(!File::exists($path) && !File::exists($pathresize)) {
              File::makeDirectory('uploads/'.trim($input['uid']).'/original/gallery/', 0775, true);
              File::makeDirectory('uploads/'.trim($input['uid']).'/resize/gallery/', 0775, true);
              $target_path = 'uploads/'.trim($input['uid']).'/original/gallery/'. $new. '_'. $file;
              $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/gallery/'. $random.'_'. $file;

              $move = move_uploaded_file($uploadedfilename, $target_path);

            }else{
              $target_path = 'uploads/'.trim($input['uid']).'/original/gallery/'. $new. '_'. $file;
              $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/gallery/'. $random.'_'. $file;

              $move = move_uploaded_file($uploadedfilename, $target_path);

            }
            //$move = move_uploaded_file($uploadedfilename, $target_path);

            if($move){
              $target_path = 'uploads/'.trim($input['uid']).'/original/gallery/'. $new. '_'. $file;
              $target_pathsmall ='uploads/'.trim($input['uid']).'/resize/gallery/'. $random.'_'. $file;

              $ratio=0.3;          
              $img = Image::make($target_path);
              $height = $img->height();
              $width = $img->width();

              $img->resize($width* $ratio,  $height* $ratio);
              $img->save($target_pathsmall);


              $Gallery = new Gallery;   
              $Gallery->user_id = trim($input['uid']);
            //$Gallery->caption =$input['caption'];       
              $Gallery->path = $this->siteUrl.trim($input['uid']).'/original/gallery/'. $new . '_' .$file;
              $Gallery->imagesmall  = $this->siteUrl.trim($input['uid']).'/resize/gallery/'. $random . '_'. $file;
              $Gallery->type ='image';   
              $Gallery->save();

        //update token expiry date  
          $updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
          $updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
          $updateTokenDate->save();

         // $path =getimagesize('uploads_app/gallery/'.$file);
         // $file = $_FILES['ufilename']['name'];
          //$info = pathinfo($file);

          // from PHP 5.2.0 :
         // $file_name = $info['filename'];


          //$img_width =$path['0'];
          //$img_height =$path['1'];

          //var_dump($img_width.'/'.$img_height ); die(); 
          //$ratio=0.3;          
          //$target_width =$img_width*$ratio;
          //$target_width =intval($target_width); 
          //$target_height =$img_height*$ratio;
         // $target_height =intval($target_height);       
              return response()->json([
                "response"=>[
                [
                "rcode" => 0,
                "rmessage" =>"Your successfully Upload License Images..!",
                "id" =>$Gallery->id,
                "image" =>$Gallery->path,
                "imagesmall" =>$Gallery->imagesmall 
                ]  
                ]           
                ])->header('Content-Type', 'application/json;charset=utf-8');
            }
          } catch (Exception $e) {
            return response()->json([
              "response"=>[
              [
              "rcode" => 1,
              "rmessage" =>$otherrmessage
              ]  
              ]           
              ])->header('Content-Type', 'application/json;charset=utf-8');
          }
        }      
      }else{
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$prmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }


// by -- ishwor dai
// public function getApiAddGallery(Request $request){
//     $input = $request->only('ulang','uid','ufilename');
//     $file = $_FILES['ufilename']['name'];
//     //condtion for message
//     if(trim($input['ulang']) == 'fr'){
//       $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
//       $userid_adminid = "Demande non autorisée.";          
//       $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
//     }elseif (trim($input['ulang'])== 'cn') {
//       $prmessage= "服务器无法处理您的请求。 请再试一次。";   
//       $userid_adminid = "未经授权的请求。";       
//       $otherrmessage = "服务器上发生未知错误。请再试一次。";
//     }else{
//       $prmessage= "Server is unable to process your request. Please try again.";      
//       $userid_adminid = "Unauthorized request";     
//       $otherrmessage = "Unknown error occurred on server. Please try again.";
//     }       
//     //condition for message end   
//     $validator = Validator::make($input, [
//       'uid'       => 'required',
//       'ulang'     =>'required',
//       'ufilename' => 'required'
//     ]); 

//     if (!$validator->fails()){  
//       $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
//       if (empty($input['uid']) && ($role_id==1 && $role_id==3)) { 
//           return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$userid_adminid
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//         }else{
//           try {

//             $target_path = "uploads_app/gallery/";
//             $target_path= $target_path .basename($_FILES['ufilename']['name']);

//              $file = $_FILES['ufilename']['name'];
//               $uploadedfilename = $_FILES['ufilename']['tmp_name'];
//               $file1 = $_FILES['ufilename']['name'];
//               $uploadedfilename1 = $_FILES['ufilename']['tmp_name'];
//              $target_path = "uploads_app/gallery/";
//              $target_path1 = "uploads_app/gallery/";
//              $new        = rand(0000,9999);
//               $random = time();
//               $target_path = 'uploads_app/gallery/'. $new. '_'. $file;
//               $target_pathsmall ='uploads_appresize/gallery/'. $random.'_'. $file1;
//             move_uploaded_file($uploadedfilename1, $target_pathsmall);
//             move_uploaded_file($uploadedfilename, $target_path);

//             $Gallery = new Gallery;   
//             $Gallery->user_id = $input['uid'];
//             //$Gallery->caption =$input['caption'];       
//             $Gallery->path = 'http://www.guidenp.com/uploads_app/gallery/'. $new . '_' .$file;
//             $Gallery->imagesmall  = 'http://www.guidenp.com/uploads_appresize/gallery/'. $random . '_'. $file1;
//             $Gallery->type ='image';   
//             $Gallery->save();

//          // $path =getimagesize('uploads_app/gallery/'.$file);
//          // $file = $_FILES['ufilename']['name'];
//           //$info = pathinfo($file);

//           // from PHP 5.2.0 :
//          // $file_name = $info['filename'];


//           //$img_width =$path['0'];
//           //$img_height =$path['1'];

//           //var_dump($img_width.'/'.$img_height ); die(); 
//           //$ratio=0.3;          
//           //$target_width =$img_width*$ratio;
//           //$target_width =intval($target_width); 
//           //$target_height =$img_height*$ratio;
//          // $target_height =intval($target_height);       
//     return response()->json([
//       "response"=>[
//           [
//           "rcode" => 0,
//           "rmessage" =>"Your successfully Upload License Images..!",
//           "id" =>$Gallery->id,
//           "image" =>$Gallery->path,
//           "imagesmall" =>$Gallery->imagesmall 
//           ]  
//           ]           
//           ])->header('Content-Type', 'application/json;charset=utf-8');
//           } catch (Exception $e) {
//             return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$otherrmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//           }
//         }      
//     }else{
// return response()->json([
//             "response"=>[
//                 [
//                 "rcode" => 1,
//                "rmessage" =>$prmessage
//                 ]  
//                 ]           
//                ])->header('Content-Type', 'application/json;charset=utf-8');
//     }
// }

    public function getApiDeleteCertificate(Request $request){
      $input = $request->only('ulang','uid','uimageid', 'utoken'); 
    //condtion for message
      if(strtolower(trim($input['ulang'])) == 'fr'){
        $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
        $userid_adminid = "Demande non autorisée.";          
        $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
        $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
      }elseif (strtolower(trim($input['ulang']))== 'cn') {
        $prmessage= "服务器无法处理您的请求。 请再试一次。";   
        $userid_adminid = "未经授权的请求。";       
        $otherrmessage = "服务器上发生未知错误。请再试一次。";
        $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
      }else{
        $prmessage= "Server is unable to process your request. Please try again.";      
        $userid_adminid = "Unauthorized request";     
        $otherrmessage = "Unknown error occurred on server. Please try again.";
        $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
      }       
    //condition for message end  
      $validator = Validator::make($input, [
        'uid'       => 'required',
        'ulang'     =>'required',
        'uimageid' => 'required',
        'utoken' => 'required|size:60'
        ]);

      if (!$validator->fails()){ 

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

        $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
        
    //check if user exists or not
    $exists = User::find(trim($input['uid']));

        if (empty($exists) || $role_id==1 || $role_id==3) { 
          return response()->json([
            "response"=>[
            [
            "rcode" => 1,
            "rmessage" =>$userid_adminid
            ]  
            ]           
            ])->header('Content-Type', 'application/json;charset=utf-8');
        }else{
          try {
            // $Gallery= Gallery::find($input['uimageid']);  
            // $Gallery-> delete();

        //code added by --yojan
            $Gallery= Gallery::find($input['uimageid']); 
            if(empty($Gallery)) {
                    return response()->json([
                "response"=>[
                [
                "rcode" => 1,
                "rmessage" =>$prmessage
                ]  
                ]           
                ])->header('Content-Type', 'application/json;charset=utf-8');
            }
            $image = $Gallery->path;
            $image =  str_replace($this->siteUrl, 'uploads/', $image);
            $imagesmall =$Gallery->imagesmall;
            $imagesmall =  str_replace($this->siteUrl, 'uploads/', $imagesmall);
            // return $imagesmall;
            
            $Gallery-> delete();


            if (!empty($image)) {
              if (File::exists($image)) {
                unlink($image);
              }
            }
            if (!empty($imagesmall)) {
              if (File::exists($imagesmall)) {
                unlink($imagesmall);
              }
            }

//end of addition of code

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save();


            return response()->json([
              "response"=>[
              [
              "rcode" => 0,
              "rmessage" =>"Your successfully Deleted License Images..!"          
              ]  
              ]           
              ])->header('Content-Type', 'application/json;charset=utf-8'); 
          } catch (Exception $e) {
            return response()->json([
              "response"=>[
              [
              "rcode" => 1,
              "rmessage" =>$otherrmessage
              ]  
              ]           
              ])->header('Content-Type', 'application/json;charset=utf-8');
          }
        }         
      }else{
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$prmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }

    public function getApiDeleteGallery(Request $request){
      $input = $request->only('ulang','uid','uimageid','utoken');   
    //$user= Auth::User();
    //condtion for message
      if(strtolower(trim($input['ulang'])) == 'fr'){
        $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
        $userid_adminid = "Demande non autorisée.";          
        $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
        $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
      }elseif (strtolower(trim($input['ulang']))== 'cn') {
        $prmessage= "服务器无法处理您的请求。 请再试一次。";   
        $userid_adminid = "未经授权的请求。";       
        $otherrmessage = "服务器上发生未知错误。请再试一次。";
        $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
      }else{
        $prmessage= "Server is unable to process your request. Please try again.";      
        $userid_adminid = "Unauthorized request";     
        $otherrmessage = "Unknown error occurred on server. Please try again.";
        $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
      }       
    //condition for message end  
      $validator = Validator::make($input, [
        'uid'       => 'required',
        'ulang'     =>'required',
        'uimageid' => 'required',
        'utoken' => 'required|size:60'
        ]);

      if (!$validator->fails()){

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }
    
       $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
       
       //check if user exists or not
    $exists = User::find(trim($input['uid']));

       if (empty($exists) || ($role_id==1 || $role_id==3)) { 
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$userid_adminid
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }else{
        try {
          //   $Gallery= Gallery::find($input['uimageid']);          
          // $Gallery-> delete();
//code added by --yojan
         $Gallery= Gallery::find($input['uimageid']);
         if(empty($Gallery)) {
                    return response()->json([
                "response"=>[
                [
                "rcode" => 1,
                "rmessage" =>$prmessage
                ]  
                ]           
                ])->header('Content-Type', 'application/json;charset=utf-8');
            }  
         $image = $Gallery->path;
         $image =  str_replace($this->siteUrl, 'uploads/', $image);
         $imagesmall =$Gallery->imagesmall;
         $imagesmall =  str_replace($this->siteUrl, 'uploads/', $imagesmall);
            // return $imagesmall;

         $Gallery-> delete();


         if (!empty($image)) {
          if (File::exists($image)) {
            unlink($image);
          }
        }
        if (!empty($imagesmall)) {
          if (File::exists($imagesmall)) {
            unlink($imagesmall);
          }
        }

//end of addition of code 

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save();    


        return response()->json([
          "response"=>[
          [
          "rcode" => 0,
          // "rmessage" =>"Your successfully Deleted Gallery Images..!"          
          "rmessage" =>"You have successfully Deleted Gallery Image..!"          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      } catch (Exception $e) {
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }         
  }else{
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}

public function getApiSaveInfo(Request $request){  
  $input = $request->all(); 
    //Auth::logout();     
    //$user= Auth::User();
    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end      
  $validator = Validator::make($input, [
    'uid'     => 'required',
    'ulang'   =>'required',
    'utoken' => 'required|size:60'
    ]);

  if (!$validator->fails()){

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }


    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
    
    //check if user exists or not
    $exists = User::find(trim($input['uid']));

    if (empty($exists) || $role_id==1 || $role_id==3 ) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
      try {
        $User = User::firstOrNew(array(
          'id' => trim($input['uid']) ));
        $User->fname = $input['ufirstname'];
        $User->lname = $input['ulastname'];
        $User->gender = $input['ugender'];
        $User->save();

        $Profile = Profile::firstOrNew(array(
          'user_id' => trim($input['uid'])) );    
        $Profile->phone = $input['umobile'];
        $Profile->state = $input['ustate'];
        $Profile->city = $input['ucity'];
        $Profile->country = $input['ucountry'];
        //$Profile->address = $input['address'];
        $Profile->experience = $input['uexperience'];
        $Profile->mGuidingArea = $input['umainguidingarea'];
        $Profile->oGuidingArea = $input['uotherguidingareas'];
        $Profile->language = $input['ulanguages'];
        $Profile->specilizedarea = $input['uspecializedskilllocation'];
        $Profile->about = $input['uaboutme'];   
        $Profile->save();

        $Guides = Guide::firstOrNew(array(
          'user_id' => trim($input['uid'])) );
        $Guides->price = $input['urate'];
        $Guides->save(); 

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save(); 
                 
        return response()->json([
          "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Save Profile..!"
          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      } catch (Exception $e) {
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }
    }        
  }else{
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}


public function getApiAddVideo(Request $request){
  $input = $request->all(); 
    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end 

  $validator = Validator::make($input, [
    'uid'       => 'required',
    'ulang'     =>'required',
    'uvideourl' => 'required',
    'utoken' => 'required|size:60'
    ]);  

  if (!$validator->fails()){ 

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');
   
    //check if user exists or not
    $exists = User::find(trim($input['uid']));

    if (empty($exists) || $role_id==1 || $role_id==3 ) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
      try {
        $videourl=Gallery::where('user_id', trim($input['uid']))->where('path', $input['uvideourl'])->value('path');      

        if($videourl== trim($input['uvideourl']))        
        {
          return response()->json([
            "response"=>[
            [
            "rcode" => 1,
            "rmessage" =>$otherrmessage
            ]  
            ]           
            ])->header('Content-Type', 'application/json;charset=utf-8');
        }else{            
          $Gallery = new Gallery; 
          $Gallery->user_id = trim($input['uid']);           
          $Gallery->path = $input['uvideourl'];
          $Gallery->type ='video';   
          $Gallery->save(); 

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save();

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
      } catch (Exception $e) {
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8'); 
      }
    }     
  }else{
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}

public function getApiDeleteVideo(Request $request){
  $input = $request->all();   
    //$user= Auth::User(); 
    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $userid_adminid = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
    $utokenError = "Soit votre session a expiré ou une demande non autorisée a été détectée, s'il vous plaît vous connecter maintenant.";      
  }elseif (strtolower(trim($input['ulang'])) == 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";   
    $userid_adminid = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
    $utokenError = "您的会话已超时或检测到未经授权的请求，请立即登录。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again.";      
    $userid_adminid = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
    $utokenError = "Either your session has timed out or unauthorized request has been detected, please login now.";
  }       
    //condition for message end 
  $validator = Validator::make($input, [
    'uid'       => 'required',
    'ulang'     => 'required',
    'uvideoid'  => 'required',
    'utoken' => 'required|size:60'
    ]); 

  if (!$validator->fails()){

//check for valid api token
    $expiryDate = User::where('api_token', trim($input['utoken']) )->value('api_token_expiry_date');
    $carbon = Carbon::now();
    if( (empty($expiryDate)) || ($carbon->gt(Carbon::parse($expiryDate))) ){
      // return Carbon::parse($expiryDate);
      return response()->json([
        "response"=>[
          [
          "rcode" => 2,
          "rmessage" =>$utokenError
          ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }

    $role_id =DB::table('assigned_roles')->where('user_id' , trim($input['uid']))->value('role_id');

     //check if user exists or not
    $exists = User::find(trim($input['uid']));

    if (empty($exists) || $role_id==1 || $role_id==3 ) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$userid_adminid
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }else{
      try {
        $Gallery= Gallery::find($input['uvideoid']);  

        if(empty($Gallery)) {
                    return response()->json([
                "response"=>[
                [
                "rcode" => 1,
                "rmessage" =>$prmessage
                ]  
                ]           
                ])->header('Content-Type', 'application/json;charset=utf-8');
            } 

        $Gallery-> delete();

//update token expiry date  
$updateTokenDate= User::where('api_token', trim($input['utoken']) )->first();
$updateTokenDate->api_token_expiry_date = Carbon::now()->addHours($this->sessionTime);
$updateTokenDate->save();

        return response()->json([
          "response"=>[
          [
          "rcode" => 0,
          "rmessage" =>"Your successfully Deleted Youtube Video..!"          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      } catch (Exception $e) {
        return response()->json([
          "response"=>[
          [
          "rcode" => 1,
          "rmessage" =>$otherrmessage
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }  
    }     

  }else{
    return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$prmessage
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }
}

//Forget password
public function getForgetPassword(Request $request)
{  
  $input = $request->only('ulang','uemail'); 
    //condtion for message
  if(strtolower(trim($input['ulang'])) == 'fr'){
    $prmessage= "Le serveur ne peut pas traiter votre demande. S'il vous plaît essayer à nouveau.";  
    $emailnotexist = "Cette adresse e-mail n'existe pas.";      
    $email_admin = "Demande non autorisée.";          
    $otherrmessage = "Une erreur inconnue est survenue sur le serveur. S'il vous plaît essayer à nouveau.";      
  }elseif (strtolower(trim($input['ulang']))== 'cn') {
    $prmessage= "服务器无法处理您的请求。 请再试一次。";  
    $emailnotexist = "此电子邮件地址不存在。";        
    $email_admin = "未经授权的请求。";       
    $otherrmessage = "服务器上发生未知错误。请再试一次。";
  }else{
    $prmessage= "Server is unable to process your request. Please try again."; 
    $emailnotexist = "This email address doesn't exist.";     
    $email_admin = "Unauthorized request";     
    $otherrmessage = "Unknown error occurred on server. Please try again.";
  }       
    //condition for message end     

  $validator = Validator::make($input, [   
    // 'uemail'  => 'required|email',
    'uemail'  => 'required',
    'ulang'     => 'required' 
    ]);
   //$this->validate($request, ['email' => 'required|email']);
//var_dump('a'); die();

  if (!$validator->fails()){

 //checking for valid email
    $email = $this->pre_test_email($input['uemail']);
        // return $email;
    if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) ) {
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$prmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');   
    }

    // $email= trim($input['uemail']);  
    $oldemail=  User::where('email', $email)->value('email');
    $oldemailid=  User::where('email', $email)->value('id');  

    $role_id =DB::table('assigned_roles')->where('user_id' , $oldemailid)->value('role_id');
    
    // if ($oldemail != $email && empty($oldemail)) { 
    if ($oldemail != $email || empty($oldemail)) { 
      return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$emailnotexist
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }elseif ($role_id ==1) {
     return response()->json([
      "response"=>[
      [
      "rcode" => 1,
      "rmessage" =>$email_admin
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   }else{
     $response = Password::sendResetLink(['email' =>$email], function (
      $message) {
      $message->subject($this->getEmailSubject());
    });
   //var_dump($response); die();
     switch ($response) {
       case Password::RESET_LINK_SENT:       
       return response()->json([
        "response"=>[
        [
        "rcode" => 0,
        "rmessage" =>"successfully sent Password link to you Email Check !"
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
       case Password::INVALID_USER:       
       return response()->json([
        "response"=>[
        [
        "rcode" => 1,
        "rmessage" =>$otherrmessage
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');    
     }
   }    
 }else{
  return response()->json([
    "response"=>[
    [
    "rcode" => 1,
    "rmessage" =>$prmessage
    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
}
}
protected function getEmailSubject()
{
 return isset($this->subject) ? $this->subject : 'GUIDENP - reset your password';
}

   //server side resizing image

public function getImageResizing(Request $request){   
  $input = $request->only('h', 'w','p','i');     
  $validator = Validator::make($input, [
    'i' => 'required'    
    ]);  

  if (!$validator->fails()){   
        //for input
    $filename  =explode('http://guidenp.devworkserver.com/uploads_app/',  $input['i']);
    $filename=implode(';', $filename);
    $filename =explode('/', $filename);
          //var_dump($filename); die();
          //for db
    $path=($filename[0]); 
    $pathfile =Gallery::where('path', $input['i'])->value('path');
          //var_dump($pathfile); die();
    $pathfilename  =explode("http://guidenp.devworkserver.com/uploads_app/",  $pathfile);
    $pathfilename=implode(';', $pathfilename);
    $pathfilename =explode('/', $pathfilename);
          //var_dump($pathfilename); die();
    if(!empty($input['h'])){         

      if($filename[4] == 'profile'){
            //var_dump('profile'); die();
        $target_height = $input['h'];
        $path =getimagesize('uploads_app/profile/'.$filename[5]);
        $img_width =$path['0'];
        $img_height =$path['1'];
          //var_dump($path); die(); 
        $ratio=$img_height/$target_height;
        $target_width =$img_width/$ratio;
        $target_width =intval($target_width); 
        $target_height =intval($target_height);                 

        $image = Image::make('uploads_app/profile/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
        $image->save('uploads_app/resize/profile/'.str_random(10). '.'.$image->extension);


        return response()->json([
          "response"=>[
          [
          "rcode" => 0,            
          "rmessage" =>"Your successfully Resize Profile Images with Given height..!",            
          "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/profile/".$image->basename          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }elseif ($filename[4] == 'gallery') {
           // var_dump('gallery'); die();
        $target_height = $input['h'];
        $path =getimagesize('uploads_app/gallery/'.$filename[5]);
        $img_width =$path['0'];
        $img_height =$path['1'];
          //var_dump($path); die(); 
        $ratio=$img_height/$target_height;
        $target_width =$img_width/$ratio;
        $target_width =intval($target_width); 
        $target_height =intval($target_height);                 

        $image = Image::make('uploads_app/gallery/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
        $image->save('uploads_app/resize/gallery/'.str_random(10). '.'.$image->extension);


        return response()->json([
          "response"=>[
          [
          "rcode" => 0,            
          "rmessage" =>"Your successfully Resize Gallery Images with Given height..!",            
          "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/gallery/".$image->basename          
          ]  
          ]           
          ])->header('Content-Type', 'application/json;charset=utf-8');
      }elseif ($filename[4] == 'license') {
           // var_dump('license'); die();
       $target_height = $input['h'];
       $path =getimagesize('uploads_app/license/'.$filename[5]);
       $img_width =$path['0'];
       $img_height =$path['1'];
          //var_dump($path); die(); 
       $ratio=$img_height/$target_height;
       $target_width =$img_width/$ratio;
       $target_width =intval($target_width);
       $target_height =intval($target_height);                  

       $image = Image::make('uploads_app/license/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
       $image->save('uploads_app/resize/license/'.str_random(10). '.'.$image->extension);


       return response()->json([
        "response"=>[
        [
        "rcode" => 0,            
        "rmessage" =>"Your successfully Resize License Images with Given height..!",            
        "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/license/".$image->basename          
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
     }else{
       return response()->json([
        "response"=>[
        [
        "rcode" => 1,            
        "rmessage" =>"Sorry Particular Images not Found..!"            

        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
     }  

   }elseif (!empty($input['w'])) {

    if($filename[4] == 'profile'){
      $target_width = $input['w'];
      $path =getimagesize('uploads_app/profile/'.$filename[5]);
      $img_width =$path['0'];
      $img_height =$path['1'];
          //var_dump($path); die(); 
      $ratio=$img_width/$target_width;
      $target_height =$img_height/$ratio;
      $target_width =intval($target_width);
      $target_height =intval($target_height);                  

      $image = Image::make('uploads_app/profile/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
      $image->save('uploads_app/resize/profile/'.str_random(10). '.'.$image->extension);           

      return response()->json([
        "response"=>[
        [
        "rcode" => 0,            
        "rmessage" =>"Your successfully Resize Profile Images with Given Width..!",            
        "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/profile/".$image->basename          
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }elseif ($filename[4] == 'gallery') {
      $target_width = $input['w'];
      $path =getimagesize('uploads_app/gallery/'.$filename[5]);
      $img_width =$path['0'];
      $img_height =$path['1'];
          //var_dump($path); die(); 
      $ratio=$img_width/$target_width;
      $target_height =$img_height/$ratio;
      $target_width =intval($target_width);
      $target_height =intval($target_height);                  

      $image = Image::make('uploads_app/gallery/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
      $image->save('uploads_app/resize/gallery/'.str_random(10). '.'.$image->extension);


      return response()->json([
        "response"=>[
        [
        "rcode" => 0,            
        "rmessage" =>"Your successfully Resize Gallery Images with Given Width..!",            
        "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/gallery/".$image->basename          
        ]  
        ]           
        ])->header('Content-Type', 'application/json;charset=utf-8');
    }elseif ($filename[4] == 'license') {
     $target_width = $input['w'];
     $path =getimagesize('uploads_app/license/'.$filename[5]);
     $img_width =$path['0'];
     $img_height =$path['1'];
          //var_dump($path); die(); 
     $ratio=$img_width/$target_width;
     $target_height =$img_height/$ratio; 
     $target_width =intval($target_width); 
     $target_height =intval($target_height);                

     $image = Image::make('uploads_app/license/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
     $image->save('uploads_app/resize/license/'.str_random(10). '.'.$image->extension);


     return response()->json([
      "response"=>[
      [
      "rcode" => 0,            
      "rmessage" =>"Your successfully Resize License Images with Given Width..!",            
      "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/license/".$image->basename          
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   }else{
     return response()->json([
      "response"=>[
      [
      "rcode" => 1,            
      "rmessage" =>"Sorry Particular Images not Found..!"            

      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
   } 

 }else{

  if($filename[4] == 'profile'){
    $target_percentage = $input['p'];
    $path =getimagesize('uploads_app/profile/'.$filename[5]);
    $img_width =$path['0'];
    $img_height =$path['1'];
          //var_dump($path); die(); 
    $ratio=$target_percentage/100;
    $target_width =$img_width*$ratio; 
    $target_width =intval($target_width); 
    $target_height =$img_height*$ratio;
    $target_height =intval($target_height);                 

    $image = Image::make('uploads_app/profile/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
    $image->save('uploads_app/resize/profile/'.str_random(10). '.'.$image->extension);                 

    return response()->json([
      "response"=>[
      [
      "rcode" => 0,            
      "rmessage" =>"Your successfully Resize Profile Images with Given Percentage..!",            
      "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/profile/".$image->basename          
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }elseif ($filename[4] == 'gallery') {
    $target_percentage = $input['p'];
    $path =getimagesize('uploads_app/gallery/'.$filename[5]);
    $img_width =$path['0'];
    $img_height =$path['1'];
          //var_dump($path); die(); 
    $ratio=$target_percentage/100;
    $target_width =$img_width*$ratio;
    $target_width =intval($target_width);  
    $target_height =$img_height*$ratio;
    $target_height =intval($target_height);                 

    $image = Image::make('uploads_app/gallery/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
    $image->save('uploads_app/resize/gallery/'.str_random(10). '.'.$image->extension);          


    return response()->json([
      "response"=>[
      [
      "rcode" => 0,            
      "rmessage" =>"Your successfully Resize Gallery Images with Given Percentage..!",            
      "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/gallery/".$image->basename          
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }elseif ($filename[4] == 'license') {
    $target_percentage = $input['p'];
    $path =getimagesize('uploads_app/license/'.$filename[5]);
    $img_width =$path['0'];
    $img_height =$path['1'];
          //var_dump($img_width.'/'.$img_height ); die(); 
    $ratio=$target_percentage/100;          
    $target_width =$img_width*$ratio;
    $target_width =intval($target_width); 
    $target_height =$img_height*$ratio;
    $target_height =intval($target_height);      
          //var_dump($ratio.'/'.$target_width .'/'. $target_height ); die(); 
    $image = Image::make('uploads_app/license/'.$filename[5])->fit($target_width, $target_height);
           //var_dump($image .$target_width); die();
    $image->save('uploads_app/resize/license/'.str_random(10). '.'.$image->extension);         


    return response()->json([
      "response"=>[
      [
      "rcode" => 0,            
      "rmessage" =>"Your successfully Resize License Images with Given Percentage..!",            
      "image" =>"http://www.guidenp.devworkserver.com/uploads_app/resize/license/".$image->basename          
      ]  
      ]           
      ])->header('Content-Type', 'application/json;charset=utf-8');
  }else{
   return response()->json([
    "response"=>[
    [
    "rcode" => 1,            
    "rmessage" =>"Sorry Particular Images not Found..!"            

    ]  
    ]           
    ])->header('Content-Type', 'application/json;charset=utf-8');
 }          
} 
}else{       
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

}

