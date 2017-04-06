<?php namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\UserProvider;
use App\Models\Profile;
use App\Models\Guide;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Availability;
/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship {

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
    }

    /**
     * @return mixed
     */
    public function providers() {
        return $this->hasMany(UserProvider::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class,'user_id','id');
    }

    public function guide(){
        return $this->hasOne(Guide::class);
    }

    public function gallery() {
        return $this->hasMany(Gallery::class,'user_id','id');
    }

    public function reviews() {
        return $this->hasMany(Review::class,'user_id','id');
    }

    public function reviewsLatest() {
        return $this->hasMany(Review::class,'user_id','id')->orderBy('created_at', 'desc');
    }

    public function availibility() {
        return $this->hasMany(Availability::class,'user_id','id');
    }


   
    
}