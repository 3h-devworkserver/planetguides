<?php namespace App\Repositories\Frontend\User;

use App\Exceptions\GeneralException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Access\User\User;
use App\Models\Access\User\UserProvider;
use App\Models\Guide;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\Booking;
use App\Models\Availability;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


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
	 * @param RoleRepositoryContract $role
	 */
	public function __construct(RoleRepositoryContract $role) {
		$this->role = $role;
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$user = User::find($id);
		if (!is_null($user)) {
			return $user;
		}

		throw new GeneralException('That user does not exist.');
	}



	/**
	 * @param $data
	 * @param bool $provider
	 * @return static
	 */
	public function create($data, $provider = false) {
		//dd($data);
		$password = uniqid(time());
		$user = User::create([
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'username' =>$this->username($data['fname'],$data['lname']),
			'email' => $data['email'],
			'password' => $provider ? $password : $data['password'],
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed' => $provider ? 1 : (config('access.users.confirm_email') ? 0 : 1),
		]);
		if ($data['form'] == 'Guide') {
			$guide = Guide::create([

				'user_id' => $user->id,
				'gid' => $user->id,

			]);

			$avaibility = Availability::create([

				'guide_id' => $user->id,

			]);
		}

		if ($data['form'] != 'Guide') {
		$profile = Profile::create([

			'user_id' => $user->id,
			'nickname' => $data['nickname'],

		]);
	}else{
		$profile = Profile::create([

			'user_id' => $user->id,
			

		]);
	}

		switch ($data['form']) {
		case 'Guide':
			$user->attachRole($this->role->getGuideUserRole());
			break;

		case 'Traveller':
			$user->attachRole($this->role->getTravellerUserRole());
			break;

		default:
			$user->attachRole($this->role->getDefaultUserRole());
			break;
		}

		// $this->sendRegisteredEmail($user);
		$this->notifyAdmin2($user->toArray());

		if (config('access.users.confirm_email') and $provider === false) {
			$this->sendConfirmationEmail($user);
		} else {
			$user->confirmed = 1;
			$user->save();
		}

		return $user;
	}

	/**
	 * @param $data
	 * @param $provider
	 * @return static
	 */
	public function findByUserNameOrCreate($data, $provider) {
		$user = User::where('email', $data->email)->first();

		$providerData = [
			'avatar' => $data->avatar,
			'provider' => $provider,
			'provider_id' => $data->id,
		];

		if (!$user) {

			$user = $this->create([
				//'name' => $data->name,
				'email' => $data->email,
				'fname' => $data->user['first_name'],
				'lname' => $data->user['last_name'],
				'form' => session('utype'),

			], true);

		}

		if ($this->hasProvider($user, $provider)) {
			$this->checkIfUserNeedsUpdating($provider, $data, $user);
		} else {
			$user->providers()->save(new UserProvider($providerData));
		}

		return $user;

	}

	/**
	 * @param $user
	 * @param $provider
	 * @return bool
	 */
	public function hasProvider($user, $provider) {
		foreach ($user->providers as $p) {
			if ($p->provider == $provider) {
				return true;
			}

		}

		return false;
	}

	/**
	 * @param $provider
	 * @param $providerData
	 * @param $user
	 */
	public function checkIfUserNeedsUpdating($provider, $providerData, $user) {
		//Have to first check to see if name and email have to be updated
		$userData = [
			'email' => $providerData->email,
			'fname' => $providerData->user['first_name'],
			'lname' => $providerData->user['last_name'],
		];
		$dbData = [
			'email' => $user->email,
			'fname' => $user->fname,
			'lname' => $user->lname,
		];
		$differences = array_diff($userData, $dbData);
		if (!empty($differences)) {
			$user->email = $providerData->email;
			$user->fname = $providerData->user['first_name'];
			$user->lname = $providerData->user['last_name'];
			$user->save();

		}

		//Then have to check to see if avatar for specific provider has changed
		$p = $user->providers()->where('provider', $provider)->first();
		if ($p->avatar != $providerData->avatar) {
			$p->avatar = $providerData->avatar;
			$p->save();
		}
	}

	/**
	 * @param $input
	 * @return mixed
	 * @throws GeneralException
	 */
	public function updateProfile($input) {
		$user = $this->findOrThrowException(auth()->id());
		$user->fname = $input['fname'];
		$user->lname = $input['lname'];
		$user->gender = $input['gender'];

		// if($input['gender'] =='male' || $input['gender'] =='Male'){
		// $user->gender ='0';
		// }elseif($input['gender'] =='female' || $input['gender'] =='Female'){
		// $user->gender ='1';
		// }else{
		// $user->gender ='2';
		// }
		


		if (access()->hasRole('Traveller')) {

			$profileData = [
				'phone' => $input['phone'],
				'state' => $input['state'],
				'city' => $input['city'],
				'country' => $input['country'],
				'zip' => $input['zip'],
				'address' => $input['address'],
				'nickname' => $input['nickname'],
			];

		}

		try {
			$user->save();
			Profile::where('user_id', $user->id)->update($profileData);
			return true;
		} catch (\Exception $e) {
			throw new GeneralException($e->getMessage());
		}

	}

	public function updatePrice($input) {
		return Guide::where('user_id',auth()->id())->update(['price'=>$input['price']]);
	
	}

	/**
	 * @param $input
	 * @return mixed
	 * @throws GeneralException
	 */
	public function changePassword($input) {
		$user = $this->findOrThrowException(auth()->id());

		if (Hash::check($input['old_password'], $user->password)) {
			//Passwords are hashed on the model
			$user->password = $input['password'];
			return $user->save();
		}

		throw new GeneralException("That is not your old password.");
	}

	public function changeEmail($input) {
		$user = $this->findOrThrowException(auth()->id());
		$user->email = $input['email'];
		return $user->save();
	}

	/**
	 * @param $token
	 * @throws GeneralException
	 */
	public function confirmAccount($token) {
		$user = User::where('confirmation_code', $token)->first();

// echo "here";
		if ($user) {
			if ($user->confirmed == 1) {
				// echo "error";
				throw new GeneralException("Your account is already confirmed.");
			}

			if ($user->confirmation_code == $token) {
				$user->confirmed = 1;
				$user->save();
				// echo "here2";
				return $this->sendSuccessEmail($user);
			}

			throw new GeneralException("Your confirmation code does not match.");
		}

		throw new GeneralException("That confirmation code does not exist.");
	}

	/**
	 * @param $user
	 * @return mixed
	 */
	public function sendConfirmationEmail($user) {
		//$user can be user instance or id
		if (!$user instanceof User) {
			$user = User::findOrFail($user);
		}

		return Mail::send('emails.confirm', ['token' => $user->confirmation_code], function ($message) use ($user) {
			$message->to($user->email, $user->name)->subject('Confirm your account!');
		});
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	public function sendSuccessEmail($user) {
		
		return Mail::send('emails.success',['fullname' => $user->name], function ($message) use ($user) {
			$message->to($user->email, $user->name)->subject('Your account successfully registered.');
		});
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	public function sendRegisteredEmail($user) {
		
		return Mail::send('emails.userRegistered',['user' => $user], function ($message) use ($user) {
			$message->to($this->getAdminEmail(), 'Admin')->subject('User has been registered.');
		});
	}

	/**
	 * @param null
	 * @return mixed
	 */
	public function notifyAdmin2($user) {
		return Mail::send('emails.notifyadmin',['user' => $user], function ($message) use ($user){
			$message->to($this->getAdminEmail(), 'Admin')->subject('User has been registered.');
		});
	}

	public function notifyAdmin($msg) {
		return Mail::send('emails.notifyadmin',['msg' => $msg['body']], function ($message) use ($msg){
			$message->to($this->getAdminEmail(), 'Admin')->subject($msg['subject']);
		});
	}


	/**
	 * @param $id
	 * @return mixed
	 */
	public function getGuide($username,$isUser=false) {
		$user = User::where('username', $username)->first();
		if(!$user)
			throw new NotFoundHttpException;
		
		if($isUser)
			return $user;
		
		//dd($user->id);
		$guide = Guide::where('gid', $user->id)->first();
		if (!$guide) {
		 	throw new NotFoundHttpException;
		 }
		 return $guide;
	}

	

	/**
	 * @param null
	 * @return mixed
	 */
	public function topGuides($limit=12) {
		
		$guide = Guide::where('certified', 1)->orderBy('rating_cache', 'desc')->take($limit)->get();
	
		return $guide;

		// $guide = Guide::select('users.status','users.confirmed','users.username','users.profilePic','users.profilePic','users.name','guides.gid','guides.certified','guides.price','guides.rating_cache','guides.rating_count')
		// 		->leftjoin('users', 'guides.user_id', '=', 'users.id')
		// 		->where('status', '1')
		// 		->where('confirmed', '1')
		// 		->orderBy('rating_cache', 'desc')
		// 		->take($limit)
		// 		->get();
		// 		return $guide;

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

	public function getAdminEmail(){
		$setting = Setting::find(1);
		return $setting->adminEmail;
	}

	public function checkUserAuth($roles){
		if (is_array($roles)) {
			foreach ($roles as $index => $role) {
				if(1 == $role) {
					return false;
				}
			}
			
		}
		if(1 == $roles) {
			return false;
		}
		return true;
	}

	public function getBookingDates()
	{
		$bookings = Booking::where('verified', '1')->get();
		var_dump($bookings); die();
		foreach ($bookings as $booking) {
			$mulitdatebox[] = $this->dateRange($booking->start_date, $booking->end_date);
		}
		//var_dump($mulitdatebox); die();
		$onedatebox = call_user_func_array('array_merge', $mulitdatebox);
		//var_dump($onedatebox); die();
		return $onedatebox;

		
	}

	public function dateRange( $start, $end )
	{

		$startDate = new \DateTime($start);
		$endDate = new \DateTime($end);
		$daterange = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate);
		//return ($startDate. '/' .$endDate .'/'. $daterange); die();

		foreach ($daterange as $date) {
			$datebox[] = $date->format("Y-m-d");
		}
		//var_dump($datebox); die();

		return $datebox;
	}

	
	/**
	 * @param $id
	 * @return mixed
	 */
	public function getAdmin($limit=5) {	
		$user = DB::table('users')->get();
		if(!$user)
			throw new NotFoundHttpException;

			if($isUser)
			return $user;

		$author = Roles::where('sort', 1);
		
		 return $author;
	}

}


