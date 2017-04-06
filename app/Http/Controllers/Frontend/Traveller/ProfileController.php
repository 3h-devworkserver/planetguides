<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Frontend\User\TravellerSettingsRequest;
use App\Http\Requests\Frontend\User\EmailRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Repositories\Frontend\Profileupload;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Booking;
use App\Models\Favorites;
use DB;
use Auth;



/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	/**
	 * @return mixed
     */
	public function index(FormBuilder $formBuilder)
	{
		
		$user = access()->user();
		//var_dump($user->profilePic); die();
		//$profile = Profile::gettraveller($user->id);
		//$profiles = json_encode($profile);
		//var_dump($profiles); die();

		// if($user->gender=='0'){
		// 	$user->gender= "Male";
		// }elseif ($user->gender== '1') {
		// 	$user->gender= "Female";
		// }else{
		// 	$user->gender= 'Other';
		// }
		
         //var_dump($user->gender); die();
		//$profile_nickname = Profile::where('user_id', $user->id)->value('nickname');
		//$profile =var_dump($profile_nickname); die();
		//$user = access()->user();
	//dd($user);
        $form = $formBuilder->create('App\Forms\TravellerProfileForm', [
            'method' => 'PATCH',
            'url' => route('frontend.traveller.profile.update'),
            'model' => $user
           
        ]);
        // return $form->showFieldErrors();
        
       // die('am here');	
         return view('frontend.traveller.profile', compact('form','user'))->withClass('profile dashboard-page');

        
	}
public function dashboard(){
	$user = access()->user();
	$bookings = Booking::where('uid', auth()->id())->orderBy('created_at', 'desc')->get();
	$reviews = $user->reviewsLatest;
	$favorites  = Favorites::where('traveler_id', $user->id)->value('id');
	// if (in_array(25, $favorites)) {
	// 	return "here";
	// }
	// return ($favorites);
	return view('frontend.traveller.dashboard', compact('user','bookings', 'reviews'))->withClass('dashboard-page');
}

	public function picUpload(ProfileUpload $hood){
		//var_dump('a'); die();
		$hood->upload();
		return $hood->result();
	}


	/**
	 * @param UserContract $user
	 * @param UpdateProfileRequest $request
	 * @return mixed
	 */
	public function update(UserContract $user, Request $request) {
		//var_dump('a'); die();
		// return $request->all();

		$this->validate($request, [
        'fname' => 'required',
        'lname' => 'required',
        'nickname' => 'required',
        'gender' => 'required',
        'state' => 'required',
        'city' => 'required',
        'country' => 'required',
        'address' => 'required',
    ]);
		$user->updateProfile($request->all());
		
		return redirect()->route('frontend.traveller.profile')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}

	public function settings(FormBuilder $formBuilder){

		$user = access()->user();
		return view('frontend.traveller.settings', compact('user'))->withClass('traveller-settings');
	}

	public function settingsUpdate(UserContract $user, TravellerSettingsRequest $request) {
		$this->validate($request, [
        'email' => 'required|email|unique:users,email,'.Auth::id(),
        'password' => 'required',
    	]);

		$user->changePassword($request->all());
		$user->changeEmail($request->all());
		// return redirect()->route('frontend.traveller.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
		return redirect()->route('frontend.traveller.profile')->withFlashSuccess(trans("strings.settings_successfully_updated"));
	}

	public function emailUpdate(UserContract $user, EmailRequest $request) {
		$user->changeEmail($request->all());
		return redirect()->route('frontend.traveller.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
	}


	
}