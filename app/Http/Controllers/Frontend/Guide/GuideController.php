<?php

namespace App\Http\Controllers\Frontend\Guide;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Http\Request;
use App\Http\Requests\Frontend\User\ReviewRequest;
use App\Models\Review;
use Datatable;
use Auth;
use App\Models\Setting;
use App\Http\Requests\Frontend\User\EmailRequest;
use App\Http\Requests\Frontend\User\GuideSettingsRequest;
use App\Models\Favorites;
use App\Models\Booking;
use App\Models\Gallery;

/**
 * Class GuideController
 * @package App\Http\Controllers\Frontend
 */
class GuideController extends Controller {



    protected $string;

    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function earnings() {
        $bookings = Booking::where('gid', Auth::user()->id)->where('status', 'booked')->get();
        return view('frontend.guide.earnings', compact('bookings'))->withClass('activity');
    }

    public function getSettings() {
        $user = access()->user();
        return view('frontend.guide.settings', compact('user'))->withClass('guide-settings');
    }

    public function postSettings(GuideSettingsRequest $request) {
        $this->validate($request, [
        'email' => 'required|email|unique:users,email,'.Auth::id(),
        'password' => 'required',
        ]);
        $this->user->changePassword($request->all());
        $this->user->changeEmail($request->all());
        return redirect()->route('frontend.guide.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
    }

    public function updateEmailSettings(Request $request) {
        $data['stat'] = 'error';
        $this->validate($request, [
            'email' => 'required|unique:users'
        ]);
        $email = $this->user->changeEmail($request->all());
        if ($email) {
            $data['stat'] = 'ok';
            $data['value'] = $request['email'];
            return response()->json($data);
        }

        return response()->json($data);
    }

    public function has_favorited($guide_id) {
        $user_id = 0;
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        }
        $record = Favorites::where('traveler_id', $user_id)->where('guide_id', $guide_id)->first();
        if ($record) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getProfile($username, Request $request) {
        
        $paymentStatus = $request->payment;
        
        
        $guide = $this->user->getGuide($username);
        $guid_id = $guide->user_id;
        $has_favorited = $this->has_favorited($guid_id);
        $gallerys = Gallery::where('user_id', $guid_id)->where('type', 'image')->get();
        $gallerys = $gallerys->all();
        // $bookedDates = $this->user->getBookingDates();
    // ihave commented above code and use static date for now
        $bookedDates = array('2016-5-20', '2016-5-21', '2016-5-22');

        javascript()->put([
            'guidePrice' => $guide->price,
            'serviceCharge' => Setting::first()->charges,
            'bookedDates' => $bookedDates
        ]);
        \DB::enableQueryLog();


        $availibility = \DB::table('availabilitys')
                ->select('availibility')
                ->where('guide_id', $guid_id)
                ->where('status','free')
                ->get();

// return $availibility;

        $available = '';
        if ($availibility) {

            foreach ($availibility as $row) {
                $available .= cal_date($row->availibility, '1') . ',';
            }

            $available = rtrim($available, ',');
        } else {
            $available = '';
        }
// return $available;
        $serviceChargeRow = \DB::table('settings')
                ->select('charges')
                ->first();

// var_dump($serviceChargeRow) ; die();

        if ($serviceChargeRow) {
            \Session::put('serviceFee', $serviceChargeRow->charges);
        }


        // Get all reviews that are not spam for the product and paginate them
        $reviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->paginate(5);
        // return $reviews;
        if ($request->ajax()) {
            $html = view('frontend.guide.review-list')->with('reviews', $reviews)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
        $recentreviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->take(config('access.recent_reviews_count'))->get();
        // return $recentreviews;
        // return $recentreviews[0]->user;
        return view('frontend.guide.profile', ['imagesx' => $gallerys,'has_favorited' => $has_favorited, 'availibility' => $available,'paymentStatus'=>$paymentStatus, 'reviews' => $reviews, 'recentreviews' => $recentreviews])->withGuide($guide)->withClass('');
    }


    /**
     * Replace char with replacing character // edited by pradeep
     * @param  [type] $char  [description]
     * @param  [type] $rchar [description]
     * @return [type]        [description]
     */
    public function replace($char,$rchar)
    {
        $this->string=str_replace($char,$rchar, $this->string);
        return $this;
    }   
    
    public function replaceStr() 
    {
         $this->replace(" ", "")->replace("dot", ".")



         ->replace("((", "(")->replace("))", ")")



         ->replace("{{", "{")->replace("}}", "}")



         ->replace("[[", "[")->replace("]]", "]")



         ->replace("(at)", "@")->replace("(8)", "@")->replace("(eight)", "@")



         ->replace("(dot)", ".")



         ->replace("{at}", "@")->replace("{8}", "@")->replace("{eight}", "@")



         ->replace("{dot}", ".")



         ->replace("[at]", "@")->replace("[8]", "@")->replace("[eight]", "@")



         ->replace("[dot]", ".")



         ->replace("(.(", ".")->replace("(.)", ".")->replace(").(", ".")->replace(").)", ".")



         ->replace("[.[", ".")->replace("[.]", ".")->replace("].[", ".")->replace("].]", ".")



         ->replace("{.{", ".")->replace("{.}", ".")->replace("}.{", ".")->replace("}.}", ".")



         ->replace(" ", "")



         ->replace("-", "")



         ->replace("_", "")



         ->replace(")", "")



         ->replace("(", "")



         ->replace(")", "")



         ->replace("[", "")



         ->replace("]", "")



         ->replace("{", "")



         ->replace("*", "")



         ->replace("+", "")



         ->replace("`", "")



         ->replace("~", "")



         ->replace("!", "")



         ->replace("#", "")



         ->replace("$", "")



         ->replace("%", "")



         ->replace("^", "")



         ->replace("&", "")



         ->replace("=", "")



         ->replace("|", "")



         ->replace(">", "")



         ->replace("<", "")



         ->replace(",", "")



         ->replace("?", "")
         ->replace("..",".");

         return $this; 
    }

    public function containsLink($fieldname)
    {
        $this->string=$fieldname;
        $this->replaceStr();
        
        $listOfDomains =array( "mail", // popular domains

                             ".com",

                             ".org",

                             ".net",

                             ".int",

                             ".edu",

                             ".gov",

                             ".mil",

                             ".info",

                             ".np",

                             ".fr",

                             ".cn",

                             ".de",

                             "@", //mandatory characters for url

                             "/",

                             "\\",

                             "google", // popular mail services

                             "yahoo",

                             "linkedin",

                             "facebook",

                             "twitter",

                             "instagram",

                             "proto",

                             "zoho",

                             "rediff",

                             "yandex",

                             "icloud",

                             "hi5",

                             "outlook",

                             "aol",

                             "inbox",

                             "lycos",

                             "myway",

                             "gmx"
                    );

        foreach ($listOfDomains as $key ) {
            
            if (strpos($this->string, $key) !== false) {
                return true;
            }

        }

        return false;
    }
        
    

    public function postReview($username, ReviewRequest $request, Review $review) {
        
        //edited by pradeep.
        if($this->containsLink($request->comment))
        {

            return redirect()->to('#reviews-anchor')->withFlashDanger('First name contains phone number or link. Please remove it.');   
        }

        $guide = $this->user->getGuide($username);
        $review->storeReviewForGuide($guide, $request->get('comment'), $request->get('rating'));
        return redirect()->to('#reviews-anchor')->withFlashSuccess('Your review is send for approval.');
    }

    public function getReviews() {
        $guide = $this->user->getGuide(auth()->user()->username);
        $table = $this->setDatatable();
        return view('frontend.guide.review-edit', compact('guide', 'table'))->withClass('reviews');
    }

    public function approveReview($id, $status) {
        $review = Review::find($id);
        $review->approved = $status;
        if ($review->save())
            return redirect()->back()->withFlashSuccess('Successfully review approved.');
        return redirect()->back()->withFlashDanger('Error during approve process');
    }

    public function deleteReview($id) {
        $review = Review::find($id);
        if ($review->delete())
            return redirect()->back()->withFlashSuccess('Successfully deleted reviews.');
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable() {
        $route = route('api.table.guide.reviews');

        return Datatable::table()
                        ->addColumn('id', 'Reviews', 'Status', 'Created Date')
                        ->addColumn(trans('crud.actions'))
                        ->setUrl($route)
                        ->setOptions(['oLanguage' => trans('crud.datatables')])
                        ->render();
    }

}
