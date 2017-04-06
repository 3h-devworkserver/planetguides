<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use DB;
use Carbon\Carbon;
use App\Models\Language;
use App\Models\GuideArea;
use App\Models\Profile;
/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller {

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


	// public function index(Request $request)
	// {
	// 	dd($request->all());
	// 	$name = ''; $destination = ''; $skills = '';

	// 	if (Input::get('dest-name')) {
 //            $inputs = explode(',', Input::get('dest-name'));
 //            //dd($inputs);
 //            $name = $inputs[0];
 //            if(!empty($inputs[1])){
 //                $destination = $inputs[1];
 //            } 
 //            if(!empty($inputs[2])){
 //                $skills = $inputs[2];
 //            }           
 //        }
	// 	$language = Input::get('glang');
	// 	$gAreas = Input::get('gAreas');
	// 	$order = Input::get('exp-rate');
	// 	$sliders = DB::table('gallerys')
 //                    ->Where('type', 'slider')
 //                    ->get();
 //        $searchDatas = User::select('users.username', 'users.fname', 'users.lname', 'users.gender', 'profiles.*', 'user_providers.avatar')
 //        ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
 //        ->leftJoin('user_providers', 'users.id', '=', 'user_providers.user_id')
 //        ->leftJoin('guides', 'users.id', '=', 'guides.user_id')
        
 //        ->where('users.confirmed', '=', 1)
 //        ->where('guides.certified', '=', 1);
        
 //        $profiles = DB::table('profiles')->get();
		
	// 	// $from = Input::get('from');
	// 	// $to = Input::get('to');
	// 	// if(!empty($from) && !empty($to)){

	// 	// 	$dates = SearchController::getDatesFromRange($from, $to);
 //  //       if($dates){
 //  //       	foreach ($dates as $key => $date) {
 //  //       		//echo "<pre>"; print_r($date);
 //  //       		$searchDatas->where('availibility', 'LIKE', '%'. $date .'%');
 //  //       	}
 //  //       	//dd('here');
	// 	// }else if($from){
	// 	// 	$searchDatas->where('availibility', 'LIKE', '%'. $from .'%');
	// 	// }
	// 	// }


	// 	if($language){
	// 		foreach ($language as $lan) {
	// 			$searchDatas->where('language', 'LIKE', '%'. $lan .'%');
	// 		}
	// 	}
	// 	if($gAreas){
	// 		foreach ($gAreas as $gArea) {
	// 			$searchDatas->where(function ($searchData) use ($gArea) {
 //                	$searchData->where('mGuidingArea', 'LIKE', '%' . $gArea . '%')
 //                    	->orWhere('oGuidingArea', 'LIKE', '%' . $gArea . '%');
 //            	});
	// 			// $searchDatas->where('oGuidingArea', 'LIKE', '%'. $gArea .'%');
	// 		}
	// 	}
		
	// 	if(!empty($inputs)){
	// 		foreach ($inputs as $key => $input) {
	// 			//echo '<pre>'; print_r($input); 
	// 			$searchDatas->where(function ($searchData) use ($input) {
 //                	$searchData->where('fname', 'LIKE', '%' . $input . '%')
 //                    	->orWhere('specilizedarea', 'LIKE', '%' . $input . '%')
 //                    	->orWhere('about', 'LIKE', '%' . $input . '%');
 //            	});
	// 		//$searchDatas->where('fname', 'LIKE', '%'. $inputs .'%');
	// 		}
	// 		//die();
	// 	}

	// 	if($order == "Experience"){
	// 		$searchDatas->orderby('experience', 'Desc');
	// 	}else if($order == "Rating"){
	// 		$searchDatas->orderBy('rating_cache', 'desc');
	// 	}

	// 	$count = count($searchDatas->get());
	// 	$results = $searchDatas->paginate(8);
	// 	return view('frontend.searchResults',['sliders'=>$sliders])
	// 	->with('count', $count)
	// 	->with('guides', $results)
	// 	->with('profiles', $profiles)
	// 	->with('selectedname', $name)
	// 	->withClass('search-result');
	// }

	public function index(Request $request) {
		$areas = $this->getAreas($request->gAreas);
		$languages = $this->getLanguageId($request->glang);
		$country = $request->country;
		$country = $this->getCountry($country);
		$count = 0;
		$state = $request->state;
		$state = $this->getState($state);
		$order = Input::get('exp-rate');
		$text = Input::get('dest-name');
		$guides = "";
		$sql = "SELECT * FROM `profiles` WHERE";
		$areaCount = 0;
		foreach ($areas as $area) {
			if ($areaCount == 0) {
				$sql .= "( ";
				$areaCount++;
			}
			$sql .= "`mGuidingArea` LIKE '%$area%' OR ";
			$sql .= "`oGuidingArea` LIKE '%$area%' OR ";
		}
		if ($areaCount > 0) {
			$sql = (string) substr($sql, 0, strlen($sql) - 3);
			$sql .= ") ";
		}
		$languageCount = 0;
		foreach ($languages as $language) {
			if ($languageCount == 0) {
				if ($areaCount == 0) {
					$sql .= " (";
				} else {
					$sql .= "AND (";
				}
				$languageCount++;
			}
			$sql .= "`language` LIKE '%$language%' OR ";
		}

		if ($languageCount > 0) {
			$sql = (string) substr($sql, 0, strlen($sql) - 3);
			$sql .= ") ";
		}
		$countryCount = 0;
		if ($country != "" && $country != []) {
			if ($languageCount > 0 || $areaCount > 0) {
				$sql .= " AND ( `country` = '$country' ) ";
			} else {
				$sql .= " ( `country` = '$country' ) ";
			}
			$countryCount++;
		}
		$stateCount = 0;
		if ($state != "" && $state != []) {
			if ($languageCount > 0 || $areaCount > 0 || $countryCount > 0 || $stateCount > 0) {
				$sql .= " AND ( `state` = \"$state\" ) ";
			} else {
				$sql .= " ( `state` = \"$state\" ) ";
			}
			$stateCount++;
		}
		if ($languageCount+$areaCount+$countryCount+$stateCount == 0) {
			if ($text != "") {
				$sql .= " WHERE `specilizedarea` != ''";
			}
		} else {
			if ($text != "") {
				$sql .= "OR (`specilizedarea` != '')";
			}
		}
		if ($languageCount == 0 && $stateCount ==0 && $countryCount == 0 && $areaCount == 0) {
			$sql = "SELECT * FROM `profiles`";
		}
		$results = DB::select($sql);
		$datas = [];
		foreach ($results as $result) {
			array_push($datas, $result->user_id);
		}
		if ($datas == []) {
			$name = "";
			$profiles = DB::table('profiles')->get();
			$language = Input::get('glang');
			$gAreas = Input::get('gAreas');
			$order = Input::get('exp-rate');
			$sliders = DB::table('gallerys')
		                   ->Where('type', 'slider')
		                   ->get();
			return view('frontend.searchResults',['sliders'=>$sliders])
				->with('count', $count)
				->with('guides', [])
				->with('profiles', $profiles)
				->with('selectedname', $name)
				->withClass('search-result');
		}
		$in = implode(",", $datas);
		$sql = "SELECT * FROM `guides` WHERE `user_id` IN($in) AND `certified` = '1'";
		$results = DB::select($sql);
		$datas = [];
		$count = 0;
		foreach ($results as $result) {
			array_push($datas, $result->user_id);
			$count++;
		}
		if ($datas == []) {
			$name = "";
			$profiles = DB::table('profiles')->get();
			$language = Input::get('glang');
			$gAreas = Input::get('gAreas');
			$order = Input::get('exp-rate');
			$sliders = DB::table('gallerys')
		                   ->Where('type', 'slider')
		                   ->get();
			return view('frontend.searchResults',['sliders'=>$sliders])
				->with('count', $count)
				->with('guides', [])
				->with('profiles', $profiles)
				->with('selectedname', $name)
				->withClass('search-result');
		}
		$in = implode(",", $datas);
		$sql = "SELECT * FROM `users` WHERE `id` IN($in) AND (`lname` LIKE \"%$text%\" OR `fname` LIKE \"%$text%\")";
		$results = DB::select($sql);
		$datas = [];
		$count = 0;
		foreach ($results as $result) {
			array_push($datas, $result->id);
			$count++;
		}
		if ($datas == []) {
			$name = "";
			$profiles = DB::table('profiles')->get();
			$language = Input::get('glang');
			$gAreas = Input::get('gAreas');
			$order = Input::get('exp-rate');
			$sliders = DB::table('gallerys')
		                   ->Where('type', 'slider')
		                   ->get();
			return view('frontend.searchResults',['sliders'=>$sliders])
				->with('count', $count)
				->with('guides', [])
				->with('profiles', $profiles)
				->with('selectedname', $name)
				->withClass('search-result');
		}
		$guides = $results;
		$name = "";
		$profiles = DB::table('profiles')->get();
		$language = Input::get('glang');
		$gAreas = Input::get('gAreas');
		$order = Input::get('exp-rate');
		$sliders = DB::table('gallerys')
	                   ->Where('type', 'slider')
	                   ->get();
		return view('frontend.searchResults',['sliders'=>$sliders])
			->with('count', $count)
			->with('guides', $results)
			->with('profiles', $profiles)
			->with('selectedname', $name)
			->withClass('search-result');
	}

	protected function getCountry($country) {
		if ($country == [] || $country == "") {
			return [];
		}
		$c = "Nepal";
		foreach ($country as $c) {}
		return $c;
	}

	protected function getState($state) {
		if ($state == [] || $state == "") {
			return [];
		}
		$s = "Bagmati";
		foreach ($state as $s) {}
		return $s;
	}

	protected function getLanguageId($languages) {
		if ($languages == [] || $languages == "") {
			return [];
		}
		$langIds = [];
		foreach ($languages as $language) {
			$gLanguage = Language::where('language', $language)->first();
			if ($gLanguage) {
				array_push($langIds, $gLanguage->id);
			}
		}
		return $langIds;
	}

	protected function getAreas($areas) {
		if ($areas == [] || $areas == "") {
			return [];
		}
		$areaIds = [];
		foreach ($areas as $area) {
			$gArea = GuideArea::where('guide_area', $area)->first();
			if ($gArea) {
				array_push($areaIds, $gArea->id);
			}
		}
		return $areaIds;
	}

	public function autocompletesearch($value = '')
    {
        $keywords = Input::get('query');
        $type = Input::get('type');
        if ($type == 'name') {
            $suggestions['suggestions'] = User::where('fname', 'LIKE', '%' . $keywords . '%')->lists('fname');
        }
        return response()->json($suggestions);
    }

    public static function getDatesFromRange($first, $last, $step = '+1 day', $format = 'm/d/Y' ) { 
    	$dates = array();
    	$current = strtotime($first);
    	$last = strtotime($last);
    	while( $current <= $last ) { 

        	$dates[] = date($format, $current);
        	$current = strtotime($step, $current);
    	}

    	return $dates;
	}
}