@extends ('backend.layouts.master')

@section ('title', 'Reply Contact Email')

@section('page-header')
  <h1>
      Reply Contact Email
  </h1>
@endsection

@section ('breadcrumbs')
  <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
  <li class="active">Reply Contact Email</li>
@stop

@section('content')
		<label>Message Recieved</label>

<div class="well">{!! $contact->comment !!}</div>
		
	{!!Form::open(['url'=>'admin/contactemail/reply/'.$contact->id, 'method'=>'patch']) !!}
	<div class="form-group">
		<label>To</label>
		{!!Form::text('to', $contact->email, ['placeholder'=>'Enter Email Address', 'class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		<label>Subject</label>
		{!!Form::text('subject', null, ['placeholder'=>'Enter Subject', 'class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		<label>Email</label>
		{!!Form::textarea('email', $template, ['placeholder'=>'Enter Email Content', 'class'=>'form-control']) !!}
		</div>
		{!!Form::submit('Send', ['class'=>'btn btn-warning']) !!}
	{!!Form::close() !!}

     @include('backend.includes.tinymce')
    <div class="clearfix"></div>

@endsection