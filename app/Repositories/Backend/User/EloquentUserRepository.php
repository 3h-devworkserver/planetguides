<?php namespace App\Repositories\Backend\User;
use DB;
use App\Models\Access\User\User;
use App\Models\Profile;
use App\Models\Guide;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Input;
use File;
use Image;
use URL;
use App\Models\users;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Availability;
use App\Models\GuideArea;
use App\Models\Language;
use Illuminate\Http\Response;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\Backend\Access\User\UserNeedsRolesException;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentUserRepository implements UserContract {

	/**
	 * @var RoleRepositoryContract
	 */
	protected $role;

	/**
	 * @var AuthenticationContract
	 */
	protected $auth;

	/**
	 * @param RoleRepositoryContract $role
	 * @param AuthenticationContract $auth
	 */
	public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth) {
		$this->role = $role;
		$this->auth = $auth;
	}

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id, $withRoles = false) {
		if ($withRoles)
			$user = User::with('roles')->withTrashed()->find($id);
		else
			$user = User::withTrashed()->find($id);

		if (! is_null($user)) return $user;

		throw new GeneralException('That user does not exist.');
	}

	/**
	 * @param int $status
	 * @return mixed
	 */

	public function getAllUsers($status = 1) {
		return User::where('status',$status)->get();
	}

	/**
	 * @param int $status
	 * @param $role
	 * @return mixed
	 */
	public function getUsers($status = 1, $role) {
		$users = User::leftJoin('assigned_roles','assigned_roles.user_id','=','users.id')
		->leftJoin('guides', 'guides.user_id','=','users.id')
		->select('users.*','assigned_roles.user_id','assigned_roles.role_id', 'guides.guide_pts')
		->where('status', $status)
		->where('assigned_roles.role_id',$role)
		->get();
		return $users;
		
	}

	/**
	 * @param int $status
	 * @return mixed
	 */
	public function getGuideReviews($status = 1){

		$reviews = Review::where('guide_id',auth()->id())->where('approved',$status)->get();
		return $reviews;
		
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUsersPaginated($per_page) {
		return User::onlyTrashed()->paginate($per_page);
	}

	/**
	
	 */
	public function certification($input) {
		$userid = Input::get('id');
		$userids = Input::get('certified');
			//$file = Input::file('licence');
		if(null == Input::get('certified'))
		{
			$certified= '0';
		
	}
	else
	{
		$certified = Input::get('certified');
	}

	if($certified == 1)
	{
         Guide::where('user_id', $userid)->update(['certified' => $certified]);
         return true;

     }

     return false;


	}
	/**
	
	 */
//edited by -- yojan, commented previous code below
public function upload($input) {
//parse_str($_POST['_data'], $data);
		
		$userid = Input::get('id');
		$licence = Input::file('licensegalleryPic');
		
		

          $dir = 'license';
          $path = config('access.uploadDir').'/'.$userid.'/original'.'/'.$dir;
          $pathResize = config('access.uploadDir').'/'.$userid.'/'.'resize'.'/'.$dir;

          $extension = Input::file('licensegalleryPic')->getClientOriginalExtension();
       
          //$file_size = Input::file('licensePic')->getSize();
          $file = $licence;
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
          $filenameWithPathResize = $pathResize .'/'.$filename;
       
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
             $this->doDirectory($pathResize);

             $move = Input::file('licensegalleryPic')->move($path, $filename);
              $ratio=0.3; 
               if($move){         
              $img = Image::make($filenameWithPath);
                 $height = $img->height();
                 $width = $img->width();

                    $img->resize($width* $ratio,  $height* $ratio);
                    $img->save($filenameWithPathResize);

             // $image = Image::make($filenameWithPath);
             // $image = $image->resize(640, null, function ($constraint) {
             //      $constraint->aspectRatio();
             //  });
             // $image->save($filenameWithPath);
             
             $mainPath = asset($filenameWithPath);
              $mainImagesmall = asset($filenameWithPathResize);

             $gallery = Gallery::create([
                'user_id' => $userid,
                'path' => $mainPath,
                // 'path' => $filenameWithPath,
                'imagesmall' => $mainImagesmall,
                'type' => 'license'
                
              ]);
             
             // $gallery = Gallery::create([
             //    'user_id' => $userid,
             //    'path' => 'http://www.guidenp.com/'.$filenameWithPath,
             //    // 'path' => $filenameWithPath,
             //    'imagesmall' => 'http://www.guidenp.com/'.$filenameWithPathResize,
             //    'type' => 'license'
                
             //  ]);
             return true;
         }
           
             // $licence = $this->savelicense($path, $filename, $filenameWithPath, $userid);
             // if($licence == true)
             // {
             // 	$images = DB::table('gallerys')->select('path')->where('user_id', $userid)->get();

             // }

             
             if($certified == 1){
             Guide::where('user_id', $userid)->update(['certified' => $certified]);

             	}

             	
             $result = $images;

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            $filename = null;
           

        }

          $this->_result = [
            'result' => $result,
            'insertId' => $userid,
            'imgPath' => URL::to($filenameWithPath),
            'saveMode' => 'insert'
        ];

        if(!empty($error_message)) {

            $this->_result['error_message'] = $error_message;

        }

        return $result;
	}

