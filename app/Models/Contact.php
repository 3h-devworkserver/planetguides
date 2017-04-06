<?php namespace App\Models;

//use App\Models\Guide;
use Illuminate\Database\Eloquent\Model;
//use Carbon\Carbon;

class Contact extends Model {

/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'contact';
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function convertDate($date){
		return \Carbon\Carbon::parse($date)->format('Y/m/d');
	}

}