@extends ('backend.layouts.master')

@section ('title', trans('menus.permission_management') . ' | ' . trans('menus.create_permission'))

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
        <small>{{ trans('menus.create_permission') }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li>{!! link_to_route('admin.access.roles.permissions.index', trans('menus.permission_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.permissions.create', trans('menus.create_permission')) !!}</li>
@stop

@section('content')

    @include('backend.access.includes.partials.header-buttons')

    {!! Form::open(['route' => 'admin.access.roles.permissions.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

        <div>
           

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="general" style="padding-top:20px">

                  {!! Form::open(['route' => 'admin.access.users.create', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-role']) !!}

        <div class="form-group">
            {!! Form::label('fname', 'First Name', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('fname', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('lname', 'Last Name', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('lname', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('email', 'Email Address', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address']) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('password', 'Password', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => 'Password']) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
            {!! Form::label('password_confirmation', 'Password Confirmation', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('password_confirmation', null, ['class' => 'form-control', 'placeholder' => 'Password Confirmation']) !!}
            </div>
        </div><!--form control-->

        <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('validation.attributes.associated_roles') }}</label>
                        <div class="col-lg-3">
                            @if (count($roles) > 0)
                                @foreach($roles as $role)
                                    <input type="checkbox" {{$role->id == 1 ? 'disabled checked' : ''}} value="{{$role->id}}" name="permission_roles[]" id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{!! $role->name !!}</label><br/>
                                @endforeach
                            @else
                                No Roles to set
                            @endif
                        </div>
                    </div><!--form control-->

                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('validation.attributes.system_permission') }}</label>
                        <div class="col-lg-3">
                            <input type="checkbox" name="system" />
                        </div>
                    </div><!--form control-->
        
<div class="pull-right">
                <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
            </div>
            <div class="clearfix"></div>
        
    {!! Form::close() !!}

                </div><!--general-->

                <div role="tabpanel" class="tab-pane" id="dependencies" style="padding-top:20px">

                  

                    </div><!--form control-->

                </div><!--dependencies-->

            </div><!--tab content-->

        </div><!--tabs-->

        

    {!! Form::close() !!}
@stop

@section('after-scripts-end')
    {!! HTML::script('js/backend/access/permissions/dependencies/script.js') !!}
@stop