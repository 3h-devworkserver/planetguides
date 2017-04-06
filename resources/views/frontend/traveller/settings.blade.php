@extends('frontend.layouts.masterProfile')
@section('title') Settings | {{ $siteTitle }}@endsection
@section('content')

<section class="dashboard">
		<div class="container">

			<div class="row">

				<div class="col-md-6 col-md-offset-3">
				@include('includes.partials.messages')
					<div class="profile-edit">
						<h4>User Settings</h4>
						<div class="row">
							<div class="email-address col-md-12">
						{{--	{!! Form::model($user, ['route' => 'frontend.traveller.settings.emailupdate']) !!}
								   <div class="form-group">
								    {!! Form::label('email', 'Email Address', ['class' => 'control-label']) !!}
								   	{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
								   </div>
								   <div class="form-group save-btn">
								    {!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
								   </div>
							{!! Form::close() !!} --}}
							
							</div>
							<div class="col-md-12"> 
								{!! Form::open(['route' => 'frontend.traveller.settings.update', 'id' => 'travellerSettings']) !!}
								<div class="form-group">
								    {!! Form::label('email', 'Email Address', ['class' => 'control-label']) !!}
								   	{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
								   </div>
								   
								   <div class="form-group">
								   {!! Form::label('old_password', 'Old Password', ['class' => 'control-label']) !!}
								  	 {!! Form::password('old_password', ['class' => 'form-control']) !!}
								   </div>
								   <div class="form-group">
								   {!! Form::label('password', 'New Password', ['class' => 'control-label']) !!}
								   	{!! Form::password('password', ['class' => 'form-control']) !!}
								   </div>
								   <div class="form-group">
								   {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) !!}
								   	{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
								   </div>
								   <div class="form-group">
								   	{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
								   </div>
								{!! Form::close() !!}
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>

@endsection
