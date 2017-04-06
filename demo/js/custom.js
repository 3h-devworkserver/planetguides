(function($) {
  jQuery.noConflict()
    $(document).ready(function() {

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
          changeMonth: true,
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

  $('.modal').on('show.bs.modal', centerModal);
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
  
  

      /*
       *  Simple image gallery. Uses default settings
       */
        $('.gallery .fancybox').fancybox();
        $('.certificate-img .fancybox').fancybox();
        $('.video .fancybox').fancybox();
        $('.profile-img .fancybox').fancybox();
        $(".video").click(function() { $.fancybox({ 'padding' : 0,'arrows':true, 'autoScale' : false, 'transitionIn' : 'none', 'transitionOut' : 'none', 'title' : this.title, 'width' : 640, 'height' : 385, 'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'), 'type' : 'swf', 'swf' : { 'wmode' : 'transparent', 'allowfullscreen' : 'true' } }); return false; });    

    });
})(window.jQuery);

/*function bannerHeight(){
    var win = $(window).height();
    $('.banner').height(win);
}*/


