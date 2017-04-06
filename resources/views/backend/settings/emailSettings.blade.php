@extends ('backend.layouts.master')
@section ('title', trans('menus.settings_management'))
@section('page-header')
    <h1>
        {{ trans('menus.settings_management') }}
        
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.email_settings') !!}</li>
@stop
@section('content')
    {!! form($form) !!}
    @include('backend.includes.tinymce')
   
    <div class="clearfix"></div>

@endsection


    

