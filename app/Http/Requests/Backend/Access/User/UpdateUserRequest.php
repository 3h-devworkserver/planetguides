<?php namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class UpdateUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->can('edit-users');
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
            'email'                 =>  'required',
            'gender'          =>  'required',
            'address'          =>  'required',
            'city'          =>  'required',
            'zip'          =>  'required',
            'state'          =>  'required',
            'country'          =>  'required',
            'experience'          =>  'required',
            'mGuidingArea'          =>  'required',
            'OtherGuidingArea'          =>  'required',
            'about'          =>  'required',
            'language'              =>  'required',
            'price'                 => 'required',
            'specilizedarea'                 => 'required',
		];
	}
}