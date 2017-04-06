<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paypalpayment extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paypalpayments';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


   


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getApprovedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }

}