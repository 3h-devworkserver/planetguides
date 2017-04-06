@extends ('backend.layouts.master')

@section ('title', trans('menus.lanugage_management'))

@section('page-header')
    <h1>
        {{ trans('menus.lanugage_management') }}
        <small>Guide Area Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Guide Area Reviews</li>
@stop

@section('content')
		<div class="btn-group pull-right addguide">
    	
        	<a href="{{ URL::route('admin.language.pages') }}" class="btn btn-default"> Add New Language </a>
         
        </div>
    {!! $table !!}
    <div class="clearfix"></div>
@stop

