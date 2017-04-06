@extends('frontend.layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
 			@include('includes.partials.messages')
			<div class="panel panel-default">

				<div class="panel-heading">{{ trans('labels.reset_password_box_title') }}</div>
				<div class="panel-body">

					{!! Form::open(['to' => 'password/reset', 'class' => 'form-horizontal', 'role' => 'form', 'id'=>'resetForm']) !!}

						<input type="hidden" name="token" value="{{ $token }}">
						<div class="form-group">
							{!! Form::label('email', trans('validation.attributes.email'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('email', 'email', null, ['class' => 'form-control', 'required']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('password', trans('validation.attributes.password'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('password', 'password', null, ['class' => 'form-control', 'required', 'minlength' => '6']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'required', 'minlength' => '6']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit(trans('labels.reset_password_button'), ['class' => 'btn btn-primary']) !!}
							</div>
						</div>

					{!! Form::close() !!}

				</div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->

    </div><!-- row -->
@endsection