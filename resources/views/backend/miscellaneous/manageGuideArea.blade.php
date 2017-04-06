@extends ('backend.layouts.master')

@section ('title', trans('menus.guidearea_management'))

@section('page-header')
    <h1>
        {{ trans('menus.guidearea_management') }}
        <small>Guide Area Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Guide Area Reviews</li>
@stop

@section('content')
		<div class="btn-group pull-right addguide">
    	
        	<a href="{{ URL::route('admin.guidearea.upload') }}" class="btn btn-default"> Add Guide Area </a>
         
        </div>
    {!! $table !!}
    <div class="clearfix"></div>
@stop

