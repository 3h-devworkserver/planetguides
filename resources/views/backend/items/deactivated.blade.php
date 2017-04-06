@extends ('backend.layouts.master')

@section ('title', 'Items Management')

@section('item-header')
    <h1>
       'Items Management'
        <small>Active Items</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Items Management</li>
@stop

@section('content')
  <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Active Items</h3>

            <div class="box-tools pull-right">
                @include('backend.items.includes.header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->title !!}</td>
                                <td class="visible-lg">{!! $item->created_at->diffForHumans() !!}</td>
                                <td class="visible-lg">{!! $item->updated_at->diffForHumans() !!}</td>
                                <td>{!! $item->action_buttons !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-left">
                {!! $items->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $items->total()) }}
            </div>

            <div class="pull-right">
                {!! $items->render() !!}
            </div>

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection


