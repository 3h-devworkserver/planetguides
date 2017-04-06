<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller {

	/**
	 * @return mixed
     */
	public function index()
	{
		
         return view('backend.dashboard')->withClass('backend-dash');

        
	}
}