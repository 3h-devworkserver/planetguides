<?php namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\MarkUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\RestoreUserRequest;
use App\Http\Requests\Backend\Access\User\StoreLicenceRequest;
use App\Http\Requests\Backend\Access\User\ChangeUserPasswordRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Http\Requests\Backend\Access\User\PermanentlyDeleteUserRequest;
use App\Http\Requests\Backend\Access\User\ResendConfirmationEmailRequest;
use App\Repositories\Frontend\Profileupload;
use Illuminate\Http\Request;
use Datatable;
use Illuminate\Http\Response;
use DB;
use Input;
use App\Models\Gallery;
use App\Models\Profile;
use App\Models\Booking;
use App\Models\Availability;
use App\Models\Setting;
use App\Models\GuideArea;
use App\Models\Language;
use App\Models\Guide;



/**
 * Class UserController
 */
class UserController extends Controller {

	/**
	 * @var UserContract
	 */
	protected $users;

	/**
	 * @var RoleRepositoryContract
	 */
	protected $roles;

	/**
	 * @var PermissionRepositoryContract
	 */
	protected $permissions;

	/**
	 * 
	 * @var validating string from input.
	 */
	protected $string;

	/**
	 * @param UserContract $users
	 * @param RoleRepositoryContract $roles
	 * @param PermissionRepositoryContract $permissions
	 */
	public function __construct(UserContract $users, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions) {
		$this->users = $users;
		$this->roles = $roles;
		$this->permissions = $permissions;
	}

	
	/**
	 * @return mixed
	 */
	public function index() {
		
		 $table = $this->setDatatable('1');
		 return view('backend.access.index', compact('table'));
	}

	/**
	 * @return mixed
	 */
	public function getGuides(UserContract $users) {

//used below code to update guide's coutry,state and city when this feature was first added
		// $users = $users->getUsers('1', '2');
		// // return $users;
		// foreach($users as $user){
		// 	$profile = $user->profile;
		// 	if(!empty($profile)){
		// 		if( (empty($profile->country)) && (empty($profile->state)) && (empty($profile->city)) ) {
		// 			$profile->update(['country'=>'Nepal', 'state'=>'Bagmati', 'city'=>'Kathmandu']);
		// 			return $profile;
		// 		}
		// 	}
		// }

		 $table = $this->setDatatable(1,2); //first arg is status and second is role of users
		 return view('backend.access.getguide', compact('table'));
	}


	/**
	 * @return mixed
	 */
	public function getTravellers() {
		
		 $table = $this->setDatatable(1,3);
		 return view('backend.access.index', compact('table'));
	}


	/**
	 * @return mixed
	 */
	public function getAddGuide() {		
		// $mainGuideArea = DB::table('profiles')->lists('mGuidingArea', 'id');
		// $mystring = implode(",", $mainGuideArea);
		// $myArray = explode(',', $mystring);
		// $uniqueString = array_unique($myArray);
		// $language = DB::table('profiles')->lists('language');
		// $languagestring = implode(",", $language);
		// $lanArray = explode(',', $languagestring);
		// $lanString = array_unique($lanArray);

		$mainGuideArea = GuideArea::all();
		//$mainGuideid = DB::table('guideareas')->lists('guide_area', 'id');
		//var_dump($mainGuideArea->id); die();
		$languages = Language::all();;
		//$languages = DB::table('languages')->lists('language');
		 return view('backend.access.addguide')
		  ->with('options',$mainGuideArea)
		  ->with('language',$languages)
		  ->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withPermissions($this->permissions->getAllPermissions());
		
	}


	/**
	 * @return mixed
	 */
	public function getGeneralUsers() {
		
		 // $table = $this->setDatatable(1,3);
		 return view('backend.general.index')
		 ->withRoles($this->roles->getAllRoles());
	}

	/**
	 * @return mixed
	 */
	public function postAddGuide() {

		 $table = $this->setDatatable(1,3);
		 return view('backend.general.index')
		 ->withRoles($this->roles->getAllRoles());
	}



