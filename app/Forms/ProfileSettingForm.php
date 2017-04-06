<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProfileSettingForm extends Form
{
    public function buildForm()
    {
        $this
            
            ->add('fname', 'text', [
                'label' => trans('validation.attributes.fname'),
                'label_attr' => ['class' => 'col-sm-2 control-label'],
                'options' => ['class' => 'hello']
            ])
            ->add('lname', 'text', [
                'label' => trans('validation.attributes.lname')
            ])
            ->add('email', 'email', [
                'label' => trans('validation.attributes.email')
            ])
            ->add('password', 'text', [
                'label' => trans('validation.attributes.password')
            ])
            ->add('cpassword', 'text', [
                'label' => trans('validation.attributes.password_confirmation')
            ])
            ->add('active', 'checkbox', [
                'label' => trans('validation.attributes.active')
            ])
            ->add('confirmed', 'checkbox', [
                'label' => trans('validation.attributes.confirmed')
            ])
            ->add('certified', 'checkbox', [
                'label' => trans('validation.attributes.certified')
            ])
            
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}