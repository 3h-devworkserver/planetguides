$(document).ready(function(){
  

  $(document).on('submit', '#mybookingForm', function(event) {
        event.preventDefault();
    
 var _data = $(this).serialize();
 var data = $(this).val();
 var dates = $('#simpliest-usage').multiDatesPicker('getDates');
 console.log(_data);
 console.log(dates);
 console.log(data);
 // var formdata = new FormData();
 //  formdata.append('id', id);
 //  formdata.append(dates);
 $.ajax({
            url: base_url + '/admin/access/booking/availability',
            type: 'POST',
            dataType: 'json',
            data: {dates: dates, id: _data},
        })

          .done(function(data) {
                console.log(data.success);
                            $('.imglicloader').hide();
                            $('#userimage').show();
                            $('#uservideos').show();
                            $('#userbooking').show();
                            $('#userlicense').show();
                            $('#successmsg').hide();
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
                            $('#failedmsg').empty();
                            $('#failedmsg').addClass('alert alert-danger');
                            $('#failedmsg').append(errorsHtml);
                            $('#failedmsg').show();
                            $(window).scrollTop('#failedmsg');
              });
   
});
//edit from backedn

  $(document).on('submit', '#mybookingEditForm', function(event) {
  // alert("here");
  console.log("no data here");
        event.preventDefault();
    
 var _data = $(this).serialize();
 var data = $(this).val();
 var dates = $('#simpliest-usage').multiDatesPicker('getDates');
 console.log(_data);
 console.log(dates);
 console.log(data);
 // var formdata = new FormData();
 //  formdata.append('id', id);
 //  formdata.append(dates);
 $.ajax({
            url: base_url + '/admin/access/booking/editavailability',
            type: 'POST',
            dataType: 'json',
            data: {dates: dates, id: _data},
        })

          .done(function(data) {
                console.log(data.success);
                            $('.imglicloader').hide();
                            $('#userimage').show();
                            $('#uservideos').show();
                            $('#userbooking').show();
                            $('#userlicense').show();
                            $('#successmsg').empty();
                            $('#successmsg').show();
                            $('#successmsg').addClass('alert alert-success');
                            $('#successmsg').append(data.success);
                            $(window).scrollTop('#successmsg');
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


  


});