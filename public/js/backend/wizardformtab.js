
 $(document).ready(function(){

  /*----------------gallery caption edit --------------*/

$(document).on('submit', '#addGuide', function(event) {
        event.preventDefault();

 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/admin/access/users',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
              console.log(data.user_id);
                $('input[name="id"]').attr('value',data.user_id);
                            $('#userimage').show();
                            $('#uservideos').show();
                            $('#userbooking').show();
                            $('#userlicense').show();
                            $('#failedmsg').hide();
                            $('#successimgupload').hide();
                            $('#successmsg').addClass('alert alert-success');
                            $('#successmsg').show();
                            $(window).scrollTop('#failedmsg');
                             window.location.href = base_url + '/admin/access/users/guide';
                            // location.reload();
                            })
            .fail(function(jqXHR, textStatus, errorThrown ) {
              var errors = jqXHR.responseJSON;
              var errorsHtml= '';
              $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value + '</p>';
            });

                console.log(errorsHtml);
                            $('#userimage').hide();
                            $('#uservideos').hide();
                            $('#userbooking').hide();
                            $('#userlicense').hide();
                            $('#successmsg').hide();
                            $('#successimgupload').hide();
                            $('#failedmsg').empty();
                            $('#failedmsg').addClass('alert alert-danger');
                            $('#failedmsg').append(errorsHtml);
                            $('#failedmsg').show();
                            $(window).scrollTop('#failedmsg');
              });
            });



       /*
       *  Guide user video submit form
       */

$(document).on('submit', '#myVideoForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var url = $('#url').val();
        var regx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
        var match = url.match(regx)
        if (match && match[1].length == 11) {
          var _data = $(this).serialize();
          alert(_data);


        $.ajax({
            url: base_url + '/guide/video/upload',
            method: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loader-overlay').hide();
                if (data.stat == 'ok'){
                     $('.video-message').empty();
                     $('#recovery-form').hide();
                    $('.video-message').show();
                    $('.video-message').addClass('alert alert-success');
                    $('.video-message').append(data.msg);
                } else {
                    $('.video-message').empty();
                    $('.video-message').show();
                    $('.video-message').addClass('alert alert-danger');
                    $('.video-message').append(data.msg);

                }
                setTimeout(function() {
                    $('.video-message').fadeOut();
                }, 5000);

            })
            .fail(function(jqXHR, textStatus, errorThrown ) {
                $('.loader-overlay').hide()
                $('.video-message').empty();
                $('.video-message').show();
                $('.video-message').addClass('alert alert-danger');
                $('.video-message').append(errorThrown);

                setTimeout(function() {
                    $('.video-message').fadeOut();
                }, 5000);

            })
            .always(function(data) {
                console.log("complete");
            });

          }else{
                $('.video-message').empty();
                $('.video-message').show();
                $('.video-message').addClass('alert alert-danger');
                $('.video-message').append('Please enter valid youtube url link.');

                setTimeout(function() {
                    $('.video-message').fadeOut();
                }, 5000);
          }
    });


/* video addded from add guide */

$(document).on('submit', '#addVideoForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var url = $('#url').val();
        var regx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
        var match = url.match(regx)
        if (match && match[1].length == 11) {
          var _data = $(this).serialize();
          // alert(_data);
                    $('#addVideoForm').trigger('reset');


        $.ajax({
            url: base_url + '/guide/videos/upload',
            method: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                console.log(data.success);
                console.log(data.stat);
                console.log(data.html);
                $('.loader-overlay').hide();
                    //$("#settings").load(window.location + "#settings");
                    $('.close').trigger('click');
                     $('#failedmsg').empty();
                     $('#recovery-form').hide();
                    $('#successimgupload').hide();
                    $('#failedmsg').show();
                    $('#failedmsg').addClass('alert alert-success');
                    $('#failedmsg').append(data.success);
                    $('#displayvideo').html(data.html);


            })
            .fail(function(jqXHR, textStatus, errorThrown ) {
                $('.loader-overlay').hide()
                $('.video-message').empty();
                $('.video-message').show();
                $('.video-message').addClass('alert alert-danger');
                $('.video-message').append(errorThrown);

                setTimeout(function() {
                    $('.video-message').fadeOut();
                }, 5000);

            })
            .always(function(data) {
                console.log("complete");
            });

          }else{
                $('.video-message').empty();
                $('.video-message').show();
                $('.video-message').addClass('alert alert-danger');
                $('.video-message').append('Please enter valid youtube url link.');

                setTimeout(function() {
                    $('.video-message').fadeOut();
                }, 5000);
          }
    });

/* license upload */


