@extends ('backend.layouts.master')

@section ('title', 'Contact Email Management')

@section('page-header')
  <h1>
      Contact Email Management
  </h1>
@endsection

@section ('breadcrumbs')
  <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
  <li class="active">Contact Email Management</li>
@stop

@section('content')

 {!! $table !!}

    <div class="clearfix"></div>

@endsection