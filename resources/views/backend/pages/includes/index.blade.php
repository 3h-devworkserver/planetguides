@extends ('backend.layouts.master')

@section ('title', trans('menus.page_management'))

@section('page-header')
    <h1>
        {{ trans('menus.page_management') }}
        <small>{{ trans('menus.active_pages') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! trans('menus.page_management') !!}</li>
@stop

@section('content')
    @include('backend.pages.includes.header-buttons')

    {!! $table !!}

    <div class="clearfix"></div>
@endsection

@section('tableScript')
<script>
    $(document).ready(function() {
        $('#pageTable').DataTable();
    } );
</script>
@stop