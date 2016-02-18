$(document).ready(function() {
	$('select[name="rights"]').change(function(){
		if ($(this).val()=='2') {
    		$('select[name="group"]').show();
    		$('label[name="group"]').show();
  		} 
  		else {
  			$('select[name="group"]').hide();
  			$('label[name="group"]').hide();
  		}
	});
});