@foreach($licenses as $gallery)
<div class="col-md-3">
<div class="thumbnail">
			<a style="background-image:url({{$gallery->imagesmall}})"  data-fancybox-group="gallery" href="{{$gallery->path}}" title="{{ $gallery->caption }} " class="fancybox bg-image"></a>
			
			{!! Form::open(['url'=>'#','id'=>'addlicenseDeleteForm']) !!} 
                {!! Form::hidden('id',$gallery->id) !!}
                {!! Form::hidden('user_id',$gallery->user_id) !!}
	                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this item?');">
	                    <span>&times;</span>
	                </button> 
            {!! Form::close() !!}
                
		</div>
	</div>
 @endforeach

 <div class="col-md-3">
              <div class="imagesUploadArea">
                <div class="thumbnail browse-image">

                  {!! Form::open() !!}
                  <div class="galleryUploadButton">
                   <span class="uploadButton"><i class="fa fa-plus"></i></span>
                   <input 
                   id="licensePicture"
                   name="licensegalleryPic"
                   data-url="{{ route('backend.guide.license.upload') }}"
                   accept="image/*" 
                   type="file"
                   multiple>
                 </div> 
                 {!! Form::hidden('id', '',['class'=>'licenFormUser']) !!}

                 {!! Form::close() !!}
                 <div class="imglicloader" style="display: none;">
                  {!!Form::image('images/ajax-loader.gif')!!}
                </div>
              </div>
              <div class="loader-overlay"><div class="custom-loader"></div></div>
            </div>
            </div>

 <script type="text/javascript">
/*  $('#licensePicture').fileupload({
        dataType: 'json',
        dropZone: $(),
    add: function(e, data) {

                    $('.imglicloader').show();

                    var fileType = data.files[0].type;
                    var fileSize = data.files[0].size;
                    var extension = fileType.replace(/^.*\//, '');
                    
                    if(fileType.indexOf('image/') === 0) {
                        if(extension=='jpeg' || extension=='png'){
                            if(fileSize<2000099){
                                $('.loader-overlay').show();
                                data.submit();
                            }else{
                                alert('Image size must be less than 2mb');
                            }
                     
                        }else{
                            alert('Only allowed jpeg and png format');
                        }
                            
                    }else{
                        alert('Only allowed image format');
                    }
                        
                },
        done: function (e, data) {
            var returnJson = jQuery.parseJSON(data.jqXHR.responseText);
            console.log(returnJson);
             $('.imglicloader').hide();
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
             // $('#licenseshow').html(returnJson.html);
             var userid = $('#licensePicture').attr('data-user');
             $('#licenseshow').html(returnJson.html);
             // alert(userid);
             $('#licenseshow .licenFormUser').val(userid);
             $('#licenseshow #licensePicture').attr('data-user',userid );

             $(window).scrollTop('#failedmsg');

        },
        fail: function(e,data){
             $('.loader-overlay').hide();
             $('.imglicloader').hide();
            console.log(e);
            console.log(data);
            console.log('failed');

        },
        error: function(e, data) {
                     $('.loader-overlay').hide();
                     $('.imglicloader').hide();
                   console.log(e);
                   console.log(data);
                   console.log('error');

                }
    });*/
</script>
 