<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;
use Input;
use Illuminate\Http\Request;
use Log;
use Fahim\PaypalIPN\PaypalIPNListener;
use Illuminate\Support\Facades\Storage;
use App\Models\Access\User\User;
use App\Models\Availability;
use App\Models\Booking;

/**
 * Class PaypalPaymentController
 * @package App\Http\Controllers
 */
class PaypalPaymentController extends Controller {

    public function __construct() {
        
    }

    /*
     * Process payment using credit card
     */

    function paypalipnOld() {

        Log::info("Ipn Runs");

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

    function paypalipnTest() {
        Storage::disk('local')->put('file.txt', 'am saving data');
        die;
    }

    function paypalipn() {
        
        
        
        $file_data = '';
        $booking_id = '';
        $payment_status = '';
        $txn_id = '';
        $gid = '';
        $booking_id = '';


        $req = 'cmd=_notify-validate';
        


        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
            $file_data .= "$key = $value " . "\n";

            if ($key == 'custom') {

                $customArray = explode('-', $value);
                $booking_id = $customArray[0];
                $gid = $customArray[1];
            }

            if ($key == 'payment_status')
                $payment_status = $value;

            if ($key == 'txn_id')
                $txn_id = $value;
        }
        if ($payment_status == 'Completed') {

            Storage::disk('local')->put($booking_id . '-file.txt', $file_data);
            
            DB::table('bookings')
                    ->where('id', $booking_id)
                    ->update(['transaction_id' => $txn_id, 'status' => 'completed']);
            
            $bookingRow = \DB::table('bookings')->where('id', $booking_id)->first();
            
            //dd($bookingRow);
            if($bookingRow){
               // Log::info('Booking Avaliable');
                $dates = explode(',',$bookingRow->dates);
                $datesActual = array();
                foreach($dates as $row){
                 $datesActual[] = general_date($row);    
                }
                
               // Log::info(print_r($datesActual));
                
               // Log::info(print_r($bookingRow));
               //echo $datesActual = rtrim($datesActual,',');
                $guide_id    = $bookingRow->gid;
                $travler_id  = $bookingRow->uid;
                $res = DB::table('availabilitys')
                    ->where('guide_id', $guide_id)
                    ->whereIn('availibility', $datesActual)    
                    ->update(['status' => 'booked','travler_id'=>$travler_id]);
                
                
            }
            
        }

        // post back to PayPal system to validate
        /*
         * $allData = $request->all();
          \Log::info($allData);

          if ($allData['payment_status'] == 'Completed'  || $allData['payment_status'] == 'Pending') {
          Pubpaymentrequest::where('id', $paymentRequestInfo->id)->update(['is_paid'=>'1', 'transaction_id' => $allData['txn_id']]);
          }
         * 
         * $header  = '';
          $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
          $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
          $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

          //$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
          $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

          if (!$fp) {
          // HTTP ERROR
          } else {
          fputs($fp, $header . $req);
          while (!feof($fp)) {
          $res = fgets($fp, 1024);
          if (strcmp($res, "VERIFIED") == 0) {

          Storage::disk('local')->put('file11.txt', $res);
          } else if (strcmp($res, "INVALID") == 0) {
          // log for manual investigation
          // echo the response
          echo "The response from IPN was: <b>" . $res . "</b>";
          }
          }
          fclose($fp);
          } */
    }

    public function afterPaymentCallback(Request $request, $guide_username) {
      if ($request->process=="complete") {
        $buyer = $request->user;
        $booking_id = $request->booking;
        $transaction_id = $request->txn_id;
        $amount_paid = $request->payment_gross;
        Log::info("payment verified, and this is now complete payment to the partial payement and inserted to db. TXN ID : $transaction_id and amount of $amount_paid.");
        $guide = User::where('username', $guide_username)->first();
        $booking = Booking::findOrFail($booking_id);
        $booking->next_id = $transaction_id;
        $booking->next_amount = $amount_paid * (80/100);
        $booking->next_service_charge = $amount_paid * (20/100);
        $booking->status = 'booked';
        $booking->next_status = 'paid';
        $booking->save();
        return redirect()->route('frontend.traveller.activity')->with(["message" => "You have now completely paid all the amounts."]);
      }
      $buyer = $request->user;
      $booking_id = $request->booking;
      $transaction_id = $request->txn_id;
      $amount_paid = $request->payment_gross;
      Log::info("payment verified and inserted to db. TXN ID : $transaction_id and amount of $amount_paid.");
      $guide = User::where('username', $guide_username)->first();
      $booking = Booking::findOrFail($booking_id);
      $booking->transaction_id = $transaction_id;
      $booking->transaction_amount = $amount_paid;
      $booking->status = 'booked';
      $booking->next_status = 'remaining';
      $booking->save();
      $guide_id = $booking->gid;
      $traveler_id = $booking->uid;
      $dates = $booking->dates;
      $dates_r = $booking->dates;
      $dates = explode(',', $dates);
      foreach ($dates as $date) {
        $date = explode("/", $date);
        $date = "$date[2]-$date[0]-$date[1]";
        $freedate = Availability::where('guide_id', $guide_id)->where('availibility', $date)->first();
        if ($freedate) {
          $freedate->status = "booked";
          $freedate->save();
        }
      }
      return redirect()->route('frontend.traveller.activity')->with(["message" => "You have successfully booked the tickets."]);
    }

}
