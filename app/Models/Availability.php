<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'availabilitys';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
   public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

        
    

    /**
     * @return string
     */
    public function getLimitImagesAttribute() {
        
    }  

}