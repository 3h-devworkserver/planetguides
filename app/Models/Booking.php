<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User', 'gid');
    }

    public function bookedBy() {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }

    public function getApprovedButtonAttribute() {

        if (access()->can('approve-booking') && !$this->verified)
            return '<a href="' . route('admin.booking.status', [$this->id, 1]) . '" class="btn btn-xs btn-success"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve This"></i></a> ';

        return '<a href="' . route('admin.booking.status', [$this->id, 0]) . '" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Unapprove This"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute($model) {
        if (access()->can('delete-booking')){
            if($model->status === 'canceled')
                return '<form  onclick="return confirm(\'Are you sure want to delete?\')" action = "'.route('admin.booking.delete', $this->id).'" method="post"><input type="hidden" name="_method" value="delete"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button</form>';
                // return '<a href="' . route('admin.booking.delete', $this->id) . '" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        }
        return '';
    }
 /**
     * @return string
     */
    public function getCancelButtonAttribute($model) {
        if (access()->can('cancel-booking')){
            if($model->status != 'canceled')
                return '<a href="' . route('admin.booking.cancel', $this->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('Cancel Booking') . '"></i></a>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getNextAttrButtonAttribute($model) {
        if (access()->can('next-attr-booking')){
            if($model->transaction_type ==='partial' && $model->next_status ==='remaining' && $model->status != 'canceled'){
                return '<a href="#" class="btn btn-xs btn-info next" data-id="'.$model->id.'" data-nextid = "'.$model->next_id.'" data-nextstatus="'.$model->next_status.'" data-toggle="modal" data-target=".nextStatus"><i class="fa fa-money" data-toggle="tooltip" data-placement="top" title="' . trans('Change Next Attributes') . '"></i></a>';
            }
            if($model->transaction_type ==='partial' && $model->status != 'canceled'){
                return '<a href="#" class="btn btn-xs btn-info next" data-id="'.$model->id.'" data-hide="true" data-nextid = "'.$model->next_id.'" data-nextstatus="'.$model->next_status.'" data-toggle="modal" data-target=".nextStatus"><i class="fa fa-money" data-toggle="tooltip" data-placement="top" title="' . trans('Change Next Attributes') . '"></i></a>';
            }
       
        }
        return '';
    }

     /**
     * @return string
     */
    public function getGuidePaymentButtonAttribute($model) {
        if (access()->can('guide-payment-booking')){
            if($model->status != 'canceled')
                return '<a href="#" class="btn btn-xs btn-success guide" data-id="'.$model->id.'" data-amount = "'.$model->guide_payment_amount.'" data-status="'.$model->guide_payment_status.'" data-toggle="modal" data-target=".guidepayment"><i class="fa fa-usd" data-toggle="tooltip" data-placement="top" title="' . trans('Change Guide Payment') . '"></i></a>';
        }
        return '';
    }


public function availableActionButtons($model){
        return $this->getCancelButtonAttribute($model) .' '. 
               $this->getNextAttrButtonAttribute($model) .' '.
               $this->getGuidePaymentButtonAttribute($model) .' '.
               $this->getDeleteButtonAttribute($model);

}

// public function getApprovedButtonAttribute() {

//         if (access()->can('approve-booking') && !$this->verified)
//             return '<a href="' . route('admin.booking.status', [$this->id, 1]) . '" class="btn btn-xs btn-success"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Approve This"></i></a> ';

//         return '<a href="' . route('admin.booking.status', [$this->id, 0]) . '" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Unapprove This"></i></a> ';
//     }

//     /**
//      * @return string
//      */
//     public function getDeleteButtonAttribute() {
//         if (access()->can('delete-booking')){
//             return '<a href="' . route('admin.booking.delete', $this->id) . '" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
//         }
//         return '';
//     }
    /**
     * @return string
     */
    // public function getActionButtonsAttribute() {
    //     // $booking =$this->getBookings(1);
    //     // return $booking[0]->status;
    //     return $this->getDeleteButtonAttribute();
    // }
    // // public function getActionButtonsAttribute() {
    // //     return $this->getApprovedButtonAttribute() .
    // //             $this->getDeleteButtonAttribute();
    // // }


    public static function getBookings($status) {

        $booking = self::select('id', 'uid', 'gid', 'first_name', 'last_name','transaction_id','amount', 'days', 'dates', 'created_at','status','transaction_amount', 
                                    'transaction_type', 'next_id', 'next_amount', 'next_status','guide_rate', 'guide_payment_amount', 'guide_payment_status', 'service_charge')
                ->where('verified', $status)
                ->get();

        return $booking;
    }

}
