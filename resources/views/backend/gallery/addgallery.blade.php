@foreach($gallerys as $gallery)
<div class="col-md-3">
		<div class="thumbnail radioconsistency">
			<a style="background-image:url({{ asset($gallery->imagesmall) }})" href="{{$gallery->path}}"  data-fancybox-group="gallery" title="{{ $gallery->caption }} " class="fancybox bg-image"></a>
			{{-- <a style="background-image:url({{ asset($gallery->path) }})"  data-fancybox-group="gallery" title="{{ $gallery->caption }} " class="fancybox bg-image"></a> --}}
			
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
					  {{--  @if ($gallery->path === $user->profile->profileImg)
				    	<label>
						  <input type="radio" value="{{$gallery->path}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}" checked /> Set as Profile Picture
						</label>
						@else
				    	<label>
						  <input type="radio" value="{{$gallery->path}}" name="status" data-imgid= "{{$gallery->id}}" data-userid= "{{$gallery->user_id}}"   /> Set as Profile Picture
						</label>
						@endif --}}
					</div>
            </div>  
		</div>
		</div>	
@endforeach
<div class="col-md-3">
                <div class="thumbnail browse-image">
                 <div class="galleryUploadButton">
                   <span class="uploadButton"><i class="fa fa-plus"></i></span>
                   <input 
                   id="galleryPicture"
                   name="galleryPic"
                   data-url="{{ route('frontend.guide.addgallery.upload') }}"
                   accept="image/*" 
                   type="file"
                   multiple>
                 </div> 
                 {!! Form::hidden('id', $user->id) !!}
                 <div class="imglicloader" style="display: none;">
                  {!!Form::image('images/ajax-loader.gif')!!}
                </div>

              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>


            <script type="text/javascript">
            $('#galleryPicture').fileupload({
        dataType: 'json',
        dropZone: $(),
    add: function(e, data) {

                    $('.imgloader').show();

                    var fileType = data.files[0].type;
                    var fileSize = data.files[0].size;
                    var extension = fileType.replace(/^.*\//, '');
                    
                    if(fileType.indexOf('image/') === 0) {
                        if(extension=='jpeg' || extension=='png'|| extension=='gif'|| extension=='jpg'){
                            if(fileSize<57671680){
                                $('.loader-overlay').show();
                                data.submit();
                            }else{
                                alert('Image size must be less than 5mb');
                            }
                     
                        }else{
                            alert('Only allowed jpeg, gif, jpg and png format');
                        }
                            
                    }else{
                        alert('Only allowed image format');
                    }
                        
                },
        done: function (e, data) {
            var returnJson = jQuery.parseJSON(data.jqXHR.responseText);
            console.log(returnJson);
            console.log(returnJson.success);
            console.log(returnJson.html);
             $('.imgloader').hide();
             $('.loader-overlay').hide();
             $('.licenseInput').remove();
             $('#userimage').show();
             $('#uservideos').show();
             $('#userbooking').show();
             $('#userlicense').show();
             $('#failedmsg').hide();
             $('#successmsg').hide();
             $('#successimgupload').empty();
             $('#successimgupload').addClass('alert alert-success');
             $('#successimgupload').append(returnJson.success);
             $('#galleryshow').html(returnJson.html);
             $(window).scrollTop('#failedmsg');
            
        },
        fail: function(e,data){
             $('.loader-overlay').hide();
             $('.imgloader').hide();
            console.log(e);
            console.log(data);
            console.log('failed');

        },
        error: function(e, data) {
                     $('.loader-overlay').hide();
                     $('.imgloader').hide();
                   console.log(e);
                   console.log(data);
                   console.log('error');

                },
    });
</script>
