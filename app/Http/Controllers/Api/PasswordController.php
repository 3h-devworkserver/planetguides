<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ApiResetsPasswords;


class PasswordController extends Controller
{
  
      //use ApiResetsPasswords; 

   public function __construct()
   {
    //Log::alert('aa');
     $this->middleware('guest');
   } 
 }