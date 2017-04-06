$(document).ready(function() {

//edit address form------------------------------------------------------------------
$('#editAddr').click(function()
{
    $('#textWrapperAddr').hide();
    $('#editAddr').hide();
    $('#editInputAddr').show();
    $('#cancelAddr').show();
    $('#saveAddr').show();

});

$('#cancelAddr').click(function()
{

    $('#editInputAddr').hide();
    $('#cancelAddr').hide();
    $('#saveAddr').hide();
    $('#textWrapperAddr').show();
    $('#editAddr').show();

});


$(document).on('submit', '#addressForm', function(event) {
        event.preventDefault();

$('.loadingProfile').show();
 var _data = $(this).serialize();
        $.ajax({
            url: base_url + '/guide/profile/address',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                    $('.loadingProfile').hide();
                    $('#editInputAddr').hide();
                    $('#cancelAddr').hide();
                    $('#saveAddr').hide();
                    // $('#textWrapperAddr').html(data.value);
                    $('.country').html(data.country);
                    $('.state').html(data.state);
                    $('.city').html(data.city);
                    $('#textWrapperAddr').show();
                    $('#editAddr').show();
                    // console.log(data);
                }
                else{
                    $('.loadingProfile').hide();
                    console.log(data.stat);
                }
            });

});

//edit experience form------------------------------------------------------------------
$('#editExperience').click(function()
{
    $('#textWrapperExp').hide();
    $('#editExperience').hide();
    $('#editInputExp').show();
    $('#cancelExp').show();
    $('#saveExperience').show();

});

$('#cancelExp').click(function()
{

	$('#editInputExp').hide();
	$('#cancelExp').hide();
	$('#saveExperience').hide();
	$('#textWrapperExp').show();
	$('#editExperience').show();

});


$(document).on('submit', '#experienceForm', function(event) {
        event.preventDefault();
        var expreince = $('#experienceInput').val();
        	var text = /^[0-9]+$/;
        	if ((expreince != "") && (!text.test(expreince))) {
			alert("Please Enter Numeric Values Only");
            return false;
        	}
		

$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/experience',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                	$('.loadingProfile').hide();
                	$('#editInputExp').hide();
                	$('#cancelExp').hide();
					$('#saveExperience').hide();
					$('#textWrapperExp').html(data.value);
					$('#textWrapperExp').show();
					$('#editExperience').show();
                }
                else{
                	$('.loadingProfile').hide();
                	console.log(data.stat);
                }
            });


});

//edit gender form-----------------------------------------------------------------

$('#editGender').click(function()
{
	$('#textWrapperGen').hide();
	$('#editGender').hide();
	$('#editInputGen').show();
	$('#cancelGen').show();
	$('#saveGender').show();

});

$('#cancelGen').click(function()
{
	$('#editInputGen').hide();
	$('#cancelGen').hide();
	$('#saveGender').hide();
	$('#textWrapperGen').show();
	$('#editGender').show();

});

$(document).on('submit', '#genderForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/gender',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                	$('.loadingProfile').hide();
                	$('#editInputGen').hide();
                	$('#cancelGen').hide();
					$('#saveGender').hide();
                //edited by --yojan
                    var gender = data.value;
                    if (gender == 0) {
                        string = 'Male';
                    }else if(gender == 1){
                        string = 'Female';
                    }else{
                        string = 'Other';
                    }
                    $('#textWrapperGen').html(string);
					// $('#textWrapperGen').html(data.value);
					
					$('#textWrapperGen').show();
					$('#editGender').show();
                }
                else{
                	$('.loadingProfile').hide();
                	console.log(data.stat);
                }
            });


});

//Main guiding area form------------------------------------------------------------

    $('#target').change(function() {
        //var selected = $(this).find(':selected').val()
$('#onchangehide').hide();
        var values = $(this).val()
        console.log(values);


        $.ajax({
            url: base_url + '/guide/edit/otherGuidearea?selected='+values,
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

$('#MgInput').tagit({
        availableTags: guidingArea
});

$('#editMg').click(function()
{
	$('#textWrapperMg').hide();
	$('#editMg').hide();
	$('#editInputMg').show();
	$('#cancelMg').show();
	$('#saveMg').show();

});

$('#cancelMg').click(function()
{

	$('#editInputMg').hide();
	$('#cancelMg').hide();
	$('#saveMg').hide();
	$('#textWrapperMg').show();
	$('#editMg').show();

});

$(document).on('submit', '#MgForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/mguidingarea',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                console.log(data);
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                	$('.loadingProfile').hide();
                	$('#editInputMg').hide();
                	$('#cancelMg').hide();
					$('#saveMg').hide();
					$('#textWrapperMg').html(data.value);
					
					$('#textWrapperMg').show();
					$('#editMg').show();
                }
                else{
                	$('.loadingProfile').hide();
                	console.log(data.stat);
                }
            });


});

//About Me form------------------------------------------------------------

$('#editAbout').click(function()
{
	$('#textWrapperAbout').hide();
	$('#editAbout').hide();
	$('#editInputAbout').show();
	$('#cancelAbout').show();
	$('#saveAbout').show();

});

$('#cancelAbout').click(function()
{

	$('#editInputAbout').hide();
	$('#cancelAbout').hide();
	$('#saveAbout').hide();
	$('#textWrapperAbout').show();
	$('#editAbout').show();

});

