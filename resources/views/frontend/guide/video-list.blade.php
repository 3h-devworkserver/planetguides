@foreach($gallerys as $gallery)
	<div class="col-md-3 col-sm-4">
		<div class="thumb-wrap">
			<a style="background-image:url({{ asset('images/1.jpg') }})" data-fancybox-group="gallery" href="{{ $gallery->path }}?fs=1&amp;autoplay=1" class="video"></a>
			@role('Guide')
			{!! Form::open(['route'=>'frontend.guide.video.delete','id'=>'galleryDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                <button type="submit" id="videoDeleteButton" onclick="return confirm('Are you sure you want to delete this item?');">
                    <i>&times;</i>
                </button> 
            {!! Form::close() !!}
            <div class="caption-area"> 
	            {!! Form::open(['url'=>'#','id'=>'videoCaptionEditForm','style'=>'display:none']) !!} 
	                {!! Form::hidden('id',$gallery->id) !!}
					{!! Form::text('caption',$gallery->caption, ['class'=>'form-control']) !!}
	                <button type="submit">Save</button> 
	            {!! Form::close() !!}
            	<span id="videoCaptionEditBtn" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
            </div> 
            @endauth    
		</div>	
	</div>
@endforeach
@if($gallerys->nextPageUrl()) 
	<div class="row"  id="loadmore-pagination">
	<div class="col-md-12 text-center">
	    <nav class="btn btn-primary cust-btn-lg">
	      <a id="loadmore-gallery" href="{!! $gallerys->nextPageUrl() !!}">Load More</a>
	      <img id="loadmore-loader" style="display: none;" src="{{asset('images/ajax-loader.gif')}}">
	    </nav>
	 </div>
	</div>
 @endif