@extends ('backend.layouts.master')

@section ('title', trans('menus.slides_management'))

@section('page-header')
    <h1>
        {{ trans('menus.slides_management') }}
        <!-- <small>Slides Reviews</small> -->
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Slides Reviews</li>
@stop

@section('content')

    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Slides Review</h3>
      <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <div class="box-body">
      {!! Form::model($slide, ['route' => ['admin.slides.update', $slide->id], 'class' => 'slider-backend', 'role' => 'form', 'method' => 'PATCH','files'=>true]) !!}
        
          
            <div class="form-group">
                <label>Title</label>
                {!! Form::input('text', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
            </div>
            <!-- <div class="thumbnail radioconsistency form-group"> -->
            <div class="thumbnail radioconsistency form-group preview">
              <!-- <a style="background-image:url({{ asset($slide->path) }})"  data-fancybox-group="gallery" title="{{ $slide->caption }} " class="fancybox bg-image"></a> -->
              <div class="bg-image sliderImage" style="background-image:url({{ asset($slide->path) }})"></div>
            </div>
            <div class="">
              <span class="btn btn-file">
                  <i class="fa fa-folder-open" aria-hidden="true"></i> Browse {!! Form::file('image',['class'=>'sliderUpload']) !!}
              </span>
              {!! Form::hidden('id',$slide->id) !!}
                {!! Form::submit('Save', array('class'=>'send-btn btn btn-orange')) !!}
            </div>
      {!! Form::close() !!}
    </div><!-- /.box-body -->
</div>
@stop



