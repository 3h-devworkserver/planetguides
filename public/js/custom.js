function stickyNav() {
    var top = $(window).scrollTop();

    if (top > 80) // height of float header
        $('.navbar-fixed-top').addClass('sticky-shadow');
    else
        $('.navbar-fixed-top').removeClass('sticky-shadow');
}
function tabcollapse(){
  $('#myTab').tabCollapse({
    
});
}

$(document).scroll(function() {
    stickyNav();
})


    $(document).ready(function() {
      stickyNav();
      tabcollapse();

       /* bannerHeight();
        
        $(window).resize(function(){
            bannerHeight();
        });*/
        
           
        $( ".explore-btn" ).click(function(e) {
          $('.explore-btn').toggleClass('slideDown');
          $( ".menu" ).slideToggle( "4500", function() {});
        
        });
       // $("select").selectbox();
        $('.testselect2').SumoSelect();
        $('.SlectBox').SumoSelect();
        //alert('here');


        /* Date Selection in Search Bar
         *  for single date selection
         */
        $( "#datepicker" ).datepicker({
          showWeek: false,
          firstDay: 1,
        });
        /*for multiple date select*/
        $( "#from" ).datepicker({
          defaultDate: "+1w",
          // changeMonth: true,
          minDate: new Date(),
          todayBtn: "linked",
          numberOfMonths: 2,
          onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
          }
        });
        $( "#to" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2,
          onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
          }
        });

        /*multiple language select */
        $("#dropdownMenu2").on("click", "li a", function() {
          var platform = $(this).text();
          $("#dropdown_title2").html(platform);
        });

        /*tooltip*/
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });


 $(".thumb_carousel").owlCarousel({
    items:        4,
    itemsDesktop:     [1199,4],
    itemsDesktopSmall:  [979,3],
    itemsTablet:    [768,2],
    itemsMobile:    [479,1],
    lazyLoad:       true,
    lazyEffect:     "fade",
    touchDrag:      true,
    navigation:     true,
  });


  //Bootstrap Modal Centered
  function centerModal() {
      $(this).css('display', 'block');
      var $dialog = $(this).find(".modal-dialog");
      var offset = ($(window).height() - $dialog.height()) / 2;
      // Center modal vertically in window
      $dialog.css("margin-top", offset);
  }

  $('#signup-modal, #login-popup').on('show.bs.modal', centerModal);
  $(window).on("resize", function () {
      $('.modal:visible').each(centerModal);
  });

  //Bootstrap Modal Switching
  $("#next").click(function(){
      $('#login-popup').modal('hide');
      $('#signup-modal').modal('show');
  });

  $("#become-host").click(function(){
      $('#signup-modal').modal('hide');
      $('#host-popup').modal('show');
  });

  $("#travel").click(function(){
      $('#signup-modal').modal('hide');
      $('#travel-popup').modal('show');
  });
  $(".back").click(function(){
      
      $('#host-popup, #travel-popup').modal('hide');
      $('#signup-modal').modal('show');
  });

   $("#forgotPassword").click(function(){
      $('#login-popup').modal('hide');
      $('#recoveryModal').modal('show');
  });

    $(".backSignIn").click(function(){
      
      $('#recoveryModal').modal('hide');
      $('#login-popup').modal('show');
  });
  
  $("#loginM").click(function(){
    $('#login-popup').modal('show');
    $('input.refferer').val('review');
  });

  $("#loginModal").click(function(){
    var href = window.location.href;
    //alert(href.substr(href.lastIndexOf('/') + 1));
    $('#login-popup').modal('show');
    $('input.refferer').val(href);
    
  });

  $('#galleryCaptionEditBtn').click(function()
  {
    $(this).hide();
    $(this).parent('div.caption-area').find('#galleryCaptionEditForm').show();
  });

  $('#videoCaptionEditBtn').click(function()
  {
    $(this).hide();
    $(this).parent('div.caption-area').find('#videoCaptionEditForm').show();
  });

      /*
       *  Simple image gallery. Uses default settings
       */
        $('.gallery .fancybox').fancybox();
        $('.certificate-img .fancybox').fancybox();
        $('.video-gallery').fancybox();
        $('.profile-img .fancybox').fancybox();
       $(".video").click(function() { $.fancybox({ 'padding' : 0,'arrows':true, 'autoScale' : false, 'transitionIn' : 'none', 'transitionOut' : 'none', 'title' : this.title, 'width' : 640, 'height' : 385, 'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'), 'type' : 'swf', 'swf' : { 'wmode' : 'transparent', 'allowfullscreen' : 'true' } }); return false; });    

    });

      /*
       *  Login Modal submit
       */

