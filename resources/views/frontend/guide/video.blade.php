@extends('frontend.layouts.masterProfile')
@section('title') Gallery | {{ $siteTitle }}@endsection
@section('content')
<div class="container">
	<div class="inner-gallery gallery">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h2 class="text-center">Video Gallery</h2>
				</div>
			</div>
		</div>
        @include('includes.partials.messages')
		<div class="row">
        @role('Guide')
			<div class="col-md-3 col-sm-4">
				<div class="thumbnail">
                 
					<a  data-toggle="modal" data-target="#video-modal" class="bg-image">
                    <div class="galleryUploadButton"><span class="uploadButton"><i class="fa fa-plus"></i></span></div>

                    </a>
				    <div class="galleryUploadProcess"></div>
				</div>
			</div>
        @endauth
			<div class="gallery-list">
				@include('frontend.guide.video-list')
			</div>
			
		</div>

	</div>
</div>
@include('frontend.guide.modal')


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
