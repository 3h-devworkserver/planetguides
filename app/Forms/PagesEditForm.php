<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PagesEditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => trans('labels.fields.page.title')
            ])
            ->add('slug', 'text', [
                'label' => trans('labels.fields.page.slug')
            ])
            ->add('content', 'textarea', [
                'label' => trans('labels.fields.page.content')
            ])
           
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}