$(document).on('submit', '#myLoginForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var _data = $(this).serialize();
        $.ajax({
            url: base_url + '/auth/login',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loader-overlay').hide();
                if (data.stat == 'ok'){
                    console.log(data);
                    if(data.refferer == 'review')
                        location.reload();
                    else if(data.refferer != 'review' && data.refferer){
                        
                         window.location.href = data.refferer;
                     }
                    else if(data.access==1)
                      window.location.href = base_url + '/admin/dashboard';
                    else if(data.access==2)
                      window.location.href = base_url + '/guide/profile/edit';
                    else if(data.access==3){
                       
                      window.location.href = base_url + '/traveller/dashboard';
                      
                    }
                    else
                      window.location.href = base_url;
                   
                } else {
                    $('.message-append').empty();
                    $('.message-append').show();
                    $('.message-append').addClass('alert alert-danger');
                    // $('#myLoginForm .form-group').addClass('error');
                    $('.message-append').append(data.msg);
                    setTimeout(function() {
                        $('.message-append').fadeOut();
                    }, 5000);
                }
            })
            .fail(function(data) {
              
              var errors = data.responseJSON;
              var errorsHtml= '';
            $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value[0] + '</p>'; 
            });
            
                $('.loader-overlay').hide();
                $('.message-append').empty();
                $('.message-append').show();
                $('.message-append').addClass('alert alert-danger');
                $('.message-append').append(errorsHtml);
                setTimeout(function() {
                    $('.message-append').fadeOut();
                }, 5000);
                
            })
            .always(function(data) {
                console.log("complete");
            });
    });

      /*
       *  Guide Registration submit
       */

$(document).on('submit', '#myGuideForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var _data = $(this).serialize();
        $.ajax({
            url: base_url + '/auth/guide-register',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
              console.log(data);
                $('.loader-overlay').hide();
                if (data.stat == 'ok'){
                      window.location.href = base_url + '/guide/profile';
                } 
                else if(data.stat == 'confirm'){
                    alert('An email confirmation has been sent. Please check your email.');
                } else {
                    $('.message-append').empty();
                    $('.message-append').show();
                    $('.message-append').addClass('alert alert-danger');
                    $('.message-append').append(data.msg);
                    setTimeout(function() {
                        $('.message-append').fadeOut();
                    }, 5000);
                }
            })
            .fail(function(data) {
              //document.write(data.responseText);
              console.log(data);
              var errors = data.responseJSON;
              var errorsHtml= '';
            $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value + '</p>'; 
            });
            
                $('.loader-overlay').hide();
                $('.message-append').empty();
                $('.message-append').show();
                $('.message-append').addClass('alert alert-danger');
                $('.message-append').append(errorsHtml);
                setTimeout(function() {
                    $('.message-append').fadeOut();
                }, 5000);
                
            })
            .always(function(data) {
                console.log("complete");
            });
    });


      /*
       *  Traveller Registration submit
       */
