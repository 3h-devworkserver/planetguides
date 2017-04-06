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

    <table id="pageTable" class="table table-striped table-bordered table-hover ">
        <thead>
        <tr>
            <th>{{ trans('crud.pages.id') }}</th>
            <th>{{ trans('crud.pages.title') }}</th>
            <th class="visible-lg">{{ trans('crud.pages.created') }}</th>
            <th class="visible-lg">{{ trans('crud.pages.last_updated') }}</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td>{!! $page->id !!}</td>
                    <td>{!! $page->title !!}</td>
                   
                    <td class="visible-lg">{!! $page->created_at->diffForHumans() !!}</td>
                    <td class="visible-lg">{!! $page->updated_at->diffForHumans() !!}</td>
                    <td>{!! $page->action_buttons !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {!! $pages->total() !!} {{ trans('crud.pages.total') }}
    </div>

    <div class="pull-right">
        {!! $pages->render() !!}
    </div>

    <div class="clearfix"></div>
@endsection

@section('tableScript')
<script>
    $(document).ready(function() {
        $('#pageTable').DataTable();
    } );
</script>
@stop