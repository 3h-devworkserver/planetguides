@foreach($gallerys as $gallery)
	<div class="col-md-3 col-sm-4">
		<div class="thumb-wrap">
			<a style="background-image:url({{ asset($gallery->path) }})"  data-fancybox-group="gallery" href="{{ asset($gallery->path) }}" title="{{ $gallery->caption }} " class="fancybox bg-wrap"></a>
			@role('Guide')
			{!! Form::open(['url'=>'#','id'=>'galleryDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                <button type="submit" id="galleryDeleteButton" onclick="return confirm('Are you sure you want to delete this item?');">
                    <i>&times;</i>
                </button> 
            {!! Form::close() !!}
            <div class="caption-area"> 
	            {!! Form::open(['url'=>'#','id'=>'galleryCaptionEditForm','style'=>'display:none']) !!} 
	                {!! Form::hidden('id',$gallery->id) !!}
					{!! Form::text('caption',$gallery->caption, ['class'=>'form-control']) !!}
	                <button type="submit">Save</button> 
	            {!! Form::close() !!}
            	<span id="galleryCaptionEditBtn" class="edit-icon" title="Edit"><i class="fa fa-pencil"></i></span>
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