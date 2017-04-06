<?php namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Models\Access\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Repositories\Frontend\User\UserContract;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Frontend\Access\ChangePasswordRequest;
use App\Http\Requests\Frontend\Access\ResetPasswordRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Auth
 */
class PasswordController extends Controller {

	use ResetsPasswords;

	/**
	 * @var string
	 */
	protected $redirectPath = "/";

	/**
	 * @param Guard $auth
	 * @param PasswordBroker $passwords
	 * @param UserContract $user
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords, UserContract $user) {
		$this->auth = $auth;
		$this->passwords = $passwords;
		$this->user = $user;
	}


	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 * @throws GeneralException
     */
	public function postEmail(Request $request)
	{
		$data['stat'] = "error";
		//Make sure user is confirmed before resetting password.
		$user = User::where('email', $request->get('email'))->first();
		if ($user) {
			if ($user->confirmed == 0) {
				$data['msg']="Your account is not confirmed. Please click the confirmation link in your e-mail, or " . '<a href="' . route('account.confirm.resend', $user->id) . '">click here</a>' . " to resend the confirmation e-mail.";
				 return response()->json($data);
			}
		} else {
			$data['msg']="There is no user with that e-mail address.";
			 return response()->json($data);
		}

		$this->validate($request, ['email' => 'required|email']);

		
			$response = Password::sendResetLink($request->only('email'), function (Message $message) {
				$message->subject($this->getEmailSubject());
			});


		switch ($response) {
			case Password::RESET_LINK_SENT:
				$data['stat'] = 'ok';
				$data['msg'] = trans($response);
				return response()->json($data);

			case Password::INVALID_USER:
				$data['msg'] = trans($response);
				return response()->json($data);
		}
	}

	/**
	 * @param null $token
	 * @return mixed
     */
	public function getReset($token = null)
	{
		if (is_null($token))
			throw new NotFoundHttpException;
		return view('frontend.auth.reset')->withToken($token)->withClass('reset');
	}


	/**
	 * Reset the given user's password.
	 *
	 * @param  ResetPasswordRequest  $request
	 * @return Response
	 */
	public function postReset(ResetPasswordRequest $request)
	{
		
		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);
		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = bcrypt($password);
			$user->save();
			$this->auth->login($user);
		});
		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				return redirect($this->redirectPath());
			default:
				return redirect()->back()
							->withInput($request->only('email'))
							->withErrors(['email' => trans($response)]);
		}
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getChangePassword() {
		return view('frontend.auth.change-password');
	}

	/**
	 * @param ChangePasswordRequest $request
	 * @return mixed
	 */
	public function postChangePassword(ChangePasswordRequest $request) {
		$this->user->changePassword($request->all());
		return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.password_successfully_changed"));
	}
}
