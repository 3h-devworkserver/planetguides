<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Setting;


class SettingComposer
{
   

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $settings = Setting::first();
        $data['siteTitle'] = $settings->siteTitle;
        $data['siteDesc'] = $settings->description;
        $data['siteLogo'] = $settings->logo;
        if(!empty($settings->facebook))
            $value['facebook'] = $settings->facebook;

        if(!empty($settings->twitter))
            $value['twitter'] = $settings->twitter;

        if(!empty($settings->plus))
            $value['google-plus'] = $settings->plus;

        if(!empty($settings->pinterest))
            $value['pinterest'] = $settings->pinterest;


        $data['socials'] = $value;
        $data['siteLogo'] = $settings->logo;
        $view->with($data);

        

    }
}