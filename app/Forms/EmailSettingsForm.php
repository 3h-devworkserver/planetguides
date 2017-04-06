<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class EmailSettingsForm extends Form
{
    public function buildForm()
    {
        $this
            
            ->add('content', 'textarea', [
                'label' => trans('labels.fields.setting.email_setting')
            ])
           
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}