
@extends('frontend.layouts.masterProfile')
@section('title') Profile | {{ $siteTitle }}@endsection
@section('content')

<section class="dashboard">
		<div class="container">

			<div class="row">

				
				<div class="col-md-9">
				@include('includes.partials.messages')
					<div class="profile-edit">
						<h4>User Profile</h4>
						<div class="row">
							<div class="col-md-12 profile-form">
							{!! Form::model(['url' => '#', 'role' => 'form', 'id'=>'experienceForm', 'files'=>true]) !!}
								<input type="file" name="file">
								<img clas="preview" src="">	
							{!! Form::close() !!}						
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>

@endsection

@section('after-scripts-end')
{!! HTML::script('blueimp/jquery.fileupload.js') !!}

 <script>
      $(document).ready(function() {
   		$('input[name=file]').change(function()
			{   
				 var _data = $(this).serialize();
				 console.log(_data);
			    // AJAX Request
			    $.post( base_url+'/traveller/media-upload', {file: _data} )
			        .done(function( data )
			        {
			            if(data.error)
			            {
			                // Log the error
			                console.log(error);
			            }
			            else
			            {
			                // Change the image attribute
			                $( 'img.preview' ).attr( 'src', data.path );
			            }
			        });
			});
   	});

   </script>
@stop