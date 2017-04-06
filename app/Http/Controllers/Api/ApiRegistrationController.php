<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Access\User\User;
use Hash;
use Mail;
use Flash;
//use Your\Exceptions\Namespace\InvalidConfirmationCodeException;
class ApiRegistrationController extends  Controller {   

    public function confirm($confirmation_code)
    {
        //var_dump($confirmation_code); die();
        if( ! $confirmation_code)
        {
            return('no code');
        }else{

        $user = User::where('confirmation_code', '=' ,$confirmation_code)->first();
//var_dump($user); die();
        

        $user->confirmed = 1;
        $user->confirmation_code = $confirmation_code;
        //$user->remember_token = null;
        $user->save();
        return('You have successfully verified your account.');
    }

       
}
       
}