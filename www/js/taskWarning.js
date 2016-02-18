$(document).ready(function() {
  $('#dateWarning').hide();
  $('#scoreWarning').hide();
	
  $('#datepicker').change(function(){
		if ($(this).val()=='') {
    		$('#dateWarning').show();
  		} 
  		else {
  			$('#dateWarning').hide();
  		}
	});

    $('input[name="maxScore"]').change(function(){
    if ($(this).val()=='' || $(this).val()==0) {
        $('#scoreWarning').show();
      } 
      else {
        $('#scoreWarning').hide();
      }
  });
});