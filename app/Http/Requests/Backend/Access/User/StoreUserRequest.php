<?php namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class StoreUserRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class StoreUserRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fname'					=>  'required',
            'lname'                 => 'required',
            'email'                 =>  'required|email|unique:users',
            'password'              =>  'required|alpha_num|min:6|confirmed',
            'password_confirmation' =>  'required|alpha_num|min:6',
            'gender'          =>  'required',
            'address'          =>  'required',
            'city'          =>  'required',
            'zip'          =>  'required',
            'state'          =>  'required',
            'country'          =>  'required',
            'year'          =>  'required',
            'mainGuidingArea'          =>  'required',
            'OtherGuidingArea'          =>  'required',
            'about'          =>  'required',
            'language'              =>  'required',
            'price'                 => 'required',
            'specilizedarea'                 => 'required',
        ];
    }
}