//previous code
// 	public function upload($input) {
// //parse_str($_POST['_data'], $data);
		
// 		$userid = Input::get('id');
// 		$licence = Input::file('licensegalleryPic');
		
		

//           $dir = 'license';
//           $path = config('access.uploadDir').'/'.$userid.'/'.$dir;

//           $extension = Input::file('licensegalleryPic')->getClientOriginalExtension();
       
//           //$file_size = Input::file('licensePic')->getSize();
//           $file = $licence;
//           $result = false;
          
//           /////before upload filename
//           $filename = $this->filename($extension);
//           $filenameWithPath = $path.'/'.$filename;
       
//           $error_message = '';
      

//          try {
              
//              $this->doDirectory($path);
//              Input::file('licensegalleryPic')->move($path, $filename);
//              $image = Image::make($filenameWithPath);
//              $image = $image->resize(640, null, function ($constraint) {
//                   $constraint->aspectRatio();
//               });
//              $image->save($filenameWithPath);
             
//              $gallery = Gallery::create([
//                 'user_id' => $userid,
//                 'path' => $filenameWithPath,
//                 'type' => 'license'
                
//               ]);
//              return true;
           
//              // $licence = $this->savelicense($path, $filename, $filenameWithPath, $userid);
//              // if($licence == true)
//              // {
//              // 	$images = DB::table('gallerys')->select('path')->where('user_id', $userid)->get();

//              // }

             
//              if($certified == 1){
//              Guide::where('user_id', $userid)->update(['certified' => $certified]);

//              	}

             	
//              $result = $images;

//         } catch (Exception $e) {

//             $error_message = $e->getMessage();
//             $filename = null;
           

//         }

//           $this->_result = [
//             'result' => $result,
//             'insertId' => $userid,
//             'imgPath' => URL::to($filenameWithPath),
//             'saveMode' => 'insert'
//         ];

//         if(!empty($error_message)) {

//             $this->_result['error_message'] = $error_message;

//         }

