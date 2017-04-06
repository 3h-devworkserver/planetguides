<?php namespace App\Http\Controllers\Frontend\Guide;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\Availability;
use Illuminate\Http\Response;
use Input;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Bannerupload;
use App\Repositories\Frontend\Profileupload;
use App\Repositories\Frontend\Licenseupload;
use App\Repositories\Frontend\Galleryupload;
use Carbon;
use DB;
use App\Models\Favorites;
use Auth;
/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller {

	/**
	 * @param UserContract $user
	 */
	public function __construct(UserContract $user) {
		$this->user = $user;
	}


	/**
	 * @return mixed
     */
	public function index(Request $request)
	{
            
           
           
		$guide = $this->user->getGuide(access()->user()->username);
		javascript()->put([
            'guidePrice' => $guide->price,
            'serviceCharge' =>Setting::first()->charges
            
        ]);
		// Get all reviews that are not spam for the product and paginate them
		 $reviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->paginate(5);
		 if ($request->ajax()) {
            $html = view('frontend.guide.review-list')->with('reviews', $reviews)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		 $recentreviews = $guide->reviews()->approved()->notSpam()->orderBy('created_at', 'desc')->take(config('access.recent_reviews_count'))->get();
		 
		 return view('frontend.guide.profile',['reviews'=>$reviews,'recentreviews'=>$recentreviews, 'images' => $gallerys])->withGuide($guide)->withClass('guide-profile');
		

	}
	
	public function edit() {
		$id = auth()->id();
		$guide = $this->user->findOrThrowException(auth()->id());
		$mainGuideArea = DB::table('guideareas')->lists('guide_area');
		// $languages = DB::table('languages')->lists('language');
		$languages = DB::table('languages')->lists('language', 'id');
		
                
                $availibility = DB::table('availabilitys')
		->select('availibility')
		->where('guide_id', $id)
                ->get();
                
                //dd($availibility);
                
		$selectedMarea = $guide->Profile->mGuidingArea;
		$selectedMarea = DB::table('guideareas')->where('id', $selectedMarea)->first();

	// var_dump($guide->getMGuidArea($selectedMarea) ); die();
	// $selectedMarea = $guide->getMGuidArea($selectedMarea)->guide_area ;
	// return $t;
		if($selectedMarea)
		{
		// $filteredarea = DB::table('guideareas')->where('guide_area', '!=' , $selectedMarea)->lists('guide_area');
		$filteredarea = DB::table('guideareas')->lists('guide_area', 'id');
		// foreach ($filteredarea as $test) {
		// 	return $test;
		// }

		}
		else
		{
			$filteredarea = DB::table('guideareas')->lists('guide_area', 'id');
			// $filteredarea = DB::table('guideareas')->lists('guide_area', '');
		}
		$selectedOarea = $guide->Profile->oGuidingArea;
		$explodestring = explode(',', $selectedOarea);

		$selectedlang = $guide->Profile->language;
		$explodestringlan = explode(',', $selectedlang);
		if($availibility)
		{
		$available = '';
                    foreach ($availibility as $row) 
			{
				$available .= cal_date($row->availibility).',';
			}
                        
                       $available = rtrim($available,','); 
		}
		else
		{
			$available ='';
		}
		return view('frontend.guide.edit')
		->withGuide($guide)
		->withAvailibility($available)
		->withGuidelanguage($languages)
		->withSelectedlang($explodestringlan)
		->withSelectedarea($selectedMarea)
		->withSelectedoarea($explodestring)
		->withGuidearea ($filteredarea )
		->withClass('editProfile');
			
	}

	/**
	 * @param UserContract $user
	 * @param UpdateProfileRequest $request
	 * @return mixed
	 */
	public function update(UserContract $user, UpdateProfileRequest $request) {
		$user->updateProfile($request->all());
		return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
	}

	public function updateExperience(Request $request) {
		$data['stat']='error';
		$experience =$request['experience'];
		$profile = Profile::where('user_id', $request['id'])->update(['experience' => $experience]);
		if($profile){
			$data['stat']='ok';
			$data['value'] = $request['experience'];
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function updateAddress(Request $request) {
		$data['stat']='error';
		$country =$request['country'];
		$state =$request['state'];
		$city =$request['city'];
		$profile = Profile::where('user_id', $request['id'])->update(['country' => $country, 'state' => $state, 'city' => $city]);
		if($profile){
			$data['stat']='ok';
			$data['country'] = $request['country'];
			$data['state'] = $request['state'];
			$data['city'] = $request['city'];
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function updateGender(UserContract $users, Request $request) {
		$data['stat']='error';
		$user=$users->findOrThrowException($request['id']);
		$user->gender = $request['gender'];
		if($user->save()){
			$data['stat']='ok';
			$data['value'] = $request['gender'];
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function updateMguidingArea(Request $request) {
		$data['stat']='error';
		$OtherGuidingArea = $request['OtherGuidingArea'];
		$profile = Profile::where('user_id', $request['id'])->update(['mGuidingArea' => $request['OtherGuidingArea']]);
		if($profile){
			$data['stat']='ok';
			$data['value'] = DB::table('guideareas')->where('id', $request['OtherGuidingArea'])->value('guide_area');
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function postEditeAvability(Request $request) {
		$datas = $_POST['id'];
		parse_str($datas,$data);
		$userid= $data['id'];

		$dates = $_POST['dates'];

//added by --yojan (to remove any unselected dates)
		$prevAvail = Availability::where(['guide_id' => $userid])->get(['availibility']);
	// return $prevAvail;
	foreach ($prevAvail as $prevDate) {
		// return $dates[0];
			// return $prevDate->availibility;

		if (!(in_array(cal_date($prevDate->availibility), $dates))) {
			// return cal_date($prevDate->availibility);
			$delDate = Availability::where(['guide_id' => $userid, 'availibility'=>$prevDate->availibility])->first();
			if($delDate){
				$delDate->delete();
			}
		}
	}
 //end of addition   
           
                 foreach($dates as $row){
                     
                    $aviDates = general_date($row);
                    
                    
                    $rowExists = Availability::where(array('guide_id' => $userid, 'availibility'=>$aviDates))->first();
                    
                    if($rowExists == null){
                        
                        
                        $dataIns['guide_id'] = $userid;
                        $dataIns['availibility'] = general_date($row);
                        Availability::insert($dataIns);
                    }
                    
                }
                
		//$mystring = implode(",", $dates);

               /*
		Availability::where('guide_id', $userid)->update(array(
            'availibility'    =>  $mystring
             ));
              */
		return response()->json(array('success' => 'Availability Dates was successfully Updated.'));
	}

	public function updateOguidingArea(Request $request) {
	$data['stat']='error';

		$OtherGuidingArea = $request['OtherGuidingArea'];
		 $ogaConvertoS = implode(", ",$OtherGuidingArea);
		$profile = Profile::where('user_id', $request['id'])->update(['oGuidingArea' => $ogaConvertoS]);
	if($profile){
		$data['stat']='ok';

		$i=0;
		$string = '';
		foreach ($OtherGuidingArea as $value) {
			if ($i == 0) {
				$string .= DB::table('guideareas')->where('id', $value)->value('guide_area');
			}else{
				$string .= ", ".DB::table('guideareas')->where('id', $value)->value('guide_area');
			}
			$i++;
		}
		$data['value'] = $string;
		// $data['value'] = $ogaConvertoS;
		return response()->json($data);
	}

		return response()->json($data);
	}

	public function updateAbout(Request $request) {
		$data['stat']='error';
		$profile = Profile::where('user_id', $request['id'])->update(['about' => $request['about']]);
		if($profile){
			$data['stat']='ok';
			$data['value'] = $request['about'];
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function updateLanguage(Request $request) {
		$data['stat']='error';


		$req = $request['language'];
		$readyUpdate = implode(", ",$req);

		$profile = Profile::where('user_id', $request['id'])->update(['language' => $readyUpdate]);
		if($profile){
			$data['stat']='ok';
			$i=0;
			$string = '';
			foreach ($req as $value) {
				if ($i == 0) {
					$string .= DB::table('languages')->where('id', $value)->value('language');
				}else{
					$string .= ", ".DB::table('languages')->where('id', $value)->value('language');
				}
				$i++;
			}
			$data['value'] = $string;
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function updateSpecilization(Request $request) {
		$data['stat']='error';
		$req = $request['specilizedarea'];

		$profile = Profile::where('id', $request['id'])->update(['specilizedarea' => $req]);
		if($profile){
			$data['stat']='ok';
			$data['value'] = $req;
			return response()->json($data);
		}

		return response()->json($data);
	}

	public function bannerUpload(BannerUpload $banner){
		$banner->upload();
		return $banner->result();
	}

	public function picUpload(ProfileUpload $profile){
		$profile->upload();
		return $profile->result();
	}

	public function licenseUpload(LicenseUpload $license){
		// return "here";
		$result = $license->upload();
		if ($result) {
			$message['subject'] = 'Review License Upload.';
			$message['body'] = 'The license has been uploaded by this user: '. auth()->user()->email .' Please login to review license upload: http://guidenp.devworkserver.com/admin';
			
			//commented --yojan, this email is actually intended to used for registration process
			// $this->user->notifyAdmin($message);
		} 
		return $license->result();
	}

	public function licenseDelete(LicenseUpload $license,Request $request){
		$this->validate($request, [
        	'id' => 'integer'
    	]);

    	$data['stat']='error';
    	$message['subject'] = 'License delete Notification';
		$message['body'] = 'The license has been deleted by this user: '. auth()->user()->email;
		if($license->delete($request['id'])){
			$data['stat']='ok';

			//commented --yojan, this email is actually intended to used for registration process
			// $this->user->notifyAdmin($message); 

			return response()->json($data);
		}
		return response()->json($data);

		/*return response()->json($data);*/
	}

	public function getVideo(Request $request){
		$guide = $this->user->findOrThrowException(auth()->id());
		$gallerys = $guide->gallery()->where('type','video')->orderBy('created_at', 'desc')->get();
		
		if ($request->ajax()) {
            $html = view('frontend.guide.video-list')->with('gallerys', $gallerys)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		return view('frontend.guide.video',compact('guide'))->withGallerys($gallerys)->withClass('gallery');
	}

	public function getUserVideo($username, Request $request){
		$guide = $this->user->getGuide($username,true);
		$gallerys = $guide->gallery()->where('type','video')->orderBy('created_at', 'desc')->get();
		
		if ($request->ajax()) {
            $html = view('frontend.guide.video-list')->with('gallerys', $gallerys)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		return view('frontend.guide.video',compact('guide'))->withGallerys($gallerys)->withClass('gallery');
	}

	public function videoUpload(Request $request){
		    $data['stat']='error';
		    $rx = '~
			  ^(?:https?://)?                           # Optional protocol
			   (?:www[.])?                              # Optional sub-domain
			   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ Something is wrong string in .com)
			   ([^&]{11})                               # Video id of 11 characters as capture group 1
			    ~x';

			$has_match = preg_match($rx, $request->url, $matches);

			if (! ((boolean) $has_match)) {
				$data['msg'] = 'Please provide a valid youtube url.';
				return response()->json($data);
			}

			$gallery = Gallery::where('user_id', $request->id)->where('path', $request->url)->first();
			if (!$gallery) {
				$gallery = Gallery::create([
					'user_id' => $request->id,
					'caption' => $request,
					'path' => $request->url,
					'type' => 'video',
				]);
			}

			if($gallery){
				$data['stat']='ok';
				$data['msg'] = 'Youtube video embedded successfully';
				return response()->json($data);
			}
			$data['msg'] = 'Problem occured during uploading video. Report to administrator this error.';
			return response()->json($data);

	}

	//upload video from backend as addguide

	public function addvideoUpload(Request $request){
		    $data['stat']='error';
		    $test = explode('watch?v=', $request->url);
		    $test = explode('&list=', $test[1]);
			$gallery = Gallery::create([
										'user_id' => $request->id,
										'caption' => $request->caption,
										'path' => $request->url,
										'imagesmall'=> $test[0],
										'type' => 'video',
									]);

			if($gallery){
				$data['stat']='ok';
				$data['msg'] = 'Youtube video embedded successfully';

				$userid = $_POST['id'];
				$videos = DB::table('gallerys')
			->where('user_id', $userid)
			->where('type','video')->orderBy('created_at', 'desc')->paginate(8);
			$html = view('backend.gallery.addvideos')->with('videos', $videos)->render();
            return response()->json(array('success' => 'Youtube Video  was successfully Added.', 'html' => $html));
			}
			$data['msg'] = 'Problem occured during uploading video. Report to administrator this error.';
			return response()->json($data);

	}

//edited by yojan, previous code is commented below
	public function videoDelete(Request $request){
		$gallery = Gallery::find($request->id);
		if($gallery->delete()){
			if ($request->ajax())
				{
					$data['stat']='ok';
					$userid = $request['user_id'];
					$user = $this->user->findOrThrowException($userid, true);
					$images = DB::table('gallerys')
					->where('user_id', $userid)
					->where('type','video')->orderBy('created_at', 'desc')->paginate(8);
			
					$html = view('backend.gallery.addvideos')->with('user', $user)->with('videos', $images)->render();
		            return response()->json(array('success' => 'Successfully Deleted.', 'html' => $html, 'stat' => 'ok'));

				}



			return view('frontend.guide.video')->withFlashSuccess('Video Successfully deleted.')->withClass('gallery');
		}
	}
	// public function videoDelete(Request $request){
	// 	$gallery = Gallery::find($request->id);
	// 	if($gallery->delete())
	// 		return view('frontend.guide.video')->withFlashSuccess('Video Successfully deleted.')->withClass('gallery');
	// }


	public function myvideosDelete(Request $request){
		$gallery = Gallery::find($request->id);
		if($gallery->delete()){
			$data['stat']='ok';
			$data['msg'] = 'Youtube video embedded successfully';
			return response()->json($data);
		}	
	}

//get otherguidearea exciping selected from main guide area

	public function getotherguidearea(){
		$selected = $_GET['selected'];

		$mainGuideArea = DB::table('guideareas')->where('guide_area', '!=' , $selected)->lists('guide_area');


$array = preg_grep("/^$selected$/i", $mainGuideArea, PREG_GREP_INVERT);

$html = view('backend.gallery.otherguidearea')->with('options', $array)->render();
            return response()->json(array('success' => 'true', 'html' => $html));
	}



	//get otherguidearea exciping selected from main guide area (edit profile frontend)

	public function editotherguidearea(){
		$selected = $_GET['selected'];

		$mainGuideArea = DB::table('guideareas')->where('guide_area', '!=' , $selected)->lists('guide_area');


$array = preg_grep("/^$selected$/i", $mainGuideArea, PREG_GREP_INVERT);

$html = view('frontend.guide.otherguidearea')->with('options', $array)->render();
            return response()->json(array('success' => 'true', 'html' => $html));
	}




	public function videosDelete(Request $request){
		$gallery = Gallery::find($request->id);
		if($gallery->delete())
		{
			$data['stat']='ok';
				$data['msg'] = 'Youtube video you embedded was successfully deleted';

				$userid = $request['user_id'];
				$videos = DB::table('gallerys')
			->where('user_id', $userid)
			->where('type','video')->orderBy('created_at', 'desc')->paginate(8);
			$html = view('backend.gallery.addvideos')->with('videos', $videos)->render();
            return response()->json(array('success' => 'Video Successfully deleted.', 'html' => $html));
        }
        return response()->json(array('success' => 'Something Went wrong.'));
	}


	


	public function getGallery(Request $request){
		$guide = $this->user->findOrThrowException(auth()->id());
		$gallerys = $guide->gallery()->where('type','image')->orderBy('created_at', 'desc')->paginate(12);
		
		if ($request->ajax()) {
            $html = view('frontend.guide.gallery-list')->with('gallerys', $gallerys)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		return view('frontend.guide.gallery')->withUserid(auth()->id())->withGallerys($gallerys)->withClass('gallery');
	}

	public function getUserGallery($username,Request $request){
		$guide = $this->user->getGuide($username,true);
		$gallerys = $guide->gallery()->where('type','image')->orderBy('created_at', 'desc')->paginate(12);
		
		if ($request->ajax()) {
            $html = view('frontend.guide.gallery-list')->with('gallerys', $gallerys)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
		return view('frontend.guide.gallery')->withGallerys($gallerys)->withClass('gallery');
	}

	public function galleryUpload(GalleryUpload $gallery){
		$data['stat']='error';
		$data['msg'] = 'Unknown error';
		if ($this->user->checkUserAuth(['1','2'])) {
    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
    		return response()->json($data); 
    	}
    	
		$gallery->upload();{
			$data['stat']='ok';
			return response()->json($data); 
		}
		// return $gallery->result();
	}

	//galleryupload form addguide backend
	public function addgalleryUpload(GalleryUpload $gallery){
		$data['stat']='error';
		$data['msg'] = 'Unknown error';
		if ($this->user->checkUserAuth(['1','2'])) {
    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
    		return response()->json($data); 
    	}
    	
		$galleryup = $gallery->upload();


		if($galleryup == true)
		{
			$userid = $_POST['id'];
			$user = $this->user->findOrThrowException($userid, true);
			$images = DB::table('gallerys')
			->where('user_id', $userid)
			// ->where('type','image')->orderBy('created_at', 'desc')->paginate(8);
			->where('type','image')->orderBy('created_at', 'desc')->get();
			$html = view('backend.gallery.addgallery')->with('user', $user)->with('gallerys', $images)->render();
            return response()->json(array('success' => 'Gallery was successfully Added.', 'html' => $html));
        }
	}
//delete licence from backend
//edited by -- yojan , previous code is commented below
	public function addlicenseDelete(GalleryUpload $gallery,Request $request){
		// return "here";
		// return $request->all();
		$this->validate($request, [
        	'id' => 'integer'
    	]);
		$data['stat']='error';
		$data['msg'] = 'Unknown error';
		
    	if ($this->user->checkUserAuth(['1','2'])) {
    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
    		return response()->json($data); 
    	}
    	
		if($gallery->delete($request['id'])){
			$data['stat']='ok';
		}
		if ($request->ajax())
		{
			$userid = $request['user_id'];
			$images = DB::table('gallerys')
			->where('user_id', $userid)
			// ->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
			->where('type','license')->orderBy('created_at', 'desc')->get();
	
			$html = view('backend.gallery.addguideLicence')->with('licenses', $images)->render();
            return response()->json(array('success' => 'Successfully Deleted.', 'html' => $html));

		}
	}
//previous code
	// public function addlicenseDelete(GalleryUpload $gallery,Request $request){
	// 	// return "here";
	// 	$this->validate($request, [
 //        	'id' => 'integer'
 //    	]);
	// 	$data['stat']='error';
	// 	$data['msg'] = 'Unknown error';
		
 //    	if ($this->user->checkUserAuth(['1','2'])) {
 //    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
 //    		return response()->json($data); 
 //    	}
    	
	// 	if($gallery->delete($request['id'])){
	// 		$data['stat']='ok';
	// 	}
	// 	if ($request->ajax())
	// 	{
	// 		$userid = $request['user_id'];
	// 		$images = DB::table('gallerys')
	// 		->where('user_id', $userid)
	// 		->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
	
	// 		$html = view('backend.gallery.addguideLicence')->with('licenses', $images)->render();
 //            return response()->json(array('success' => 'Successfully Deleted.', 'html' => $html));

	// 	}
	// }

	//delete gallery form backend
	// edited by --yojan, previous function is commented below this function
	public function galleryDelete(GalleryUpload $gallery,Request $request){
		$this->validate($request, [
        	'id' => 'integer'
    	]);
		$data['stat']='error';
		$data['msg'] = 'Unknown error';
		
    	if ($this->user->checkUserAuth(['1','2'])) {
    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
    		return response()->json($data); 
    	}
    	
		if($gallery->delete($request['id'])){
			// $data['stat']='ok';
			// return response()->json($data); 
		
		if ($request->ajax())
		{
			$data['stat']='ok';
			$userid = $request['user_id'];

			if(empty($userid)){
				$userid = auth()->id();
			}
			$user = $this->user->findOrThrowException($userid, true);
			$images = DB::table('gallerys')
			->where('user_id', $userid)
			->where('type','image')->orderBy('created_at', 'desc')->paginate(8);
	
			$html = view('backend.gallery.addgallery')->with('user', $user)->with('gallerys', $images)->render();
            return response()->json(array('success' => 'Successfully Deleted.', 'html' => $html, 'stat' => 'ok'));

		}
		}
	}

	// public function galleryDelete(GalleryUpload $gallery,Request $request){
	// 	$this->validate($request, [
 //        	'id' => 'integer'
 //    	]);
	// 	$data['stat']='error';
	// 	$data['msg'] = 'Unknown error';
		
 //    	if ($this->user->checkUserAuth(['1','2'])) {
 //    		$data['msg'] = 'Sorry you do not have access to delete this item!!!';
 //    		return response()->json($data); 
 //    	}
    	
	// 	if($gallery->delete($request['id'])){
	// 		$data['stat']='ok';
	// 		return response()->json($data); 
	// 	}
	// 	if ($request->ajax())
	// 	{
	// 		$data['stat']='ok';
	// 		$userid = $request['user_id'];
	// 		$user = $this->user->findOrThrowException($userid, true);
	// 		$images = DB::table('gallerys')
	// 		->where('user_id', $userid)
	// 		->where('type','image')->orderBy('created_at', 'desc')->paginate(8);
	
	// 		$html = view('backend.gallery.addgallery')->with('user', $user)->with('gallerys', $images)->render();
 //            return response()->json(array('success' => 'Successfully Deleted.', 'html' => $html, 'stat' => 'ok'));

	// 	}
	// }

	public function galleryEdit(Request $request){
		$data['stat']='error';
		if ($request->ajax()) {
			if ($this->user->checkUserAuth(['1','2'])) {
    			$data['msg'] = 'Sorry you do not have access to delete this item!!!';
    			return response()->json($data); 
    		}

			$gallery = Gallery::find($request->id);
			$gallery->caption = $request->caption;
			if($gallery->save()){
				$data['msg']='Successfully caption updated.';
				$data['stat']='ok';
				return response()->json($data);
			}
			else{
				$data['msg']='Some error occured during updating caption.';
				return response()->json($data);
			}

		}
		
	}
        
        
        function PickDisableDates(){
            
            echo '10/04/2016,10/11/2016,10/05/2016,10/12/2016';
            
        }
	


	
}