@extends ('backend.layouts.master')

@section ('title', trans('menus.slides_management'))

@section('page-header')
    <h1>
        {{ trans('menus.slides_management') }}
        <small>Slides Reviews</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Slides Reviews</li>
@stop
{{-- <li class="{{ Active::pattern('admin/slides/create') }}">
                      <a href="{!! url('admin/slides/create') !!}"><i class="fa fa-plus"></i> {{ trans('menus.slides.new') }}</a>
                    </li> --}}
@section('content')
<div class="btn-group pull-right addguide">
        
            <a href="{!! url('admin/slides/create') !!}" class="btn btn-default"> {{ trans('menus.slides.new') }} </a>
         
        </div>
    {!! $table !!}
    <div class="clearfix"></div>
@stop

