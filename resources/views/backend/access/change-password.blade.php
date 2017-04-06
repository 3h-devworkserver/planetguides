@extends ('backend.layouts.master')

@section ('title', 'User Management | Change User Password')

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section('page-header')
    <h1>
        User Management
        <!-- <small>Change Password</small> -->
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li>{!! link_to_route('admin.access.users.index', 'User Management') !!}</li>
    <li>{!! link_to_route('admin.access.users.edit', "Edit ".$user->name, $user->id) !!}</li>
    <li class="active">{!! link_to_route('admin.access.user.change-password', 'Change Password', $user->id) !!}</li>
@stop

@section('content')
    @include('backend.access.includes.partials.header-buttons')

    

<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(['route' => ['admin.access.user.change-password', $user->id], 'class' => '', 'role' => 'form', 'method' => 'post']) !!}

                <div class="form-group clearfix">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-8">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div><!--form control-->

                <div class="form-group clearfix">
                    <label class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-8">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div><!--form control-->

                <div class="col-md-offset-4 col-md-8">
                        <input type="submit" class="btn btn-success btn-sm" value="Save" />
                        <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                </div>

                {!! Form::close() !!}
            </div><!-- /.box-body -->
        </div> <!--Box primary-->
    </div><!--col-md-7-->
</div><!--row-->

    @stop