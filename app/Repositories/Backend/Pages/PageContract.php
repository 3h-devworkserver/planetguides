<?php namespace App\Repositories\Backend\Pages;

/**
 * Interface PageContract
 * @package App\Repositories\Page
 */
interface PageContract {

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 */
	public function findOrThrowException($id);

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param $status
	 * @return mixed
	 */
	public function getLimitPages($status = 1);


	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPages($order_by = 'id', $sort = 'asc');

	/**
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function status($id,$status);

	/**
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function create($input);

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
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


}