<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model 
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallerys';
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\Models\Access\User\User');
    }

        
    

    /**
     * @return string
     */
    public function getLimitImagesAttribute() {
        
    }  

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        if (access()->can('edit-users'))
            return '<a href="'.route('admin.slides.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i> View</a> ';
        return '';
    }

     /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if (access()->can('delete-users'))
            return '<a href="'.route('admin.slides.delete', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        return '';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().
        $this->getDeleteButtonAttribute();

}
}