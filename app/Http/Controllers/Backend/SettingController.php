<?php namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Setting;
use Laracasts\Flash\Flash;
use App\Http\Requests\Backend\Setting\SettingRequest;
use File;
use Input;

class SettingController extends Controller
{
    /**
     * Show the form for editing the settings.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getSettings(FormBuilder $formBuilder)
    {
        $setting = Setting::firstOrFail();
        $form = $formBuilder->create('App\Forms\SettingsForm', [
            'method' => 'PATCH',
            'enctype'=>'multipart/form-data',
            'url' => route('admin.setting.update', ['id' => $setting->id]),
            'model' => $setting
        ]);
        return view('backend.settings.index', compact('form','setting'));
    }

    /**
     * Update the settings in storage.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function patchSettings($id, SettingRequest $request)
    {
        $setting=Setting::find($id);
        if($request->hasFile('logo'))
        {     
          $file = $request->file('logo');
          $destination_path = 'images/';
          $filename = 'logo.'.$file->getClientOriginalExtension();
          $file->move($destination_path, $filename);
          $setting->logo = $destination_path . $filename;
        }
        
        $setting->fill($request->except('logo'));
        $setting->save() ? Flash::success(trans('alerts.settings.success')) : Flash::error(trans('alerts.settings.fail'));
        return redirect(route('admin.setting'));
    }


      /**
     * Show the form for editing the Reset Email settings.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getResetEmailSettings(FormBuilder $formBuilder)
    {
        $data['content']= File::get(base_path() . '/resources/views/emails/password.blade.php');
        
        $form = $formBuilder->create('App\Forms\EmailSettingsForm', [
            'method' => 'POST',
            'url' => route('admin.setting.resetEmail.update'),
            'model' => $data
        ]);
        return view('backend.settings.resetEmail', compact('form'));
    }

    /**
     * Update the settings in storage.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function postResetEmailSettings(Request $request)
    {
        $default = File::get(base_path() . '/resources/views/emails/password.blade.php');
        $bytes_written = File::put(base_path() . '/resources/views/emails/password.blade.php', Input::get('content', $default));
        
        $bytes_written? Flash::success(trans('alerts.settings.success')) : Flash::error(trans('alert.settings.fail'));
        return redirect(route('admin.setting.resetEmail'));
    }

      /**
     * Show the form for editing the Confirm Email settings.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getConfirmEmailSettings(FormBuilder $formBuilder)
    {
        $data['content']= File::get(base_path() . '/resources/views/emails/confirm.blade.php');
        
        $form = $formBuilder->create('App\Forms\EmailSettingsForm', [
            'method' => 'POST',
            'url' => route('admin.setting.confirmEmail.update'),
            'model' => $data
        ]);
        return view('backend.settings.confirmEmail', compact('form'));
    }

    /**
     * Update the settings in storage.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function postConfirmEmailSettings(Request $request)
    {
        $default = File::get(base_path() . '/resources/views/emails/confirm.blade.php');
        $bytes_written = File::put(base_path() . '/resources/views/emails/confirm.blade.php', Input::get('content', $default));
        
        $bytes_written? Flash::success(trans('alerts.settings.success')) : Flash::error(trans('alert.settings.fail'));
        return redirect(route('admin.setting.confirmEmail'));
    }

     /**
     * Show the form for editing the Success Email settings.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getSuccessEmailSettings(FormBuilder $formBuilder)
    {
        $data['content']= File::get(base_path() . '/resources/views/emails/success.blade.php');
        
        $form = $formBuilder->create('App\Forms\EmailSettingsForm', [
            'method' => 'POST',
            'url' => route('admin.setting.successEmail.update'),
            'model' => $data
        ]);
        return view('backend.settings.successEmail', compact('form'));
    }

    /**
     * Update the settings in storage.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function postSuccessEmailSettings(Request $request)
    {
        $default = File::get(base_path() . '/resources/views/emails/success.blade.php');
        $bytes_written = File::put(base_path() . '/resources/views/emails/success.blade.php', Input::get('content', $default));
        
        $bytes_written? Flash::success(trans('alerts.settings.success')) : Flash::error(trans('alert.settings.fail'));
        return redirect(route('admin.setting.successEmail'));
    }


     /**
     * Show the form for editing the Admin Notify Email settings.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getNotifyEmailSettings(FormBuilder $formBuilder)
    {
        // $data['content']= File::get(base_path() . '/resources/views/emails/userRegistered.blade.php');
        $data['content']= File::get(base_path() . '/resources/views/emails/notifyadmin.blade.php');
        
        $form = $formBuilder->create('App\Forms\EmailSettingsForm', [
            'method' => 'POST',
            'url' => route('admin.setting.notifyEmail.update'),
            'model' => $data
        ]);
        return view('backend.settings.notifyEmail', compact('form'));
    }

    /**
     * Update the settings in storage.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function postNotifyEmailSettings(Request $request)
    {
        $default = File::get(base_path() . '/resources/views/emails/notifyadmin.blade.php');
        $bytes_written = File::put(base_path() . '/resources/views/emails/notifyadmin.blade.php', Input::get('content', $default));
        
        $bytes_written? Flash::success(trans('alerts.settings.success')) : Flash::error(trans('alert.settings.fail'));
        return redirect(route('admin.setting.notifyEmail'));
    }

    /**
     * @param null
     * @return Response
     */
    public function getServiceCharge()
    {
        $settings = Setting::firstOrFail();
        return view('backend.settings.serviceCharges', compact('settings'));
    }

    /**
     * Update the service charge.
     *
     * @param Setting $setting
     * @param SettingRequest $request
     * @return Response
     */
    public function postServiceCharge(Request $request)
    {
        $this->validate($request, [
            'charges' => 'integer',
            'id' =>'required | integer'
        ]);
        $setting = Setting::find($request->id);

        $setting->charges = $request->charges;
        $setting->save() ? Flash::success(trans('alerts.charges.success')) : Flash::error(trans('alerts.charges.fail'));
        return redirect(route('backend.service.charge'));
    }

}