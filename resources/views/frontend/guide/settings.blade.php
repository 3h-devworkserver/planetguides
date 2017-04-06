@extends('frontend.layouts.masterProfile')
@section('title') Settings | {{ $siteTitle }}@endsection
@section('content')

<div class="dashboard">
<section class="container">
		<div class="row">
			<div class="col-md-12">
				@include('includes.partials.messages')
					<div class="setting-page">
						<h4>User Settings</h4>
						
						<?php /* ?> {!! Form::model($user, ['url' => '', 'class' => 'form-horizontal', 'id' => 'guideEmailUpdate']) !!}
								   <div class="form-group">
								    {!! Form::label('email', 'Email Address', ['class' => 'control-label col-md-2 col-sm-3']) !!}
								    <div class="col-md-8 col-sm-7"> 
								   	{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
								   	<p class="help-block" id="guideEmailMsg"></p>
								   	</div>
								   	<div class="col-md-2 col-sm-2">
								   	{!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
								   	</div>
								   	</div>
								    
								   
							{!! Form::close() !!} <?php */ ?>
						
											
								{!! Form::open(['id' => 'guidePswrdSettings', 'class' => 'form-horizontal']) !!}
								<div class="form-group">
								    {!! Form::label('email', 'Email Address', ['class' => 'control-label col-md-2 col-sm-3']) !!}
								    <div class="col-md-8 col-sm-7"> 
								   	{!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
								   	<p class="help-block" id="guideEmailMsg"></p>
								   	</div>
								   </div>
								   
								   <div class="form-group">
								   {!! Form::label('old_password', 'Old Password', ['class' => 'control-label col-sm-3 col-md-2']) !!}
								   <div class="col-md-8 col-sm-7">
								  	 {!! Form::password('old_password', ['class' => 'form-control']) !!}
								  	 <p class="help-block" id="guideOldPas"></p>
								   </div>
								   </div>
								   <div class="form-group">
								   {!! Form::label('password', 'New Password', ['class' => 'control-label col-md-2 col-sm-3']) !!}
								   <div class="col-md-8 col-sm-7">
								   	{!! Form::password('password', ['class' => 'form-control']) !!}
								   </div>
								   </div>
								   <div class="form-group">
								   {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label  col-md-2 col-sm-3']) !!}
								   <div class="col-md-8 col-sm-7">
								   	{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
								   </div>
								   <div class="col-md-2 col-sm-2">
								   	{!! Form::button('Save', ['type' => 'submit','class' => 'btn btn-primary']) !!}
								   </div>
								   </div>
								   
								 
								{!! Form::close() !!}
							</div>
			</div>
		</div>
		
		
</section>
</div>

@endsection

@section('after-scripts-end')
<script>

/** For email update */

$(document).ready(function(){
    $("#guideEmailUpdate").submit(function(event){
        event.preventDefault();
		var _data = $(this).serialize();

	        $.ajax({
	            url: base_url + '/guide/settings/email',
	            type: 'POST',
	            dataType: 'json',
	            data: _data
	        }).done(function(data) {
	                $('.loading').hide();
	                if (data.stat == 'ok'){
						$('#email').html(data.value);
						$('#guideEmailMsg').html('Email Successfully Updated.');
						$('#guideEmailMsg').removeClass('error');
						$('#guideEmailMsg').addClass('success');
			            $('#guideEmailMsg').show();
			            setTimeout(function() {
		                    $('#guideEmailMsg').fadeOut();
		                }, 5000);
	                }
	                else{
	                	$('.loading').hide();
	                	console.log(data.stat);
	                }
	            })
	        	.fail(function(data){
	        		var errors = data.responseJSON;
		            var errorsHtml= '';
		            $.each( errors, function( key, value ) {
		                errorsHtml += value[0]; 
		            });
		            $('#guideEmailMsg').html(errorsHtml);
		            $('#guideEmailMsg').removeClass('success');
		            $('#guideEmailMsg').addClass('error');
		            $('#guideEmailMsg').show();
		            setTimeout(function() {
	                    $('#guideEmailMsg').fadeOut();
	                }, 5000);
		            
	        	});
            });

  
//guide-settings validation
$("#guidePswrdSettings").validate({
  rules: {
        old_password: {
          required: true,
        },
        password: {
          required: true,
          minlength: 6
        },
        password_confirmation: {
          required: true,
          minlength: 6,
          equalTo: "#password"
        },

      }

  });

});
</script>
@stop
