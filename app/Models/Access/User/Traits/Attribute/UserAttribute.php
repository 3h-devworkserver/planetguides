<?php namespace App\Models\Access\User\Traits\Attribute;

use Illuminate\Support\Facades\Hash;
use Gravatar;
use URL;
use DB;
use App\Models\Gallery;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait UserAttribute {

    /**
     * Hash the users password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value))
            $this->attributes['password'] = bcrypt($value);
        else
            $this->attributes['password'] = $value;
    }

    

    /**
     * @return string
     */
    public function getConfirmedLabelAttribute() {
        if ($this->confirmed == 1)
            return "<label class='label label-success'>Yes</label>";
        return "<label class='label label-danger'>No</label>";
    }

    /**
     * @return string
     */
    public function getCertifiedLabelAttribute() {
        if ($this->guide->certified == 1)
            return "<label class='label label-success'>Yes</label>";
        return "<label class='label label-danger'>No</label>";
    }



    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if (access()->can('edit-users'))
            return '<a href="'.route('admin.access.users.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i> View</a> ';
        return '';
    }

   
    /**
     * @return string
     */
    public function getChangePasswordButtonAttribute() {
        if (access()->can('change-user-password'))
            return '<a href="'.route('admin.access.user.change-password', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('crud.change_password_button') . '"></i></a>';
        return '';
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute() {
        switch($this->status) {
            case 0:
                if (access()->can('reactivate-users'))
                    return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                break;

            case 1:
                $buttons = '';

                if (access()->can('deactivate-users'))
                    $buttons .= '<a href="'.route('admin.access.user.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_user_button') . '"></i></a> ';

                // if (access()->can('ban-users'))
                //     $buttons .= '<a href="'.route('admin.access.user.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('crud.ban_user_button') . '"></i></a> ';

                // return $buttons;
                // break;

            case 2:
                if (access()->can('reactivate-users'))
                    return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                break;

            default:
                return '';
                break;
        }

        return '';
    }

    public function getConfirmedButtonAttribute() {
        if (! $this->confirmed)
            if (access()->can('resend-user-confirmation-email'))
                return '<a href="'.route('admin.account.confirm.resend', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
        return '';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if (access()->can('delete-users'))
            return '<form onsubmit="return confirm(\'Are you sure want to delete?\')" action = "'.route('admin.access.users.destroy', $this->id).'" method="post" class="inline"><input type="hidden" name="_method" value="delete"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button</form>';
            // return '<a href="'.route('admin.access.users.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().
        $this->getChangePasswordButtonAttribute().' '.
        $this->getStatusButtonAttribute().
        $this->getConfirmedButtonAttribute().
        $this->getDeleteButtonAttribute();
    }

    //   /**
    //  * @return string
    //  */
    // public function getEditeSliderAttribute() {
    //     if (access()->can('edit-users'))
    //         return '<a href="'.route('admin.slides.delete', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i> View</a> ';
    //     return '';
    // }

    // /**
    //  * @return string
    //  */
    // public function getDeleteSliderAttribute() {
    //     if (access()->can('delete-users'))
    //         return '<a href="#" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    //     return '';
    // }

    // /**
    //  * @return string
    //  */
    // public function getEditDeleteAttribute() {
    //     return $this->getEditeSliderAttribute().
    //     $this->getDeleteSliderAttribute();
    // }



    /**
     * @return mixed
     */
    public function getPictureAttribute() {
        if (facebookExist($this->providers))
            return facebookProfilePic($this->providers);
        
        else if($this->profile->profileImg)
            // return URL::to($this->profile->picture(100));
            return URL::to($this->profile->profileImg);

        else
         return gravatar()->get($this->email, ['size' => 50]);
    }

     /**
     * @return mixed
     */
    public function getProfilepicAttribute() {
        if (facebookExist($this->providers))
            return facebookProfilePic($this->providers);
        
        else if($this->profile->profileImg)
            // return ($this->profile->profileImg);
            return URL::to($this->profile->profileImg);

        else
         return gravatar()->get($this->email, ['size' => 100]);
          
    
     
    }

      /**
     * @return mixed
     */
    public function getBannerpicAttribute() {
        if($this->profile->bannerImg)
            return URL::to($this->profile->bannerImg);

        else
         return URL::to('uploads/default/banner.jpg');
          
    
     
    }

    public function getNameAttribute()
    {
        return $this->fname.' '.$this->lname;
    }
    public function getAboutAttribute()
    {
        return $this->profile->about;
    }
    
    public function getPhoneAttribute()
    {
        return $this->profile->phone;
    }

    public function getStateAttribute()
    {
        return $this->profile->state;
    }

    public function getCityAttribute()
    {
        return $this->profile->city;
    }
    public function getCountryAttribute()
    {
        return $this->profile->country;
    }
    public function getZipAttribute()
    {
        return $this->profile->zip;
    }
     public function getNicknameAttribute()
    {
        return $this->profile->nickname;
    }
    public function getAddressAttribute()
    {
        return $this->profile->address;
    }
    public function getExperienceAttribute()
    {
        return $this->profile->experience;
    }
    public function getmGuidingAreaAttribute()
    {
        return $this->profile->mGuidingArea;
    }

    //edited --yojan
    // public function getMGuidArea($id){
    //     return DB::table('profiles')
    //         ->join('guideareas', 'guideareas.id', '=', 'profiles.mGuidingArea')
    //         ->select( 'guideareas.guide_area')
    //         ->where('guideareas.id', '=', $id)
    //         // ->limit(1)
    //         ->first();
    // }
    //end of editing

    public function getoGuidingAreaAttribute()
    {
        return $this->profile->oGuidingArea;
    }
    public function getLanguageAttribute()
    {
        return $this->profile->language;
    }

    public function getCountLicenseAttribute()
    {
        return $this->gallery->where('type','license')->count();
    }

    public function getLicenseAttribute()
    {
        return $this->gallery->where('type','license');
    }
    public function getVideoAttribute()
    {
        return $this->gallery->where('type','video');
    }

     /**
     * @return string
     */
    public function getLimitVideosAttribute() {

        return $this->gallery()->where('type','video')->orderBy('created_at','desc')->take(6)->get();
        
    } 

    /**
     * @return string
     */
    public function getLimitImagesAttribute() {

        return $this->gallery()->where('type','image')->orderBy('created_at','desc')->take(6)->get();
        
    }

    public function hasLicense() {
        if ($this->gallery->where('type', 'license')->first() === null) 
            return false;
        else
            return true;
    }

    public function getAllLicense($id){
        $licenses = Gallery::where('user_id', $id)->where('type', 'license')->get();
        if ( !empty(count($licenses))) {
            $images = '';
            foreach($licenses as $license){
                $images .= ' '. '<a class="fancybox bg-image" style="background-image:url('.asset($license->imagesmall).')" data-fancybox-group="gallery"  href ="'.asset($license->path).'"></a> ';
            }
            $rand = uniqid(time());
            return '<div id ="'.$rand.'">'.$images. '</div><script>$(document).ready(function(){ $("#'.$rand.' .fancybox").fancybox(); });</script>';
        }else{
            return '';
        }
    }
   

    


}