@extends('frontend.layouts.masterProfile')
@section('title') Gallery | {{ $siteTitle }}@endsection
@section('content')
<div class="container">
	<div class="inner-gallery gallery">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h2 class="text-center">Gallery</h2>
				</div>
			</div>
		</div>
		<div class="row">
		  @role('Guide')
			<div class="col-md-3 col-sm-4">
				<div class="thumbnail browse-image">
					{!! Form::open() !!}
		             <div class="galleryUploadButton">
		                 <span class="uploadButton"><i class="fa fa-plus"></i></span>
		                    <input 
		                        id="galleryPic"
		                        name="galleryPic"
		                        data-url="{{ route('frontend.guide.gallery.upload') }}"                        
		                        accept="image/*" 
		                        type="file"
		                        multiple>
		              </div> 
		              {!! Form::hidden('id', $userid) !!}
      				{!! Form::close() !!}
     			<div class="loader-overlay"><div class="custom-loader"></div></div>
				</div>
			</div>
		  @endauth
			<div class="gallery-list">
				@include('frontend.guide.gallery-list')
			</div>
			
		</div>

	</div>
</div>



@endsection

@section('after-scripts-end')
    {!! HTML::script('blueimp/load-image.all.min.js') !!}
    {!! HTML::script('blueimp/canvas-to-blob.js') !!}
    {!! HTML::script('blueimp/jquery.iframe-transport.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-process.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-image.js') !!}
    {!! HTML::script('blueimp/jquery.fileupload-validate.js') !!}

    {!! HTML::script('js/customUpload.js') !!}

    <script>
    $(document).ready(function() {
        $(document).on('click', '#loadmore-gallery', function (e) {
            e.preventDefault();
            $('#loadmore-pagination #loadmore-loader').show();
            $('#loadmore-pagination #loadmore-gallery').hide();
            $.ajax({
                type:'GET',
                url : $(this).attr('href'),
                }).done(function (data) {
                    $('#loadmore-pagination').remove();
                    $('#loadmore-pagination #loadmore-loader').hide();
                    $('#loadmore-pagination #loadmore-gallery').show();
                    $('.gallery-list').append(data.html);
                })
            });
        });

</script> 

@stop

@section('after-styles-end')
  {!! HTML::style('blueimp/css/jquery.fileupload.css') !!}
  {!! HTML::style('blueimp/css/jquery.fileupload-ui.css') !!}
@stop
