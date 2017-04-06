<?php $c = 1; ?>
@foreach($licenses as $gallery)
<div class="col-md-3">
		<div class="thumbnail">
			<a style="background-image:url({{ asset($gallery->imagesmall) }})"  data-fancybox-group="gallery" href="{{ asset($gallery->path) }}" title="{{ $gallery->caption }} " class="fancybox bg-image">
				@if ($c==1)
					<input type="hidden" id="can_certify_guide" data-can="true" />
					<?php $c++; ?>
				@endif
			</a>
			
			{!! Form::open(['url'=>'#','id'=>'addlicenseDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                {!! Form::hidden('user_id',$gallery->user_id) !!}
	                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">
	                    <span>&times;</span>
	                </button> 
	               <!-- <button type="submit" id="galleryDeleteButton" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">
	                    <span>&times;</span> -->
	                </button>
            {!! Form::close() !!}
		</div>
		</div>	
 @endforeach