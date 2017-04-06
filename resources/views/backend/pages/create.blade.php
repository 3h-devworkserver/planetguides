@extends ('backend.layouts.master')

@section ('title', trans('menus.pages.create'))

@section('page-header')
    <h1>
        {{ trans('menus.page_management') }}
        <!-- <small>{{ trans('menus.pages.create') }}</small> -->
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.pages.index', trans('menus.page_management')) !!}</li>
    <li class="active">{!! trans('menus.pages.create') !!}</li>
@stop

@section('content')
    <!--@include('backend.pages.includes.header-buttons')-->

<div class="box box-primary">
  <div class="box-header with-border">
      <h3 class="box-title">{{ trans('menus.pages.create') }}</h3>
      <div class="box-tools pull-right">
          <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
            {!! form($form) !!}
     @include('backend.includes.tinymce')
    </div><!-- /.box-body -->
</div>

   

    
@stop

