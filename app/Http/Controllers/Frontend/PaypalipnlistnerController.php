<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Fahim\PaypalIPN\PaypalIPNListener;

/**
 * Description of PaypalIpnListner
 *
 * @author hp
 */
class PaypalipnlistnerController extends Controller {
   
    public function __construct()
    {
        
    }
    public function index() {
        
        die('am here');
        $ipn = new PaypalIPNListener();
        $ipn->use_sandbox = true;

        $verified = $ipn->processIpn();

        $report = $ipn->getTextReport();

        Log::info("-----new payment-----");

        Log::info($report);

        if ($verified) {
            if ($_POST['address_status'] == 'confirmed') {
                // Check outh POST variable and insert your logic here
                Log::info("payment verified and inserted to db");
            }
        } else {
            Log::info("Some thing went wrong in the payment !");
        }
    }

}
