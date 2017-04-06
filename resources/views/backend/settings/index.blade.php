@extends ('backend.layouts.master')
@section ('Settings Management', trans('menus.settings_management'))
@section('page-header')
    <h1>
        {{ trans('menus.settings_management') }}
        
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.settings_management') !!}</li>
@stop
@section('content')

<div class="box box-primary">
    <div class="box-body">
    	{!! form_start($form) !!}
    	{!! form_until($form, 'pinterest') !!}
   <div class="form-group col-md-12">
   		<img src="{{ asset($setting->logo) }}" width="80px"/>
   	<!-- <div class="row">
	   <input id="uploadLogo" placeholder="Choose Logo" disabled="disabled"/>
		<div class="logoUpload btn btn-primary">
		    <span>Upload</span>
		    <input id="uploadBtn" type="file" class="upload" name="logo" accept="image/*"/>
		</div>
	</div> -->
	<div class="logoClass">
	   <input id="uploadLogo" placeholder="Choose Logo" disabled="disabled"/>
		<div class="logoUpload btn">
	<span class="btn btn-file">
		<i class="fa fa-folder-open" aria-hidden="true"></i> Browse
		     <input id="uploadBtn" type="file" class="upload" name="logo" accept="image/*"/>
	</span>
		   
		</div>
	</div>
	</div>
  {!! form_rest($form) !!}
    </div><!-- /.box-body -->
</div>


@endsection

@section('after-scripts-end')
	<script>
		$(document).ready(function(){
		    $("#uploadBtn").change(function(){
		     	    var imageName = $(this).val();
		     	    $("#uploadLogo").val(imageName);
		    });
		});
	</script>
@endsection


    

