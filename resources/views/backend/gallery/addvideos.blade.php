@foreach($videos as $gallery)
<div class="col-md-3">
		<div class="thumbnail">
			<a style="background-image:url(https://img.youtube.com/vi/{{ $gallery->imagesmall }}/default.jpg)" data-fancybox-group="gallery" href="{{ $gallery->path }}?fs=1&amp;autoplay=1" class="video bg-image fancy-box"></a>
			
			{!! Form::open(['url'=>'#','id'=>'videoDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                {!! Form::hidden('user_id',$gallery->user_id) !!}
                <button type="submit" id="videoDeleteButton" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">
                    <span>&times;</span>
                </button> 
            {!! Form::close() !!}
		</div>	
        </div>
@endforeach

<div class="col-md-3">
              <div class="thumbnail browse-image">

                <div class="galleryUploadButton" data-toggle="modal" data-target="#video-modal"><span class="uploadButton"><i class="fa fa-plus"></i>
                </span></div>

           <!--  <div class="galleryUploadButton"><span class="uploadButton">
                <a  data-toggle="modal" data-target="#video-modal" class="bg-image"><i class="fa fa-plus"></i></a></span></div> -->
                
                <div class="galleryUploadProcess"></div>
              </div>
            </div>