//         return $result;
// 	}

	public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    // public function savelicense($path, $filename, $filenameWithPath, $userid){
    //   Input::file('licence')->move($path, $filename);
    //          $image = Image::make($filenameWithPath);
    //          $image = $image->resize(640, null, function ($constraint) {
    //               $constraint->aspectRatio();
    //           });
    //          $image->save($filenameWithPath);
             
    //          $gallery = Gallery::create([
    //             'user_id' => $userid,
    //             'path' => $filenameWithPath,
    //             'type' => 'license'
                
    //           ]);
    //          return true;
    // }

    public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }

    }



	/**
	 * @param $input
	 * @param $roles
	 * @param $permissions
	 * @return bool
	 * @throws GeneralException
	 * @throws UserNeedsRolesException
	 */
	public function create($input, $roles, $permissions) {
		//var_dump('a'); die();

		$user = $this->createUserStub($input);
		if ($user->save()) {
			//User Created, Validate Roles
			$this->validateRoleAmount($user, $roles['assignees_roles']);

			//Attach new roles
			$user->attachRole($roles['assignees_roles']);
			$price = $input['price'];
			//Attach other permissions
			$user->attachPermissions($permissions['permission_user']);
			if ($roles['assignees_roles'] == 2) {
					$guide = Guide::create([
						'user_id' => $user->id,
						'gid' => $user->id,
						'price' => $price,
					]);

					$avaibility = Availability::create([

				'guide_id' => $user->id,

			]);
			}
			$otherGuide = $input['OtherGuidingArea'];

		    $redytoinsertOtherGuideArea= implode(",",$otherGuide);
		    $language = $input['language'];
		    $redytoinsertOLanguage= implode(",",$language);


			$profile = Profile::create([

				'user_id' => $user->id,
				'phone'=>$input['phone'],
				'address'=>$input['address'],
				'city'=>$input['city'],
				'zip'=>$input['zip'],
				'country'=>$input['country'],
				'state'=>$input['state'],
				'experience' => $input['year'],
				'mGuidingArea' => $input['mainGuidingArea'],
				'oGuidingArea' => $redytoinsertOtherGuideArea,
				'language' => $redytoinsertOLanguage,
				'about' => $input['about'],
				'specilizedarea' => $input['specilizedarea'],

			]);
			$profile['stat'] = 'ok';
			//Send confirmation email if requested
			if (isset($input['confirmation_email']) && $user->confirmed == 0){
				$this->auth->resendConfirmationEmail($user->id);
			}
			return $profile;
			 //$kalo =  response()->json(['name' => 'Abigail', 'last_insert_id' => $user->id]);
			 
			// return $kalo->toArray();
			// return $kalo;
			//return Response::json(['success' => true, 'last_insert_id' => $user->id], 200);
		}

		throw new GeneralException('There was a problem creating this user. Please try again.');
		// $user = $this->createUserStub($input);

		
			//if guide added from backend
			//$user = $this->createUserprofile($input);
			
	}

	/**
	 * @param $id
	 * @param $input
	 * @throws GeneralException
	 */
	public function update($id, $input) {
		 $languagesup = Input::get('language');
		 $langConvertoS = implode(",",$languagesup);
		 $OtherGuidingArea = $input['OtherGuidingArea'];
		 $ogaConvertoS = implode(",",$OtherGuidingArea);
		$user = $this->findOrThrowException($id);
		$this->checkUserByEmail($input, $user);
		$user->fname = $input['fname'];
		$user->lname = $input['lname'];
		$user->email = $input['email'];
		$user->gender = $input['gender'];
		$user->status = isset($input['status']) ? 1 : 0;
		$user->confirmed = isset($input['confirmed']) ? 1 : 0;
		$certified = isset($input['certified']) ? 1 : 0;
		try {
			$user->save();
			Guide::where('user_id', $user->id)->update(['price' => $input['price'], 'certified' => $certified, 'guide_pts'=>$input['guide_pts']]);
			Profile::where('user_id', $user->id)->update(['about' => $input['about'], 'experience' => $input['experience'],
														'address'=>$input['address'],
														'city'=>$input['city'],
														'zip'=>$input['zip'],
														'country'=>$input['country'],
														'phone'=>$input['phone'],
														'state'=>$input['state'],
														 'mGuidingArea' => $input['mGuidingArea'], 'language' => $langConvertoS,
														 'specilizedarea' => $input['specilizedarea'], 'oGuidingArea' => $ogaConvertoS]);

			return true;
		} catch (\Exception $e) {
			throw new GeneralException($e->getMessage());
		}
	}
	/**
	 * @param $id
	 * @param $roles
	 * @return bool
	 * @throws GeneralException
	 */

	public function roleUpdate($id,$roles, $permissions) {
		$user = $this->findOrThrowException($id);
		
		 try {
			$this->checkUserRolesCount($roles);
			$this->flushRoles($roles, $user);
			$this->flushPermissions($permissions, $user);
			$this->flushGuide($roles, $user);
			return true;
		 } catch (\Exception $e) {
		 	throw new GeneralException($e->getMessage());
		 }
		
	}

	/**
	 * @param $id
	 * @param $input
	 * @return bool
	 * @throws GeneralException
	 */
	public function updatePassword($id, $input) {
		$user = $this->findOrThrowException($id);

		//Passwords are hashed on the model
		$user->password = $input['password'];
		if ($user->save())
			return true;

		throw new GeneralException('There was a problem changing this users password. Please try again.');
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function destroy($id) {
		if (auth()->id() == $id)
			throw new GeneralException("You can not delete yourself.");

		if($id==1)
			throw new GeneralException("You can not delete this user.");

		$user = $this->findOrThrowException($id);
		if ($user->delete())
			return true;

		throw new GeneralException("There was a problem deleting this user. Please try again.");
	}

	/**
	 * @param $id
	 * @return boolean|null
	 * @throws GeneralException
	 */
	public function delete($id) {
//var_dump('aa'); die();
		if($id==1)
			throw new GeneralException("You can not delete this user.");
		
		$user = $this->findOrThrowException($id, true);
		//var_dump($user); die();
//var_dump('/ddd'); die();
		//Detach all roles & permissions
		$user->detachRoles($user->roles);
		$user->detachPermissions($user->permissions);

		try {
			$user->guide()->delete();
			$user->profile()->delete();
			$user->providers()->delete();
			$user->forceDelete();
		} catch (\Exception $e) {
			throw new GeneralException($e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function restore($id) {
		$user = $this->findOrThrowException($id);

		if ($user->restore())
			return true;

		throw new GeneralException("There was a problem restoring this user. Please try again.");
	}

	/**
	 * @param $id
	 * @param $status
	 * @return bool
	 * @throws GeneralException
	 */
	public function mark($id, $status) {
		if (auth()->id() == $id && ($status == 0 || $status == 2))
			throw new GeneralException("You can not do that to yourself.");

		$user = $this->findOrThrowException($id);
		$user->status = $status;

		if ($user->save())
			return true;

		throw new GeneralException("There was a problem updating this user. Please try again.");
	}

	/**
	 * Check to make sure at lease one role is being applied or deactivate user
	 * @param $user
	 * @param $roles
	 * @throws UserNeedsRolesException
	 */
	private function validateRoleAmount($user, $roles) {
		//Validate that there's at least one role chosen, placing this here so
		//at lease the user can be updated first, if this fails the roles will be
		//kept the same as before the user was updated
		if (count($roles) == 0) {
			//Deactivate user
			$user->status = 0;
			$user->save();

			$exception = new UserNeedsRolesException();
			$exception->setValidationErrors('You must choose at lease one role. User has been created but deactivated.');

			//Grab the user id in the controller
			$exception->setUserID($user->id);
			throw $exception;
		}
	}

	/**
	 * @param $input
	 * @param $user
	 * @throws GeneralException
	 */
	private function checkUserByEmail($input, $user)
	{
		//Figure out if email is not the same
		if ($user->email != $input['email'])
		{
			//Check to see if email exists
			if (User::where('email', '=', $input['email'])->first())
				throw new GeneralException('That email address belongs to a different user.');
		}
	}

	/**
	 * @param $roles
	 * @param $user
	 */
	private function flushGuide($roles, $user)
	{
		$guide = Guide::where('user_id', $user->id)->first();
		if ($roles['assignees_roles']==2) {
	        if (is_null($guide)) {
	        	$guide = new Guide;
	        	$guide->user_id = $user->id;
	        	$guide->gid = $user->id;
	        	$guide->save();
			}
		}
		elseif ($roles['assignees_roles']==3) {
			if (!is_null($guide)) {
				$guide->delete();
			}
		}
		
	}

	/**
	 * @param $roles
	 * @param $user
	 */
	private function flushRoles($roles, $user)
	{
		//Flush roles out, then add array of new ones
		$user->detachRoles($user->roles);
		$user->attachRole($roles['assignees_roles']);
		
	}

	/**
	 * @param $permissions
	 * @param $user
	 */
	private function flushPermissions($permissions, $user)
	{
		//Flush permissions out, then add array of new ones if any
		$user->detachPermissions($user->permissions);
		if (count($permissions['permission_user']) > 0)
			$user->attachPermissions($permissions['permission_user']);
	}

	/**
	 * @param $roles
	 * @throws GeneralException
	 */
	private function checkUserRolesCount($roles)
	{
		//User Updated, Update Roles
		//Validate that there's at least one role chosen
		if (count($roles['assignees_roles']) == 0)
			throw new GeneralException('You must choose at least one role.');
	}

	public function username($fname,$lname,$rand=null){
    	$number = mt_rand(100, 999); // better than rand()
    	$username = strtolower($fname).'-'.strtolower($lname).$rand;
	    if ($this->usernameExists($username)) {
	        return $this->username($fname,$lname,$number);
	    }

	    return $username;
	}

	public function usernameExists($username){
		return User::where('username', $username)->exists();		
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	private function createUserStub($input)
	{
		$user = new User;
		$user->fname = $input['fname'];
		$user->lname = $input['lname'];
		$user->username = $this->username($input['fname'], $input['lname']);
		$user->email = $input['email'];
		$user->password = $input['password'];
		$user->gender = $input['gender'];
		$user->status = isset($input['status']) ? 1 : 0;
		$user->confirmation_code = md5(uniqid(mt_rand(), true));
		$user->confirmed = isset($input['confirmed']) ? 1 : 0;
		return $user;
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	private function createUserprofile($input)
	{
		// $useremail = $input['email'];
		// 	$userId = DB::table('users')->select ('id')->where('email', $useremail)->first();
		// 	$userid = $userId->id;
		// $profile = new Profile;
		// $user_id = $userid;
		// $userid = serialize($user_id);
		// $profile->user_id = $userid;
		// $profile->experience = $input['year'];
		// $profile->mGuidingArea = $input['mGuidingArea'];
		// $otherGuide = $input['oGuidingArea'];
		// $redytoinsertOtherGuideArea= implode(",",$otherGuide);
		// $profile->oGuidingArea = $redytoinsertOtherGuideArea;

		// $otherlanguage = $input['language'];
		// $redytoinsertOLanguage= implode(",",$otherlanguage);
		// $profile->language = $redytoinsertOLanguage;
		// $profile->about = $input['about'];
		// return $profile;
	}

	public function getallReviews()
	{
		$reviews = Review::select('users.email','reviews.id','reviews.comment','reviews.approved','reviews.created_at')
				->leftjoin('users', 'reviews.user_id', '=', 'users.id')
				->get();
  		return $reviews;
	}

	public function getReviews($status= 1)
	{
		$reviews = Review::select('users.email','reviews.id','reviews.comment','reviews.approved','reviews.created_at')
				->leftjoin('users', 'reviews.user_id', '=', 'users.id')
				->where('reviews.approved', $status)
				->get();
  		return $reviews;
	}

	public function getAllSlides()
	{
		// 'gallery.path', for showing images within datatable work later
		$slides = Gallery::select('users.username', 'gallerys.id','gallerys.path', 'gallerys.caption', 'gallerys.type', 'gallerys.created_at')
			->leftjoin('users', 'gallerys.user_id', '=', 'users.id')
			->where('gallerys.type', 'slider')
			->get();
			return $slides;
	}


	public function getAllGuideArea()
	{
		// 'gallery.path', for showing images within datatable work later
		$place = GuideArea::select('id','user_name','ordering', 'guide_area', 'created_at')
			->get();


			return $place;
	}


	public function getAllLanguage()
	{
		// 'gallery.path', for showing images within datatable work later
		$language = Language::select('id','user_name', 'language', 'ordering', 'created_at')
			->get();


			return $language;
	}
	/**
	 * @param $status
	 * @return mixed
	 */
	public function getLicense($status = 1){
		$unapprovedLicense = User::select('users.id', 'users.fname', 'users.lname', 'users.email', 'users.created_at')
			->distinct()
			->leftjoin('guides','users.id', '=', 'guides.user_id')
			->leftjoin('gallerys','users.id', '=', 'gallerys.user_id')
			->where('gallerys.type','license')
			->where('guides.certified','0')->get(); 
		return $unapprovedLicense;
	}

	/**
	 * @param $status
	 * @return mixed
	 */
	public function getBookings($status)
	{
		$booking = Booking::where('verified', $status)->orderBy('created_at','desc')->get();
		return $booking;
	}
}