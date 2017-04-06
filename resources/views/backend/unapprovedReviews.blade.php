@extends ('backend.layouts.master')

@section ('title', trans('menus.review_management'))

@section('page-header')
    <h1>
        {{ trans('menus.review_management') }}
        <small>Unapproved Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Unapproved Reviews</li>
@stop

@section('content')
    {!! $table !!}
    <div class="clearfix"></div>
@stop

