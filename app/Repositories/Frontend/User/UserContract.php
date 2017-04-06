<?php namespace App\Repositories\Frontend\User;

/**
 * Interface UserContract
 * @package App\Repositories\User
 */
interface UserContract {

	/**
	 * @param $data
	 * @return mixed
	 */
	public function create($data);

	/**
	 * @param $data
	 * @return mixed
	 */
	public function findByUserNameOrCreate($data, $provider);

	/**
	 * @param $provider
	 * @param $providerData
	 * @param $user
	 * @return mixed
	 */
	public function checkIfUserNeedsUpdating($provider, $providerData, $user);

	/**
	 * @param $input
	 * @return mixed
	 */
	public function updateProfile($input);

	/**
	 * @param $input
	 * @return mixed
	 */
	public function changePassword($input);

	/**
	 * @param $token
	 * @return mixed
	 */
	public function confirmAccount($token);

	/**
	 * @param $user
	 * @return mixed
	 */
	public function sendConfirmationEmail($user);

	/**
	 * @param $username
	 * @return mixed
	 */
	public function getGuide($username);

	/**
	 * @param $username
	 * @return mixed
	 */
	public function getAdmin($limit=5);

	/**
	 * @param $limit
	 * @return mixed
	 */
	public function topGuides($limit=12);

	/**
	 * @param $input
	 * @return mixed
	 */
	public function updatePrice($input);

	/**
	 * @param $msg
	 * @return mixed
	 */
	public function notifyAdmin($msg);	

	/**
	 * @param $roles
	 * @return mixed
	 */
	public function checkUserAuth($roles);	

	/**
	 * @param null
	 * @return mixed
	 */
	public function getBookingDates();	

	
	
	
	



}