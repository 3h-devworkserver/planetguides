@extends ('backend.layouts.master')

@section ('title', 'Create Item')

@section('page-header')
    <h1>
        Create Item
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.items.index', 'Items Management') !!}</li>
    <li class="active">Create Item</li>
@stop

@section('content')
    <!-- @include('backend.items.includes.header-buttons') -->
   {!! form_start($form) !!}
   {!! form_until($form, 'content') !!}

   <div class="form-group">
    <label class="control-level">Category</label>
       {{ Form::select('category', $categories, 'NUll', ['name' => 'category', 'class' => 'form-control', 'id' => 'category']) }}
   
          
    </div>
    <div class="form-group">
        <div class="container">
          <div class="row">
           
            <div class="itemUpload btn btn-primary">
                <span>Upload</span>
                <input id="uploadBtn" type="file" class="upload" name="img" accept="image/*"/>
            </div>
        </div>
        </div>
    </div>
   {!! form_rest($form) !!}
     @include('backend.includes.tinymce')


    <div class="clearfix"></div>
  
@stop