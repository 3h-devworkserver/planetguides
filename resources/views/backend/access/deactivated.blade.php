@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.deactivated_users'))

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.deactivated_users') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.deactivated', trans('menus.deactivated_users')) !!}</li>
@stop

@section('content')
    @include('backend.access.includes.partials.header-buttons')
    {!! $table !!}
    <div class="clearfix"></div>
@stop
