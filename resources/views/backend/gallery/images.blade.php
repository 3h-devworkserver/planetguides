@foreach($gallerys as $gallery)
<div class="col-md-3">
		<div class="thumbnail radioconsistency">
			<a style="background-image:url({{ asset($gallery->imagesmall) }})"  data-fancybox-group="gallery" href="{{ asset($gallery->path) }}" title="{{ $gallery->caption }} " class="fancybox bg-image"></a>
			
	                <button type="button" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}" id="galleryDeleteButton" class="delete-btn">
	                <span>&times;</span>
	                </button> 
            {!! Form::hidden('id',$gallery->id) !!}
                {!! Form::hidden('user_id',$gallery->user_id,['id' => 'user_id']) !!}
            <div class="profile"> 
					<div class="radio">
					  @if ($gallery->imagesmall === $user->profile->profilesmallImg)
				    	<label>
						  <input type="radio" value="{{$gallery->imagesmall}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}" checked /> Set as Profile Picture
						</label>
						@else
				    	<label>
						  <input type="radio" value="{{$gallery->imagesmall}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}"   /> Set as Profile Picture
						</label>
						@endif
					</div>
            </div>  
		</div>	
	</div>

		

@endforeach