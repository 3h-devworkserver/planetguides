<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profile extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User');
    }


    public function picture($resolution){
        $value = explode('.', $this->profileImg);
        $fileName = $value[0].'_'.$resolution.'.'.$value[1];
        return $fileName;
    }

     public static function  gettraveller($id)
    {
        //$profile =Profile::find(1)->where('user_id',$id)->get();
        $profile=DB::table('profiles')
            ->join('users', 'users.id', '=', 'profiles.user_id') 
            ->where('users.id' , '=', $id)
            ->where('profiles.user_id', '=', $id)                 
            ->select('users.id', 'users.fname', 'users.lname', 'users.gender', 'profiles.phone', 'profiles.state', 'profiles.city', 'profiles.country','profiles.zip', 'profiles.address', 'profiles.nickname')
            ->get();
            //var_dump($profile); die();
            return $profile;
    }
}