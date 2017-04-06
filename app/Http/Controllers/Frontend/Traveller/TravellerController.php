<?php

namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\BookingRequest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Setting;
use App\Exceptions\GeneralException;
use URL;
use Auth;
use App\Models\Favorites;
use App\Models\Access\User\User;
use App\Models\Availability;

/**
 * Class TravellerController
 * @package App\Http\Controllers\Frontend
 */
class TravellerController extends Controller {

    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getActivity() {
        $bookings = Booking::where('uid', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('frontend.traveller.activity', compact('bookings'))->withClass('activity');
    }

    public function cancelBooking($booking_id) {
        $booking = Booking::findOrFail($booking_id);
        $booking->status = 'cancel requested';
        $booking->save();
        $guide_id = $booking->gid;
        $traveler_id = $booking->uid;
        $avails = Availability::where('guide_id', $guide_id)->where('travler_id', $traveler_id)->update(['status' => 'free']);
        return redirect()->back();
    }

    public function showFavorites() {
        $favorites = Favorites::where('traveler_id', Auth::user()->id)->get();
        return view('frontend.traveller.favorites', compact("favorites"))
        ->with('user', Auth::user())
        ->withClass('activity dashboard-page');
    }

    public function addFavorite($guide_id) {
        $user = User::findOrFail($guide_id);
        $user_id = Auth::user()->id;
        $record = Favorites::firstOrCreate(
            [
                'traveler_id' => $user_id,
                'guide_id' => $user->id
            ]
        );
        return redirect()->back();
    }
    public function removeFavorite($guide_id) {
        $user = User::findOrFail($guide_id);
        $user_id = Auth::user()->id;
        $record = Favorites::where('traveler_id', $user_id)->where('guide_id', $user->id)->delete();
        return redirect()->back();
    }

    public function has_favorited($guide_id) {
        $user = User::findOrFail($guide_id);
        $user_id = Auth::user()->id;
        $record = Favorites::where('traveler_id', $user_id)->where('guide_id', $user->id)->first();
        if ($record) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getPaymentProcess() {
        return view('frontend.payment-process')->withClass('paymentArea');
    }

    public function submitPaypal(BookingRequest $request) {
        $totalDays = $request->totalDays;
        $dates = $request->dates;
        $paypalSubmit = 1;
        $user = '';
        $guide = $this->user->findOrThrowException($request->gid);
        $guidePage = $this->user->getGuide($guide->username);
        //dd($guide);

        $guidePriceRow = \DB::table('guides')->where('gid', $request->gid)->first();

        $guidePrice = '';
        if ($guidePriceRow) {

            $guidePrice = $guidePriceRow->price;
        }

        // dd($guide);
        $serviceFeePercentage = \Session::get('serviceFee');
        $totalAmount = number_format($guidePrice * $totalDays, 2);
        $serviceFee = number_format(($totalAmount * $serviceFeePercentage) / 100, 2);
        $grossTotal = $totalAmount + $serviceFee;
        $partialTotal = (0.2 * $totalAmount) + $serviceFee;
        /* if($request->submitPayment){
          $paypalSubmit = 1;
          }
         */

        //add data to booking form
          if ($request->payment_type == 'partial') {
                $booking = Booking::create([
                    'gid' => $request->gid,
                    'uid' => auth()->id(),
                    'amount' => $grossTotal,
                    'days' => $totalDays,
                    'dates' => $dates,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'state' => $request->state,
                    'city' => $request->city,
                    'country' => $request->country,
                    'status' => '',
                    'transaction_type' => 'partial',
                    'next_status' => 'remaining',
                    'guide_rate' => $guidePrice,
                    'service_charge' => $serviceFee * (20/100)
                ]);
          } else {
                $booking = Booking::create([
                    'gid' => $request->gid,
                    'uid' => auth()->id(),
                    'amount' => $grossTotal,
                    'days' => $totalDays,
                    'dates' => $dates,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'state' => $request->state,
                    'city' => $request->city,
                    'country' => $request->country,
                    'status' => '',
                    'transaction_type' => 'full',
                    'next_status' => 'none',
                    'guide_rate' => $guidePrice,
                    'service_charge' => $serviceFee
                ]);
          }
        
        $data['item_name'] = 'Guide Booking for ' . $totalDays . ' days ('.$request->payment_type.' payment)';
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        //$data['business'] = 'yojanlaravelmail-facilitator@gmail.com';
        $data['business'] = 'akash.progressarc-facilitator@gmail.com';
        $data['quantity'] = $totalDays;
        $data['amount'] = $guidePrice + (($guidePrice * $serviceFeePercentage) / 100);
        if ($request->payment_type=="partial") {
            $data["amount"] = (($guidePrice * 0.2) + (($guidePrice * $serviceFeePercentage) / 100) * (20/100));
        }
        $data['notify_url'] = url() . '/paymentpaypal/paypalipn';
        $data['return'] = url().'/callback/paypal/'.$guide->username.'?user='.Auth::user()->id."&booking=".$booking->id;
        $data['cancel_return'] = url().'/?payment=success';
        $data['tax'] = '';
        $data['custom'] = $booking->id.'-'.$guide->id;
        
       // die($data['custom']);
        
       
        

        return view('frontend.traveller.guidebook', compact('user', 'totalDays', 'dates', 'guide','guidePage', 'guidePrice', 'totalAmount', 'paypalSubmit', 'serviceFee'))->withClass('traveller-settings')->with($data);
    }

    public function postBookingDetails(BookingRequest $request) {

        //if ($request->ajax()) abort(403, 'Forbidden');
        $paypalSubmit = '';



        $data = array();
        $totalDays = '';
        $dates = '';

        if ($request->totalDays && $request->dates) {

            $request->session()->put('totalDays', $request->totalDays);
            $request->session()->put('dates', $request->dates);
        }



        if ($request->session()->has('totalDays') && $request->session()->has('dates')) {

            $totalDays = $request->session()->get('totalDays');
            $dates = $request->session()->get('dates');
        } else {

            die();
        }
        //9841596396
        //$user  = access()->user();
        $user = '';
        $guide = $this->user->findOrThrowException($request->gid);
        
        
        $guidePage = $this->user->getGuide($guide->username);
        //dd($guide);

        $guidePriceRow = \DB::table('guides')->where('gid', $request->gid)->first();

        $guidePrice = '';
        if ($guidePriceRow) {

            $guidePrice = $guidePriceRow->price;
        }
        // dd($guide);
        $serviceFeePercentage = \Session::get('serviceFee');
        $totalAmount = number_format($guidePrice * $totalDays, 2);
        $serviceFee = number_format(($totalAmount * $serviceFeePercentage ) / 100, 2);

        /* if($request->submitPayment){
          $paypalSubmit = 1;
          }
         */

        return view('frontend.traveller.guidebook', compact('user', 'totalDays', 'dates', 'guide','guidePage', 'guidePrice', 'totalAmount', 'paypalSubmit', 'serviceFee'))->withClass('traveller-settings');
    }

    public function postBookingProcess(BookingRequest $request) {
        // dd($request['bookTo']);
        if ($request->ajax())
            abort(403, 'Forbidden');
        $message['subject'] = 'Booking request from traveler.';
        $message['body'] = auth()->user()->email . ' has booked a guide from ' . $request->bookFrom . ' to ' . $request->bookTo . ' for ' . $request->totalDays . ' days. Please login: ' . URL::to('admin') . ' to review this booking.';

        $user = $this->user->findOrThrowException($request->gid);
        $setting = Setting::find(1);
        $price = $user->guide->price * $request->totalDays;
        $totalPrice = $price + ($price * ( $setting->charges / 100 ));
        if ($user->guide->certified) {
            $this->bookingProcess($request);
            $this->user->notifyAdmin($message);
            return redirect()->route('frontend.guide.payment');
        } else {
            $booking = Booking::create([
                        'gid' => $request->gid,
                        'user_id' => auth()->id(),
                        'amount' => $totalPrice,
                        'days' => $request->totalDays,
                        'start_date' => $request->bookFrom,
                        'end_date' => $request->bookTo
            ]);

            if ($booking) {
                $this->user->notifyAdmin($message);
                return redirect()->route('frontend.traveller.activity')->withFlashSuccess(trans("alerts.booking.created"));
            }
        }

        throw new GeneralException('There is an error occured during booking process.');
    }

    private function bookingProcess($request) {
        $message['subject'] = 'Booking request from traveler.';
        $message['body'] = auth()->user()->email . ' has booked a guide from ' . $request->bookFrom . ' to ' . $request->bookTo . ' for ' . $request->totalDays . ' days. Please login: ' . URL::to('admin') . ' to review this booking.';
        $user = $this->user->findOrThrowException($request->gid);
        $price = $user->guide->price * $request->totalDays;
        $setting = Setting::find(1);
        $totalPrice = $price + ($price * ( $setting->charges / 100 ));

        $booking = Booking::create([
                    'gid' => $request->gid,
                    'uid' => auth()->id(),
                    'amount' => $totalPrice,
                    'days' => $request->totalDays,
                    'start_date' => $request->bookFrom,
                    'end_date' => $request->bookTo
        ]);

        if ($booking) {
            $this->user->notifyAdmin($message);
            return redirect()->route('frontend.traveller.activity')->withFlashSuccess(trans("alerts.booking.created"));
        }
    }

}
