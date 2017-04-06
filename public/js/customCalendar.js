$(document).ready(function(){
  var price = guidePrice;
  var charge = serviceCharge;
  var allBookeddates = bookedDates;
  console.log(allBookeddates);
  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
  console.log(nowTemp);
  // var checkin = 
  var checkin = $('#bookFrom').datepicker
  ({
    // format: 'yyyy-mm-dd',
    // datesDisabled: allBookeddates,
    // beforeShowDay: function(date){
    //     var formatedDate = jQuery.datepicker.formatDate('yy-mm-dd', date);
        
    //     if(date.valueOf() < now.valueOf())
    //       return false;
    //     else if(allBookeddates.indexOf(formatedDate) > -1) {
    //       return {
    //         tooltip: 'Already Booked',
    //         classes: 'red'
    //     };
    //     }
    //     else
    //       return true;
    // }
    }).on('changeDate', function(ev) {
          // if (ev.date.valueOf() > checkout.viewDate.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
            checkout.setDate(newDate);
            checkout.update();
            
          // }
          calculation();
          checkin.hide();
          $('#bookTo')[0].focus();
  }).data('datepicker');

  var checkout = $('#bookTo').datepicker({
    format: 'yyyy-mm-dd',
    datesDisabled: allBookeddates,
    beforeShowDay: function(date){
        var formatedDate = jQuery.datepicker.formatDate('yy-mm-dd', date);
        
        if(date.valueOf() < now.valueOf())
          return false;
        else if(date.valueOf() <= checkin.viewDate.valueOf())
          return false;
        else if(allBookeddates.indexOf(formatedDate) > -1) {
          return {
            tooltip: 'Already Booked',
            classes: 'red'
        };
        }
        else
          return true;
      }

  }).on('changeDate', function(ev) {
      calculation();
      checkout.hide();
  }).data('datepicker');


  
   function calculation() {
      var a = new Date($("#bookFrom").val()),
          b = new Date($("#bookTo").val()),
          c = 24*60*60*1000,
          diffDays = Math.round(Math.abs((a - b)/(c)));
          $("#totalDays").val(diffDays);
          $("#serviceFee").html(charge + '%');
          if (diffDays>=1) {
            var sum = price*diffDays;
            var total = sum+sum*(charge/100);
            $("#priceCalculation").html('$'+price+' x '+diffDays);
            $("#calculatedPrice").html('$'+sum);
            $("#totalSumPrice").html('$'+total);
            
            $(".book-it-status").show();
          }
          
      
  }



});