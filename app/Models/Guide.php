<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guide extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'guides';
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'gid', 'price', 'rating_cache', 'rating_count'];
	public $timestamps = false;

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function reviews() {
		return $this->hasMany('App\Models\Review','guide_id','gid');
	}

	// The way average rating is calculated (and stored) is by getting an average of all ratings,
	// storing the calculated value in the rating_cache column (so that we don't have to do calculations later)
	// and incrementing the rating_count column by 1

	public function recalculateRating() {
		$reviews = $this->reviews()->notSpam()->approved();
		$avgRating = $reviews->avg('rating');
		$this->rating_cache = round($avgRating, 1);
		$this->rating_count = $reviews->count();
		$this->save();
	}

	// public function getExperienceAttribute()
 //    {
	// 	 $dt = Carbon::createFromDate($this->user->experience);
	// 	 $years = str_replace('ago', '',$dt->diffForHumans());
 //         return $years;

 //    }

    public function getRatingAttribute()
    {
		 $rating = round($this->rating_cache * 2) / 2;
		
    }
}