$(document).on('submit', '#mylicenseForm', function(event) {
    event.preventDefault();
    var formData = new FormData($("#mylicenseForm")[0]);
    if ($("#can_certify_guide").attr('data-can') == "true") {
        $.ajax({
            url: base_url + '/admin/access/update/certification',
            type: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
        })
            .done(function(data) {
                console.log(data.success);
              console.log("Data::"+data.html);
                $('input[name="id"]').attr('value',data.user_id);
                            $('.imglicloader').hide();
                            $('#userimage').show();
                            $('#uservideos').show();
                            $('#userbooking').show();
                            $('#userlicense').show();
                            $('#successmsg').hide();
                            $('#successimgupload').hide();
                            $('#failedmsg').empty();
                            $('#failedmsg').show();
                            $('#failedmsg').addClass('alert alert-success');
                            $('#failedmsg').append(data.success);
                            $(window).scrollTop('#failedmsg');
                            })
            .fail(function(jqXHR, textStatus, errorThrown ) {
              var errors = jqXHR.responseJSON;
              var errorsHtml= '';
              $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value[0] + '</p>';
            });

                console.log(errorsHtml);
                            $('#userimage').hide();
                            $('.imglicloader').hide();
                            $('#uservideos').hide();
                            $('#userbooking').hide();
                            $('#userlicense').hide();
                            $('#successmsg').hide();
                            $('#successimgupload').hide();
                            $('#failedmsg').empty();
                            $('#failedmsg').addClass('alert alert-danger');
                            $('#failedmsg').append(errorsHtml);
                            $('#failedmsg').show();
                            $(window).scrollTop('#failedmsg');
              });
    } else {
        alert("You must provide at least one license proof, the only you may certify user.");
    }
});


     /*-----set uploaded pic as profile form backend js--------------*/
$(document).on('submit', '#gallerySetProfileForm', function(event) {
  event.preventDefault();

 var _data = $(this).serialize();
 var path = $('input[name=status]:checked', '#gallerySetProfileForm').val();
 var user_id = $('input[name=status]:checked', '#gallerySetProfileForm').attr('data-userid');
 console.log(user_id);
 console.log(path);
 $.ajax({
            url: base_url + '/admin/access/update/profile',
            type: 'POST',
            dataType: 'json',
            data: {path: path, user_id: user_id},
        })

          .done(function(data) {
                console.log(data.success);
                            $('.imglicloader').hide();
                            $('#userimage').show();
                            $('#uservideos').show();
                            $('#userbooking').show();
                            $('#userlicense').show();
                            $('#failedmsg').hide();
                            $('#successimgupload').hide();
                            $('#successmsg').empty();
                            $('#successmsg').show();
                            $('#successmsg').addClass('alert alert-success');
                            $('#successmsg').append(data.success);
                            $(window).scrollTop('#successmsg');
                            $('.profile-avatar').attr('src',path );
                        })
            .fail(function(jqXHR, textStatus, errorThrown ) {
              var errors = jqXHR.responseJSON;
              var errorsHtml= '';
              $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value[0] + '</p>';
            });

                console.log(errorsHtml);
                            $('#userimage').hide();
                            $('.imglicloader').hide();
                            $('#uservideos').hide();
                            $('#userbooking').hide();
                            $('#userlicense').hide();
                            $('#successmsg').hide();
                            $('#successmsg').empty();
                            $('#successmsg').addClass('alert alert-danger');
                            $('#successmsg').append(errorsHtml);
                            $('#successmsg').show();
                            $(window).scrollTop('#successmsg');
              });

});


$(document).on('click','#galleryDeleteButton',function(){
    var bol = confirm('Are you sure you want to delete this item?');
    if(bol == false){
        return;
    }
    var id = $(this).attr('data-imgid');
    var userid = $(this).attr('data-userid');
    console.log(userid);
    console.log(id);

    $.ajax({
            url: base_url + '/guide/gallery/delete',
            type: 'POST',
            dataType: 'json',
            data: {id: id, user_id: userid},
        })
            .done(function(data) {
                console.log(data.success);
              console.log("Data::"+data.html);
                $('#successmsg').hide();
                $('#successimgupload').hide();
                $('#successimgupload').hide();
                $('#failedmsg').empty();
                $('#failedmsg').removeClass('alert-success');
                $('#failedmsg').addClass('alert alert-danger');
                $('#failedmsg').append(data.success);
                $('#failedmsg').show();
                $('#galleryshow').html(data.html);
            })

            .fail(function(jqXHR, textStatus, errorThrown ) {
              var errors = jqXHR.responseJSON;
              var errorsHtml= '';
              $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value[0] + '</p>';
            });

                console.log(errorsHtml);
                            $('#userimage').hide();
                            $('#uservideos').hide();
                            $('#userbooking').hide();
                            $('#userlicense').hide();
                            $('#successmsg').hide();
                            $('#failedmsg').empty();
                            $('#failedmsg').addClass('alert alert-danger');
                            $('#failedmsg').append(errorsHtml);
                            $('#failedmsg').show();
                            $(window).scrollTop('#failedmsg');
              });
})
//select otherGuide area
    $('#target').change(function() {
        //var selected = $(this).find(':selected').val()
$('#onchangehide').hide();
        var values = $(this).val()
        console.log(values);


        $.ajax({
            url: base_url + '/guide/get/otherGuidearea?selected='+values,
            type: 'POST',
            dataType: 'json',
            data: values,
            headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
        })
            .done(function(data) {

                console.log(data.success);
              console.log("Data::"+data.html);
              //console.log(response);
                            $('#successmsg').hide();
                            $('#successimgupload').hide();
                            $('#successimgupload').hide();
                            $('#failedmsg').empty();
                            $('#failedmsg').removeClass('alert-success');
                            $('#failedmsg').addClass('alert alert-danger');
                            //$('#failedmsg').append(data.success);
                            //$('#failedmsg').show();
                            $('#otherguidearea').html(data.html);
                   // $("#settings").load(window.location + "#settings");
                    //location.reload();


            })

});

});


