<?php namespace App\Repositories\Backend\Pages;

use App\Models\Page;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentPageRepository
 * @package App\Repositories\Page
 */
class EloquentPageRepository implements PageContract {


	private $user;

	public function __construct() {
		$this->user = Auth::user();
	}

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		
			$Page = Page::find($id);

		if (! is_null($Page)) return $Page;

		throw new GeneralException('That Page does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param int $status
	 * @return mixed
	 */
	public function getLimitPages($status = 1) {
		return Page::where('status', $status)->get();
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedPagesPaginated($per_page) {
		return Page::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPages($order_by = 'id', $sort = 'asc') {
		return Page::orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $input
	 * @param $roles
	 * @param $permissions
	 * @return bool
	 * @throws GeneralException
	 * @throws PageNeedsRolesException
	 */
	public function create($input) {
		$Page = $this->createPageStub($input);

		if ($Page->save()) {
			return true;
		}

		throw new GeneralException('There was a problem creating this Page. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return bool
	 * @throws GeneralException
	 */
	public function update($id, $input) {
		$Page = $this->findOrThrowException($id);
		
		if ($Page->update($input)) {
		
			$Page->save();


			return true;
		}

		throw new GeneralException('There was a problem updating this Page. Please try again.');
	}


	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function destroy($id) {
		
		$Page = $this->findOrThrowException($id);
		if ($Page->delete())
			return true;

		throw new GeneralException("There was a problem deleting this Page. Please try again.");
	}

		/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function delete($id) {
		
		$Page = $this->findOrThrowException($id);
		if ($Page->delete())
			return true;

		throw new GeneralException("There was a problem deleting this Page. Please try again.");
	}

	

	/**
	 * @param $id
	 * @param $status
	 * @return bool
	 * @throws GeneralException
	 */
	public function status($id, $status) {
		
		$Page = $this->findOrThrowException($id);
		$Page->status = $status;

		if ($Page->save())
			return true;

		throw new GeneralException("There was a problem updating this Page. Please try again.");
	}


	


	/**
	 * @param $input
	 * @return mixed
	 */
	private function createPageStub($input)
	{
		$Page = new Page;
		$Page->title = $input['title'];
		$Page->content = $input['content'];
		$Page->depth = 0;
		$Page->status = 1;
		
		return $Page;
	}

	
}