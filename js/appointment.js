var dt = (new Date().getFullYear()).toString() + ":" + (new Date().getFullYear() + 10).toString();
const booked = [new Date(2021,06,20).getTime(),new Date(2021,06,24).getTime(),new Date(2021,06,27).getTime(),new Date(2021,06,30).getTime()];

$(function() {
  $( "#datepicker" ).datepicker({
    yearRange: dt,
    changeYear: true,
    numberOfMonths: 2,
    minDate: new Date()/*,
    beforeShowDay: function(date = new Date()) {
      if($.inArray(date.getTime(),booked) > -1) {
        return [false, "disabled", "Fully booked"];
      }

      return [true, "enabled", "Available"];
    }*/
  })
  .on("change",function(){
    var selectedDate = $(this).val();
    getDate(this);
  });

  $("#clearDate").click(function() {
    $("#datepicker").val("");
    $('input[name="btnradio"]').prop('checked', false);
    $('input[name="btnradio"]').data('checked', false);
    $('#startTime').hide();
  });

  $('input[name="btnradio"]').click(function() {
      var rBtn = $(this);

      if (rBtn.data('waschecked') == true) {
          rBtn.prop('checked', false);
          rBtn.data('waschecked', false);
      }
      else {
        rBtn.data('waschecked', true);
      }
  });
});

function getDate(param) {
  fetch('Views/timeslot.php', {
    method: 'post',
    body: new URLSearchParams('term=' + param.value)
  })
  .then(res => res.json())
  .then(res => showTimeslot(res))
  .catch(e => console.error('Error: ' + e));
}

function showTimeslot(param) {
  $('.timeslot').each(function() {
    for(var a in param) {
      if(this.innerHTML === param[a]) {
        $(this).parent().hide();
      }
    }
  });
  $('#startTime').show();

  if(param.length == 18) {
    $('#notimeslot').show();
  }
  else {
    $('#notimeslot').hide();
  }
}