	/**
	 * @return mixed
	 */
	public function postAvailability() {
		$datas = $_POST['id'];
		parse_str($datas,$data);
		$userid= $data['id'];

		$dates = $_POST['dates'];
                
                 foreach($dates as $row){
                     
                    $aviDates = general_date($row);
                    
                    
                    $rowExists = Availability::where(array('guide_id' => $userid, 'availibility'=>$aviDates))->first();
                    
                    if($rowExists == null){
                        
                        
                        $dataIns['guide_id'] = $userid;
                        $dataIns['availibility'] = general_date($row);
                        Availability::insert($dataIns);
                    }
                    
                }
		// $datas = $_POST['id'];
		// parse_str($datas,$data);
		// $userid= $data['id'];


		// $dates = $_POST['dates'];
		// $mystring = implode(",", $dates);



		// Availability::where('guide_id', $userid)->update(array(
  //           'availibility'    =>  $mystring
  //       ));
		
		return response()->json(array('success' => 'Availability Dates was successfully Assigned.'));
	}

	/**
	 * @return mixed
	 */
	//edited by -- yojan , previous code is commented below
		public function postLicence(UserContract $license, Request $request) {
		$userid = $_POST['id'];
		$result = $license->upload($license);
		// echo "here i";
        if ($request->ajax())
{
	$images = DB::table('gallerys')
	->where('user_id', $userid)
	// ->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
	->where('type','license')->orderBy('created_at', 'desc')->get();

		// return $images;

	$html = view('backend.gallery.addguideLicence')->with('licenses', $images)->render();
	// return $html;
            return response()->json(array('success' => 'Licence was successfully Uploaded.', 'html' => $html));

      //return response()->json(array('success' => 'Licence was successfully Uploaded.'));
     //return response()->json($datas);
}
		return redirect()->back()->withFlashSuccess(trans("alerts.users.licenceuploaded"));

	}
//previous code
// 	public function postLicence(UserContract $license, Request $request) {
// 		$userid = $_POST['id'];
// 		$result = $license->upload($license);
		
//         if ($request->ajax())
// {
// 	$images = DB::table('gallerys')
// 	->where('user_id', $userid)
// 	->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
	
// 	$html = view('backend.gallery.addguideLicence')->with('licenses', $images)->render();
	
//             return response()->json(array('success' => 'Licence was successfully Uploaded.', 'html' => $html));

//       //return response()->json(array('success' => 'Licence was successfully Uploaded.'));
//      //return response()->json($datas);
// }
// 		return redirect()->back()->withFlashSuccess(trans("alerts.users.licenceuploaded"));

// 	}


	/**
	 * @return mixed
	 */
	public function postCertification(UserContract $license, Request $request) {
		$userid = Input::get('id');
		$result = $license->certification($license);
        if ($result == true)
{

	
            return response()->json(array('success' => 'User Certification was successfully Verified.'));

      //return response()->json(array('success' => 'Licence was successfully Uploaded.'));
     //return response()->json($datas);
}
		return response()->json(array('success' => 'Something went wrong please check.'));

	}

//approve certificate from unapproved license management
	  public function certifyGuide($id){
        // return "here";
       $guide = Guide::where('user_id', $id)->update(['certified' => 1]);
       if ($guide) {
            return redirect()->to('admin/license')->withFlashSuccess('Guide is successfully certified.');
       }else{
            return redirect()->to('admin/license')->withFlashDanger('Error during certifying guide');
       }

    }


	/**
	 * @return mixed
	 */
	public function postProfilePic(UserContract $license, Request $request) {
		// return $request->all();
		$userid = ($request['user_id']);
		$path = ($request['path']);
        $pathSmall =  str_replace('resize', 'original', $path);

		Profile::where('user_id', $userid)->update(['profilesmallImg' => $path, 'profileImg'=> $pathSmall]);
        
        return response()->json(array('success' => 'Profile Picture was successfully Set.'));
	}



