<?php namespace App\Repositories\Backend\User;

/**
 * Interface UserContract
 * @package App\Repositories\User
 */
interface UserContract {

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 */
	public function findOrThrowException($id, $withRoles = false);

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param $status
	 * @return mixed
	 */
	public function getAllUsers($status = 1);

	/**
	 * @param $status
	 * @param $role
	 * @return mixed
	 */
	public function getUsers($status = 1,$role);

	/**
	 * @param int $status
	 * @return mixed
	 */
	public function getGuideReviews($status = 1);

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUsersPaginated($per_page);

	/**
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function create($input, $roles, $permissions);

	/**
	 * @param $id
	 * @param $roles
	 * @return mixed
	 */
	 public function roleUpdate($id, $roles, $permissions);

	 /**
	 * @param $id
	 * @param $input
	 * @return mixed
	 */
	public function update($id, $input);
	/**
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete($id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function restore($id);

/**
	 * @param $id
	 * @return mixed
	 */
	public function upload($license);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function certification($license);


	/**
	 * @param $id
	 * @param $status
	 * @return mixed
	 */
	public function mark($id, $status);

	/**
	 * @param $id
	 * @param $input
	 * @return mixed
	 */
	public function updatePassword($id, $input);


	/**
	 * @param $status
	 * @return mixed
	 */
	public function getReviews($status = 1);

	/**
	 * @param null
	 * @return mixed
	 */
	public function getAllReviews();

	/**
	 * @param $status
	 * @return mixed
	 */
	public function getLicense($status = 1);

	/**
	 * @param $status
	 * @return mixed
	 */
	public function getBookings($status);

	/**
	 * @param null
	 * @return mixed
	 */
	public function getAllSlides();

	/**
	 * @param null
	 * @return mixed
	 */
	public function getAllGuideArea();


	/**
	 * @param null
	 * @return mixed
	 */
	public function getAllLanguage();
}