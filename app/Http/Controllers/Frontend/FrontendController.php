<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DB;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller {

	/**
	 * @return \Illuminate\View\View
	 */

	 /**
     * @var UserContract
     */
    protected $users;

    public function __construct(UserContract $users) {
        $this->users = $users;
        
    }


	public function index()
	{ 
              javascript()->put([
			'test' => 'it works!'
		]);
		$guide = $this->users->topGuides(12);
		$sliders = DB::table('gallerys')
                    ->Where('type', 'slider')
                    ->get();
        $availibility = DB::table('availabilitys')
        ->distinct('availibility')
		->select('availibility')
		->get();
		$array = array();
		foreach ($availibility as $key => $availible) {
			//echo "<pre>";print_r($availible);
			array_push($array, $availible->availibility);
			// $availible = explode(',', $availible);
		}
		$newdate = implode(',', $array);
		// echo "<pre>";print_r($newdate);
                
                
		 // dd('here');
		 return view('frontend.index', ['sliders'=>$sliders])->withGuides($guide)->with('availibility', $newdate)->withClass('home');
	}

	public function page($slug)
    {
          
        $page = Page::where('slug',$slug)->first();
        if(!$page)
        	throw new NotFoundHttpException;
        return view('frontend.page',compact('page'))->withClass('page-area');
    }

	/**
	 * @return \Illuminate\View\View
	 */
	public function macros()
	{
		return view('frontend.macros');
	}
}