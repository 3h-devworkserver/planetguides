<?php namespace App\Http\Requests\Backend\Page;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class StatusPageRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//Get the 'status' id
        switch((int) request()->segment(5)) {
            case 0:
                return access()->can('disable-pages');
            break;

            case 1:
                return access()->can('enable-pages');
            break;

        }

        return false;
	}

		/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}

	
}