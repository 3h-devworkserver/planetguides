@extends ('backend.layouts.master')

@section ('title', 'Unapproved License')

@section('page-header')
    <h1>
        {{ trans('menus.unapproved_license') }}
        <small>List of unapproved license</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.unapproved_license') !!}</li>
@stop

@section('content')
	{!! $table !!}

    <div class="clearfix"></div>
@endsection

@section('after-scripts-end')
{!! HTML::script('fancybox/jquery.fancybox.js?v=2.1.5') !!}

<script type="text/javascript">
  /*
       *  Simple image gallery. Uses default settings
       */
  

    
</script>



@stop

@section('after-styles-end')
{!! HTML::style('fancybox/jquery.fancybox.css') !!}
@stop
