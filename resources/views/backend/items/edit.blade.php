@extends ('backend.layouts.master')

@section ('title', 'Items Management')

@section('page-header')
    <h1>
        Edit Item
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.items.index', 'Items Management') !!}</li>
    <li class="active">{!! trans('menus.items.edit') !!}</li>
@stop

@section('content')
    <!-- @include('backend.items.includes.header-buttons') -->

    {!! form_start($form) !!}
   {!! form_until($form, 'content') !!}
    <div class="form-group">
        <label class="control-level">Category</label>

            {{ Form::select('category', $categories, $items->category, ['name' => 'category', 'class' => 'form-control', 'id' => 'category']) }}
    </div>
   
    <div class="form-group">
        <div class="container">
          <div class="row">
            
                <div class="editImage" style="background-image:url({{ asset($items->img) }});"></div>
            
            <div class="upload itemUpload btn btn-primary">
            {{ Form::file('img', ['class' => 'upload', 'id' => 'uploadBtn']) }}
            </div>
        </div>
        </div>
    </div>
   {!! form_rest($form) !!}
     @include('backend.includes.tinymce')
   

    <div class="clearfix"></div>
@stop