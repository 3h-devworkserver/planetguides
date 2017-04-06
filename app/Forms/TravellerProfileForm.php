<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TravellerProfileForm extends Form
{
    protected $showFieldErrors = false;
    public function buildForm()
    {
        $this
            ->add('fname', 'text', [
                'label' => trans('labels.fields.user.fname')

            ])
            
            ->add('lname', 'text', [
                'label' => trans('labels.fields.user.lname')
            ])

            ->add('nickname', 'text', [
                'label' => trans('labels.fields.user.nickname')
            ])

            ->add('gender', 'select', [
                'choices' => ['' => 'Select Gender', '0' => 'Male', '1' => 'Female', '2' => 'Others']
                // 'empty_value' => 'Select Gender'
            ])
            // ->add('gender', 'select', [
            //     'label' => trans('labels.fields.user.gender')
            // ])
            ->add('phone', 'text', [
                'label' => trans('labels.fields.user.phone')

            ])
            ->add('state', 'select', [
                'label' => trans('labels.fields.user.state')
            ])
            ->add('city', 'text', [
                'label' => trans('labels.fields.user.city')
            ])
            ->add('country', 'select', [
                'attr' => ['onchange' => 'print_state(\'state\',this.selectedIndex);']
            ])
            ->add('zip', 'number', [
                'label' => trans('labels.fields.user.zip')
            ])
            ->add('address', 'text', [
                'label' => trans('labels.fields.user.address')
            ])
            
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-primary']
            ]);
            
    }
}