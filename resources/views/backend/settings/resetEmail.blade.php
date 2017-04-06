@extends ('backend.layouts.master')
@section ('Reset Email', trans('menus.settings_management'))
@section('page-header')
    <h1>
        {{ trans('menus.settings_management') }}
        
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.reset_email_settings') !!}</li>
@stop
@section('content')

   
<div class="box box-primary">
  <!--<div class="box-header with-border">
      <h3 class="box-title">Slides Review</h3>
      <div class="box-tools pull-right">
          <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
      </div>
    </div>-->
    <div class="box-body">
            {!! form($form) !!}
    @include('backend.includes.tinymce')
    </div><!-- /.box-body -->
</div>
   

@endsection



    

