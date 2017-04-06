<?php namespace App\Models;

use App\Models\Guide;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Review extends Model {

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'reviews';
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User','user_id');
	}

	public function guide() {
		return $this->belongsTo('App\Models\Guide','guide_id');
	}

	public function scopeApproved($query) {
		return $query->where('approved', true);
	}

	public function scopeSpam($query) {
		return $query->where('spam', true);
	}

	public function scopeNotSpam($query) {
		return $query->where('spam', false);
	}
	public function getTimeagoAttribute() {
		$date = Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
		return $date;
	}
	public function storeReviewForGuide($guide, $comment, $rating) {

		$this->user_id = access()->user()->id;
		$this->comment = $comment;
		$this->rating = $rating;
		$this->approved = config('access.approved');
		$guide->reviews()->save($this);

		// recalculate ratings for the specified guide
		$guide->recalculateRating();
	}

	public function review_count($uid,$gid)
    {
        return $this->where('guide_id',$gid)->where('user_id',$uid)->count();
    }

     /**
     * @return string
     */
    public function getApprovedLabelAttribute() {
        if ($this->approved == 1)
            return "<label class='label label-success'>Approved</label>";
        return "<label class='label label-danger'>Unapproved</label>";
    }

    public function getApprovedButtonAttribute() {
        if (access()->can('approve-reviews') && !$this->approved)
        	return '<a href="'.route('frontend.guide.review.approve', [$this->id,1]).'" class="btn btn-xs btn-success"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve This"></i></a> ';
        return '';
    }

      public function getEmailAttribute() {
         return $this->belongsTo('App\Models\Access\User\User','user_id')->value('email');
         // return $this->belongsTo('App\Models\Access\User\User')->value('email');
        // return 'test';
    }
    
/**
 * uses userid and returns nickname
 */
    public function nickname($id) {
    	return Profile::where('user_id', $id)->value('nickname');
    }



    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if (access()->can('delete-reviews'))
            return '<a href="'.route('frontend.guide.review.delete', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getApprovedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }
}
