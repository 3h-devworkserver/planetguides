@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.active_pages') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
@stop

@section('content')
    
    <div class="top-btn">
        <div class="btn-group addguide">
            <a href="{{ URL::route('admin.access.addguide.create') }}" class="btn btn-orange"> Add Guide </a>
        </div>
    </div>
        {!! $table !!}
        
    

    <div class="clearfix"></div>
@stop

