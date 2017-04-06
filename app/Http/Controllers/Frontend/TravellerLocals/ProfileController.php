<?php namespace App\Http\Controllers\Frontend\Traveller;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Requests\Frontend\User\TravellerSettingsRequest;
use App\Http\Requests\Frontend\User\EmailRequest;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Repositories\Frontend\Profileupload;
use Illuminate\Http\Request;


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
		
        $form = $formBuilder->create('App\Forms\TravellerProfileForm', [
            'method' => 'PATCH',
            'url' => route('frontend.traveller.profile.update'),
            'model' => $user
        ]);
       
         return view('frontend.traveller.profile', compact('form','user'))->withClass('profile');

        
	}

	public function picUpload(ProfileUpload $hood){
		$hood->upload();
		return $hood->result();
	}


	/**
	 * @param UserContract $user
	 * @param UpdateProfileRequest $request
	 * @return mixed
	 */
	public function update(UserContract $user, Request $request) {
		$user->updateProfile($request->all());
		
		return redirect()->route('frontend.traveller.profile')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}

	public function settings(FormBuilder $formBuilder){

		$user = access()->user();
		return view('frontend.traveller.settings', compact('user'))->withClass('traveller-settings');
	}

	public function settingsUpdate(UserContract $user, TravellerSettingsRequest $request) {
		$user->changePassword($request->all());
		return redirect()->route('frontend.traveller.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
	}

	public function emailUpdate(UserContract $user, EmailRequest $request) {
		$user->changeEmail($request->all());
		return redirect()->route('frontend.traveller.settings')->withFlashSuccess(trans("strings.settings_successfully_updated"));
	}


	
}