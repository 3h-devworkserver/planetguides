<?php namespace App\Http\Requests\Backend\Booking;

use App\Http\Requests\Request;

/**
 * Class BookingDeleteRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class BookingNextAttributesRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->can('next-attr-booking');
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