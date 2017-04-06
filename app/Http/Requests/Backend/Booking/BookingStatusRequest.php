<?php namespace App\Http\Requests\Backend\Booking;

use App\Http\Requests\Request;

/**
 * Class BookingStatusRequest
 * @package App\Http\Requests\Backend\Access\User
 */
class BookingStatusRequest extends Request {

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
                return access()->can('unapprove-booking');
            break;

            case 1:
                return access()->can('approve-booking');
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