$(document).on('submit', '#AboutForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/about',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                	$('.loadingProfile').hide();
                	$('#editInputAbout').hide();
                	$('#cancelAbout').hide();
					$('#saveAbout').hide();
					$('#textWrapperAbout').html(data.value);
					
					$('#textWrapperAbout').show();
					$('#editAbout').show();
                }
                else{
                	$('.loadingProfile').hide();
                	console.log(data.stat);
                }
            });


});


//Others Guiding Area-------------------------------------------------------------------------

         
    
    $('#editOg').click(function()
    {
        $('#textWrapperOg').hide();
        $('#editOg').hide();
        $('#editInputOg').show();
        $('#cancelOg').show();
        $('#saveOg').show();

    });

    $('#cancelOg').click(function()
    {

        $('#editInputOg').hide();
        $('#cancelOg').hide();
        $('#saveOg').hide();
        $('#textWrapperOg').show();
        $('#editOg').show();

    });

$(document).on('submit', '#OgForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/oguidingarea',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                    $('.loadingProfile').hide();
                    $('#editInputOg').hide();
                    $('#cancelOg').hide();
                    $('#saveOg').hide();
                    $('#textWrapperOg').html(data.value);
                    
                    $('#textWrapperOg').show();
                    $('#editOg').show();
                }
                else{
                    $('.loadingProfile').hide();
                    console.log(data.stat);
                }
            });


});

//language tag-------------------------------------------------------------------------

    
    $('#languageInput').tagit({
        availableTags: language
    });
    $('#editLang').click(function()
    {
        $('#textWrapperLang').hide();
        $('#editLang').hide();
        $('#editInputLang').show();
        $('#cancelLang').show();
        $('#saveLang').show();

    });

    $('#cancelLang').click(function()
    {

        $('#editInputLang').hide();
        $('#cancelLang').hide();
        $('#saveLang').hide();
        $('#textWrapperLang').show();
        $('#editLang').show();

    });

$(document).on('submit', '#LangForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/language',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                    $('.loadingProfile').hide();
                    $('#editInputLang').hide();
                    $('#cancelLang').hide();
                    $('#saveLang').hide();
                    $('#textWrapperLang').html(data.value);
                    
                    $('#textWrapperLang').show();
                    $('#editLang').show();
                }
                else{
                    $('.loadingProfile').hide();
                    console.log(data.stat);
                }
            });


});

//Specilization location tag-------------------------------------------------------------------------

    
    $('#languageInput').tagit({
        availableTags: language
    });
    $('#editSpe').click(function()
    {
        $('#textWrapperSpe').hide();
        $('#editSpe').hide();
        $('#editInputSpe').show();
        $('#cancelSpe').show();
        $('#saveSpe').show();

    });

    $('#cancelSpe').click(function()
    {

        $('#editInputSpe').hide();
        $('#cancelSpe').hide();
        $('#saveSpe').hide();
        $('#textWrapperSpe').show();
        $('#editSpe').show();

    });

$(document).on('submit', '#SpeForm', function(event) {
        event.preventDefault();
    
$('.loadingProfile').show();
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/profile/specilization',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
                $('.loadingProfile').hide();
                if (data.stat == 'ok'){
                    $('.loadingProfile').hide();
                    $('#editInputSpe').hide();
                    $('#cancelSpe').hide();
                    $('#saveSpe').hide();
                    $('#textWrapperSpe').html(data.value);
                    
                    $('#textWrapperSpe').show();
                    $('#editSpe').show();
                }
                else{
                    $('.loadingProfile').hide();
                    console.log(data.stat);
                }
            });


});
     
/*----------------licensse delete --------------*/

$(document).on('submit', '#licenseDeleteForm', function(event) {

        event.preventDefault();
    
 var _data = $(this).serialize();

        $.ajax({
            url: base_url + '/guide/license/deleted',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
               console.log(data);
                if (data.stat == 'ok'){
                    location.reload();
                }
                else{
                    
                    alert(data.stat);
                }

            });
}); 

/*----------------calender edite --------------*/
$(document).on('submit', '#mybookingEditForm', function(event) {
  event.preventDefault();
    
 var _data = $(this).serialize();
 var tokenData = $('#tokenData').val();
 var dates = $('#simpliest-usage').multiDatesPicker('getDates');
    console.log(_data);
    console.log(dates);
 $.ajax({
            url: base_url + '/guide/booking/editavailabilitys',
            type: 'POST',
            dataType: 'json',
            data: {dates: dates , _token:tokenData,id:_data},
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

/*----------------add guide videos delete --------------*/

$(document).on('submit', '#myvideoDeleteForm', function(event) {
        event.preventDefault();
    //$('#loader3', form).html('<img src="../../images/ajax-loader.gif" />       Please wait...');
 var _data = $(this).serialize();
 console.log(_data);

        $.ajax({
            url: base_url + '/guide/myvideos/delete',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
               console.log(data);
                if (data.stat == 'ok'){
                    location.reload();
                }
                else{
                    
                    alert(data.stat);
                }

            });

}); 


      /*
       *  Guide user edit video submit form
       */

$(document).on('submit', '#myeditVideoForm', function(event) {
        event.preventDefault();
        $('.loader-overlay').show();
        var url = $('#url').val();
        var regx = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
        var match = url.match(regx)
        if (match && match[1].length == 11) {
          var _data = $(this).serialize();
          console.log(_data);

        
        $.ajax({
            url: base_url + '/guide/video/upload',
            type: 'POST',
            dataType: 'json',
            data: _data
        })
            .done(function(data) {
               console.log(data);
                if (data.stat == 'ok'){
                    location.reload();
                }
                else{
                    
                    alert(data.stat);
                }

            });

          }
    });



});
