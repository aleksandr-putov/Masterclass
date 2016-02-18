function pwdCheck(){
	var pswd = $('input[name=newpass]').val();
	var reg = /^[a-z0-9_-]{6,18}$/i;
	var check = reg.test(pswd);
	var submitButton = document.getElementById('passChange');
	var inputColour = document.getElementById('pass');
	if (check==false){
		submitButton.disabled = true;
		inputColour.style.backgroundColor = "#ffb3b3";

	} else {
		submitButton.disabled = false;
		inputColour.style.backgroundColor = "";
	}
}


