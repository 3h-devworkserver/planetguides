<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
 

}