	/**
	 * @param CreateUserRequest $request
	 * @return mixed
     */
	public function create(CreateUserRequest $request) {
		//var_dump('create'); die();
		return view('backend.access.create')
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withPermissions($this->permissions->getAllPermissions());
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
	
	
	/**
	 * Check if input contains any links // edited by pradeep
	 * @param  [type] $string [description]
	 * @return [type] boolean        [description]
	 */
	public function containsLink($fieldname)
	{
		$this->string=strtolower($fieldname);
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

	public function containsPhoneNumber($fieldname)
	{
		$this->string=strtolower($fieldname);
		$this->replaceStr_phone();

		$toCheck = "";

		for($i = 0 ; $i < 10; $i++)
   		{

	      	$toCheck = $toCheck."0";

   		}

   		if (strpos($this->string, $toCheck) !== false) {
				return true;
			}

		return false;
	}
	/**
	 * [replaceStr description]
	 * @return [type] [description]
	 */
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

	public function replaceStr_phone()
	{
		$this->replace(" ", "")
			 
			 ->replace("(dot)", ".")

			 ->replace("dot", ".")

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



	         //english



	         ->replace("one", "0")



	         ->replace("two", "0")



	         ->replace("three", "0")



	         ->replace("four", "0")



	         ->replace("five", "0")



	         ->replace("six", "0")



	         ->replace("seven", "0")



	         ->replace("eight", "0")



	         ->replace("nine", "0")



	         ->replace("zero", "0")



	         ->replace("1", "0")



	         ->replace("2", "0")



	         ->replace("3", "0")



	         ->replace("4", "0")



	         ->replace("5", "0")



	         ->replace("6", "0")



	         ->replace("7", "0")



	         ->replace("8", "0")



	         ->replace("9", "0")

	         //french



	         ->replace("un", "0")



	         ->replace("deux", "0")



	         ->replace("trois", "0")



	         ->replace("quatre", "0")



	         ->replace("cinq", "0")



	         ->replace("sept", "0")



	         ->replace("huit", "0")



	         ->replace("neuf", "0")



	         ->replace("zéro", "0")


	         //german



	         ->replace("eins", "0")



	         ->replace("zwei", "0")



	         ->replace("drei", "0")



	         ->replace("vier", "0")



	         ->replace("fünf", "0")



	         ->replace("funf", "0")



	         ->replace("sechs", "0")



	         ->replace("sieben", "0")



	         ->replace("acht", "0")



	         ->replace("neun", "0")



	         ->replace("null", "0")



	         //chinese



	         ->replace("一", "0")



	         ->replace("二", "0")



	         ->replace("三", "0")



	         ->replace("四", "0")



	         ->replace("五", "0")



	         ->replace("六", "0")



	         ->replace("七", "0")



	         ->replace("八", "0")



	         ->replace("九", "0")



	         ->replace("零", "0")



	         ->replace("壹", "0")



	         ->replace("贰", "0")



	         ->replace("貳", "0")



	         ->replace("叁", "0")



	         ->replace("參", "0")



	         ->replace("肆", "0")



	         ->replace("伍", "0")



	         ->replace("陆", "0")



	         ->replace("陸", "0")



	         ->replace("柒", "0")



	         ->replace("捌", "0")



	         ->replace("捌", "0")



	         ->replace("〇", "0");

	         return $this; 

	}

	public function validateforphone($request)
	{
		if($this->containsPhoneNumber($request->fname))
		{

			return  true;	 
		}

		if($this->containsPhoneNumber($request->lname))
		{
			return  true;
		}


		if($this->containsPhoneNumber($request->city))
		{
			return  true;
		}

		if($this->containsPhoneNumber($request->about))
		{
			return  true;
		}
		
		if($this->containsPhoneNumber($request->specilizedarea))
		{
			return  true;
		}

		return false;	
	}

	public function validateforlinks($request)
	{
		if($this->containsLink($request->fname))
		{

			return  true;	 
		}

		if($this->containsLink($request->lname))
		{
			return  true;
		}

		if($this->containsLink($request->phone))
		{
			return  true;
		}

		if($this->containsLink($request->city))
		{
			return  true;
		}

		if($this->containsLink($request->about))
		{
			return  true;
		}
		
		if($this->containsLink($request->specilizedarea))
		{
			return  true;
		}

		return false;
	}

	/**
	 * @param StoreUserRequest $request
	 * @return mixed
     */
	public function store(StoreUserRequest $request) {
		//edited from pradeep.
		if($this->validateforlinks($request))
		{
			return response()->json(['error' => 'First name contains phone number or link. Please remove it.'], 404);
		} 

		if ( $this->validateforphone($request)) {
			return response()->json(['error' => 'First name contains phone number or link. Please remove it.'], 404);
		}


		$datas =  $this->users->create(
			$request->except('assignees_roles', 'permission_user'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		);
		return response()->json($datas);
		 // return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.created"));
	}

	/**
	 * @param $id
	 * @param EditUserRequest $request
	 * @return mixed
     */
	public function edit($id, Request $request) {
		$user = $this->users->findOrThrowException($id, true);

//for traveller only
	if($user->hasRole('Traveller')){
		$gallerys = $user->gallery()->where('type','image')->orderBy('created_at', 'desc')->get();
		
		// return $user;
		return view('backend.access.edittraveller', compact('user'));
	}


//end of for traveller only


		//var_dump($user); die();
		$videos = $user->gallery()->where('type','video')->orderBy('created_at', 'desc')->get();
		$license = $user->gallery()->where('type','license')->orderBy('created_at', 'desc')->get();
		$images = $user->gallery()->where('type','image')->orderBy('created_at', 'desc')->get();
		
//edited- --yojan , previous code is commented below
		$availibility = DB::table('availabilitys')
		->select('availibility')
		->where('guide_id', $id)
		->get();
		// $availibility = DB::table('availabilitys')
		// ->select('availibility')
		// ->where('guide_id', $id)
		// ->first();
//end editing

		$mainGuideArea = DB::table('guideareas')->lists('guide_area');
		/*$mainGuideArea = DB::table('guideareas')
            ->join('profiles', 'profiles.user_id', '=', 'guideareas.user_id') 
            ->where('profiles.mGuidingArea' , '=', 'guideareas.id')                         
            ->select('guideareas.guide_area')
            ->get();
            */
            //var_dump($mainGuideArea); die();
		$languages = DB::table('languages')->get();
		//var_dump($languages); die();
		$selectedMarea = $user->Profile->mGuidingArea;
		//var_dump($selectedMarea); die();

		//$selectedMarea = DB::table('guideareas')->where('id', '=' , $selectedMarea)->lists('guide_area');
		//var_dump($selectedMarea); die();
		//$selectedMareas = $user->Profile->mGuidingArea;
		$filteredarea = DB::table('guideareas')->where('guide_area', '!=' , $selectedMarea)->get();
		
		//var_dump($filteredarea); die();
		$selectedMarea = $user->Profile->mGuidingArea;
		//var_dump($selectedMarea); die();
		//$selectedMareaid =$user->Profile->mGuidingArea;
		//$selectedMarea = GuideArea::where('id', '=', intval($selectedMarea))->all();
		//$selectedMarea = DB::table('guideareas')->where('id', '=' , intval($selectedMarea))->lists('id','guide_area');
		//var_dump($selectedMarea->id); die();
		//for Marea start
		
		$selectedMarea = explode(',', $selectedMarea);
		//var_dump($selectedMarea); die();
		$arrayMarea =array();
            foreach($selectedMarea as $key=>$selectedMarea) {             
                                  
              $arrayMarea[]= intval($selectedMarea);         
            }
//var_dump($arrayMarea); die();
            $count =count($arrayMarea);
            $arrayMarea1 =array();
            for($x=0; $x<$count; $x++){            	
           		$array = (array)(DB::table('guideareas')->where('id', '=' , $arrayMarea[$x])->get());           		
            	$arrayMarea1[$x] =$array;
            }  
            foreach ($arrayMarea1 as $arrayMarea1) {
                 	$arrayMarea1 =(array)$arrayMarea1;
                 }     
        
		$selectedMarea = $arrayMarea1;
		//var_dump($selectedMarea); die();
		
		
		//var_dump($selectedMarea->id); die();
		//$selectedMarea = implode(' ', $selectedMarea);
		//Marea end

		//$selectedMarea = DB::table('guideareas')->where('id', '=' , $selectedMarea)->value('guide_area');
		//var_dump($selectedMarea); die();


		$selectedGender = $user->gender;
		$selectedOarea = $user->Profile->oGuidingArea;
		$explodestring = explode(',', $selectedOarea);
		//var_dump($explodestring); die();
		$explodestringid =$explodestring;
		//start other area
		//$selectedMarea = explode(',', $selectedMarea);
		//var_dump($selectedMarea); die();
		$arrayOarea =array();
            foreach($explodestring as $explodestring) {             
                                  
              $arrayOarea[]= intval($explodestring);         
            }
//var_dump($arrayOarea); die();
            $count =count($arrayOarea);
            $arrayOarea1 =array();
            for($x=0; $x<$count; $x++){            	
           		$array = DB::table('guideareas')->where('id', '=' , $arrayOarea[$x])->get();
            	$arrayOarea1[$x] =$array;
            }  
           //var_dump($arrayOarea1); die();
              
             $arrayOarea2 =array();
            foreach ($arrayOarea1 as  $arrayOarea1) {
                 	$arrayOarea2[] =(array)$arrayOarea1;
                 }   
                  
        
		$explodestring = $arrayOarea2;		
	//var_dump($explodestring); die();
		
		                  
		//var_dump($explodestring); die();

		//end other area

		$selectedlang = $user->Profile->language;
		$selectedskill = $user->Profile->specilizedarea;
		//language start
		$selectedlang = explode(',', $selectedlang);           
           // var_dump($selectedlang); die();
		
            $arraylang =array();
            foreach($selectedlang as $key=>$selectedlang) {             
                                  
              $arraylang[]= intval($selectedlang);         
            }
            //var_dump($arraylang); die();
            $count =count($arraylang);
            $arraylang1 =array();
            for($x=0; $x<$count; $x++){            	
           		$array = DB::table('languages')->where('id','=', $arraylang[$x])->get();
           		//var_dump($arraylang[$x]);
            	$arraylang1[$x] =$array;
            	// var_dump($arraylang1[$x]->language);
            }  //die();
//var_dump($arraylang1); die();
                 $arrayLang2 =array();
            foreach ($arraylang1 as  $arraylang1) {
                 	$arrayLang2[] =(array)$arraylang1;
                 }
        
		$explodestringlan = $arrayLang2; 
		      
        
		//$explodestringlan = $selectedlang;
		//var_dump($explodestringlan); die();
		//language end

//edited --yojan , previous code is commented below
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
// if($availibility)
// {
// 		foreach ($availibility as $available) {
// 			$available;
// 		}

// 	}
// 	else
// 	{
// 		$available ='';
// 	}
//end editing

	$user->gallery()->where('type','license')->orderBy('created_at', 'desc')->paginate(8);
		if ($request->ajax()) {
            $html = view('backend.gallery.images')->with('gallerys', $images)->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
        // return $available;
		return view('backend.access.edit')
			->withUser($user)
			->withGallerys($images)
			->withVideos($videos)
			->withLicenses($license)
			->withGuidearea($filteredarea)			
			->withSelectedarea($selectedMarea)
			->withSelectedoarea($explodestring)
			->withSelectedlang($explodestringlan)
			->withGuidelanguage($languages)
			->withSelectedskill($selectedskill)
			->withAvailibility($available)
			->withUserRoles($user->roles->lists('id')->all())
			->withRoles($this->roles->getAllRoles('sort', 'asc', true))
			->withUserPermissions($user->permissions->lists('id')->all())
			->withPermissions($this->permissions->getAllPermissions());

	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 * @return mixed
	 */
	public function update($id, UpdateUserRequest $request) {
		//var_dump($experience); die();
		if(isset($request['roles'])){
			//var_dump('a'); die();
			$this->users->roleUpdate($id,$request->only('assignees_roles'),$request->only('permission_user'));
		}
		else{
			//var_dump('b'); die();
			//var_dump($id); die();
			$this->users->update($id,$request->except('assignees_roles', 'permission_user'));
		}

		 return redirect()->route('admin.access.users.edit', $id)->withFlashSuccess(trans("alerts.users.updated"));
	}

	//update traveller from backend --yojan
	public function updateTraveller($id,EditUserRequest $request){
		$this->validate($request, [
        'fname' => 'required',
        'lname' => 'required',
        'nickname' => 'required',
        'email' => 'required',
        'gender' => 'required',
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'zip' => 'required',
        'address' => 'required',
        // 'status' => 'required',
        // 'confirmed' => 'required',
    ]);
		$traveller = $this->users->findOrThrowException($id, true);
// return $traveller;
		$traveller->update([
				'fname' => $request->fname,
				'lname' => $request->lname,
				'email' => $request->email,
				'gender' => $request->gender,
				'status' => $request->status,
				'confirmed' => $request->confirmed,

			]);
		$profile = $traveller->Profile;
		$profile->update([
				'about'=>$request->about,
				'nickname'=>$request->nickname,
				'country'=>$request->country,
				'state'=>$request->state,
				'city'=>$request->city,
				'zip'=>$request->zip,
				'address'=>$request->address,
			]);
		 return redirect()->route('admin.access.users.edit', $id)->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 * @return mixed
	 */
//edited by --yojan , previous function commented below
	public function postEditAvailability() {
		$datas = $_POST['id'];
		parse_str($datas,$data);
		$userid= $data['id'];
// return $data;
		$dates = $_POST['dates'];
// return $dates;

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
		// return "pause";
		foreach($dates as $row){
                     
                    $aviDates = general_date($row);
                    
                    
                    $rowExists = Availability::where(array('guide_id' => $userid, 'availibility'=>$aviDates))->first();
                    
                    if($rowExists == null){
                        
                        
                        $dataIns['guide_id'] = $userid;
                        $dataIns['availibility'] = general_date($row);
                        Availability::insert($dataIns);
                    }
                    
                }

                // $mystring = implode(",", $dates);
// return $mystring;

		// Availability::where('guide_id', $userid)->update(array(
  //           'availibility'    =>  $mystring
  //       ));

		return response()->json(array('success' => 'Availability Dates was successfully Updated.'));
	}
	// public function postEditAvailability() {
	// 	$datas = $_POST['id'];
	// 	parse_str($datas,$data);
	// 	$userid= $data['id'];
	// 	$dates = $_POST['dates'];
	// 	$mystring = implode(",", $dates);

	// 	Availability::where('guide_id', $userid)->update(array(
 //            'availibility'    =>  $mystring
 //        ));

	// 	return response()->json(array('success' => 'Availability Dates was successfully Updated.'));
	// }



	/**
	 * @param $id
	 * @param DeleteUserRequest $request
	 * @return mixed
     */
	public function destroy($id, DeleteUserRequest $request) {
		//  admin delete come to this function
		//var_dump('a'); die();
		$this->users->delete($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
	}

	/**
	 * @param $id
	 * @param PermanentlyDeleteUserRequest $request
	 * @return mixed
     */
	public function delete($id, PermanentlyDeleteUserRequest $request) {
		//var_dump('b'); die();
		$this->users->delete($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
	}

	/**
	 * @param $id
	 * @param RestoreUserRequest $request
	 * @return mixed
     */
	public function restore($id, RestoreUserRequest $request) {
		$this->users->restore($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.restored"));
	}

	/**
	 * @param $id
	 * @param $status
	 * @param MarkUserRequest $request
	 * @return mixed
     */
	public function mark($id, $status, MarkUserRequest $request) {
		$this->users->mark($id, $status);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @return mixed
	 */
	public function deactivated() {
		$table = $this->setDatatable('0');
        return view('backend.access.deactivated', compact('table'));
	}

	/**
	 * @return mixed
	 */
	public function deleted() {
		
		return view('backend.access.deleted')
			->withUsers($this->users->getDeletedUsersPaginated(25));
	}

	/**
	 * @return mixed
	 */
	public function banned() {
		return view('backend.access.banned')
			->withUsers($this->users->getUsersPaginated(25, 2));
	}

	/**
	 * @param $id
	 * @param ChangeUserPasswordRequest $request
	 * @return mixed
     */
	public function changePassword($id, ChangeUserPasswordRequest $request) {
		return view('backend.access.change-password')
			->withUser($this->users->findOrThrowException($id));
	}

	/**
	 * @param $id
	 * @param UpdateUserPasswordRequest $request
	 * @return mixed
	 */
	public function updatePassword($id, UpdateUserPasswordRequest $request) {
		$this->users->updatePassword($id, $request->all());
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated_password"));
	}

	/**
	 * @param $user_id
	 * @param AuthenticationContract $auth
	 * @param ResendConfirmationEmailRequest $request
	 * @return mixed
     */
	public function resendConfirmationEmail($user_id, AuthenticationContract $auth, ResendConfirmationEmailRequest $request) {
		$auth->resendConfirmationEmail($user_id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.confirmation_email"));
	}


	public function picUpload(ProfileUpload $hood){
		$hood->upload();
		return $hood->result();
	}

//to upload traveller pic from backend
	public function picUploadTraveller($id, ProfileUpload $hood){
		$hood->uploadTravellerPic($id);
		return $hood->result();
	}



	/**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable($status,$role=null)
    {
        

        if ($status) {
            
            if ($role!=null && $role==2){
            	$route = route('api.table.users.guides');
            	 return Datatable::table()
		            ->addColumn(trans('crud.users.id'), trans('crud.users.name'), trans('crud.users.email'), trans('Guide Points'), trans('crud.users.confirmed'),trans('crud.users.roles'),trans('crud.users.certified'),trans('crud.users.created'))
		            ->addColumn(trans('crud.actions'))
		            ->setUrl($route)
		            ->setOptions(['responsive' => true, 'oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
		            // ->setOrder(array(4=>'asc')) // sort by roles
		            ->setOrder(array(1=>'asc')) // sort by second column
		            ->render();
            }
            elseif ($role!=null && $role==3){
            	$route = route('api.table.users.travellers');
            		 return Datatable::table()
			            ->addColumn(trans('crud.users.id'), trans('crud.users.nickname'), trans('crud.users.name'), trans('crud.users.email'), trans('crud.users.confirmed'),trans('crud.users.roles'),trans('crud.users.certified'),trans('crud.users.created'))
			            ->addColumn(trans('crud.actions'))
			            ->setUrl($route)
			            ->setOptions(['responsive' => true, 'oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
			            // ->setOrder(array(4=>'asc')) // sort by roles
			            // ->setOrder(array(1=>'asc')) // sort by second column
			             ->setOrder(array(1=>'asc', 2=>'asc'))
			            // ->setOptions(array("bStateSave" => true)) 
			            ->render();
            }

            else{
            	$route = route('api.table.users');
            		 return Datatable::table()
			            ->addColumn(trans('crud.users.id'), trans('crud.users.name'), trans('crud.users.email'), trans('crud.users.confirmed'),trans('crud.users.roles'),trans('crud.users.certified'),trans('crud.users.created'))
			            ->addColumn(trans('crud.actions'))
			            ->setUrl($route)
			            ->setOptions(['responsive' => true, 'oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
			            // ->setOrder(array(4=>'asc')) // sort by roles
			            ->setOrder(array(1=>'asc')) // sort by second column
			            ->render();
            }
        }

        else{
            $route = route('api.table.users.deactivated');
            return Datatable::table()
	            ->addColumn(trans('crud.users.id'), trans('crud.users.name'), trans('crud.users.email'), trans('crud.users.confirmed'),trans('crud.users.roles'),trans('crud.users.certified'),trans('crud.users.created'))
	            ->addColumn(trans('crud.actions'))
	            ->setUrl($route)
	            ->setOptions(['responsive' => true, 'oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
	            // ->setOrder(array(4=>'asc')) // sort by roles
	            ->setOrder(array(1=>'asc')) // sort by second column
	            ->render();
	        }

       
    }

    public function getVideo(Request $request){
		$guide = $this->user->findOrThrowException(auth()->id());
		$gallerys = $guide->gallery()->where('type','video')->orderBy('created_at', 'desc')->paginate(12);
		
	
		return view('backend.videos',compact('guide'))->withGallerys($gallerys)->withClass('gallery');
	}

    
    
}