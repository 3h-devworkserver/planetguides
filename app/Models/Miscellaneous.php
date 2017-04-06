<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'miscellaneouses';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['place'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

}