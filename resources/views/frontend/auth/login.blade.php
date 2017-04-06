@extends('frontend.layouts.master')
@section('title') Admin Login Area | {{ $siteTitle }}@endsection
@section('content')

    <div class="row">

        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                @include('includes.partials.messages')
                <div class="logo-section">
                    {{trans('labels.login_box_title')}}
                </div>
            <div class="panel panel-default">
                <!-- <div class="panel-heading">{{trans('labels.login_box_title')}}</div> -->

                <div class="panel-body">

                    {!! Form::open(['url' => 'admin', 'role' => 'form']) !!}

                        <div class="form-group">
                            {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'control-label']) !!}
                            
                                {!! Form::input('email', 'email', old('email'), ['class' => 'form-control']) !!}
                            
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', trans('validation.attributes.password'), ['class' => 'control-label']) !!}
                            
                                {!! Form::input('password', 'password', null, ['class' => 'form-control']) !!}
                            
                        </div>

                        <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('remember') !!} {{ trans('labels.remember_me') }}
                                    </label>
                                </div>
                        </div>

                        <div class="form-group text-center">
                                {!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-primary btn-block', 'style' => 'margin-right:15px']) !!}

                                {!! link_to('#', trans('labels.forgot_password'),['id'=>'forgotPassword']) !!}
                        </div>

                    {!! Form::close() !!}

                </div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->

    </div><!-- row -->

@endsection