$(document).on('submit', '#myTravellerForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var _data = $(this).serialize();
        $.ajax({
            url: base_url + '/auth/traveller-register',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loader-overlay').hide();
                if (data.stat == 'ok'){
                    window.location.href = base_url + '/traveller/profile';
                }
                else if(data.stat == 'confirm'){
                  alert('An email confirmation has been sent. Please check your email.');
                } else {
                    $('.message-append').empty();
                    $('.message-append').show();
                    $('.message-append').addClass('alert alert-danger');
                    $('.message-append').append(data.msg);
                    setTimeout(function() {
                        $('.message-append').fadeOut();
                    }, 5000);
                }
            })
            .fail(function(data) {
              
              var errors = data.responseJSON;
              var errorsHtml= '';
            $.each( errors, function( key, value ) {
                errorsHtml += '<p>' + value[0] + '</p>'; 
            });
            
                $('.loader-overlay').hide();
                $('.message-append').empty();
                $('.message-append').show();
                $('.message-append').addClass('alert alert-danger');
                $('.message-append').append(errorsHtml);
                setTimeout(function() {
                    $('.message-append').fadeOut();
                }, 5000);
                
            })
            .always(function(data) {
                console.log("complete");
            });
    });

      /*
       *  Frogot password submit
       */

$(document).on('submit', '#recovery-form', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var _data = $(this).serialize();
        $.ajax({
            url: base_url + '/password/email',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loader-overlay').hide();
                if (data.stat == 'ok'){
                     $('.reset-message').empty();
                     $('#recovery-form').hide();
                    $('.reset-message').show();
                    $('.reset-message').addClass('alert alert-success');
                    $('.reset-message').append(data.msg);
                } else {
                    $('.reset-message').empty();
                    $('.reset-message').show();
                    $('.reset-message').addClass('alert alert-danger');
                    $('.reset-message').append(data.msg);
                    
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown ) {
                $('.loader-overlay').hide()
                $('.reset-message').innerHTML = "";
                $('.reset-message').show();
                $('.reset-message').addClass('alert alert-danger');
                $('.reset-message').append(errorThrown);
                
                setTimeout(function() {
                    $('.reset-message').fadeOut();
                }, 5000);
                
            })
            .always(function(data) {
                console.log("complete");
            });
    });

      /*
       *  Guide user video submit form
       */

$('#myeditVideoForm').submit(function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var url = $('#url').val();
          var _data = $(this).serialize();
          console.log(_data);

        
        $.ajax({
            url: base_url + '/guide/video/upload',
            type: 'POST',
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
    });


 //login validation 

$("#myLoginForm").validate({
    errorClass:'error',
    validClass:'success',
    highlight: function (element, errorClass, validClass) { 
      $(element).parents("div.form-group").addClass(errorClass).removeClass(validClass); 
      $(element).addClass(errorClass).removeClass(validClass); 
    }, 
    unhighlight: function (element, errorClass, validClass) { 
      $(element).parents(".error").removeClass(errorClass).addClass(validClass); 
      $(element).removeClass(errorClass).addClass(validClass); 
    },
});

//guide registration data validation
$("#myGuideForm").validate();
$("#ccForm").validate();

//traveller registration data validation
$("#myTravellerForm").validate();

//forgot password validation
$("#resetForm").validate({
  rules: {
        password: {
          required: true,
          minlength: 6
        },
        password_confirmation: {
          required: true,
          minlength: 6,
          equalTo: "#password"
        },
      }
  });

//forgot password recovery area validation
$("#recovery-form").validate({
    errorClass:'error',
    validClass:'success',
    highlight: function (element, errorClass, validClass) { 
      $(element).parents("div.forgetpasswrapper").addClass(errorClass).removeClass(validClass); 
      $(element).addClass(errorClass).removeClass(validClass); 
    }, 
    unhighlight: function (element, errorClass, validClass) { 
      $(element).parents(".error").removeClass(errorClass).addClass(validClass); 
      $(element).removeClass(errorClass).addClass(validClass); 
    },
});


//youtube video url validation

//traveller-settings validation
$("#travellerSettings").validate({
  rules: {
        old_password: {
          required: true,
        },
        password: {
          required: true,
          minlength: 6
        },
        password_confirmation: {
          required: true,
          minlength: 6,
          equalTo: "#password"
        },

      }

  });




