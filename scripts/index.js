$('#u1003-2').click(function(){
	if ($('#u1003-2')[0].innerHTML == "GET STARTED") {
		$('#message').remove();
	    $('#form').fadeIn(300);
	    $('#u1003-4').animate({
	      marginLeft: '75%'
	    }, 600);
	    //$('#u1003-2')[0].innerHTML = "SIGN UP";
	    $('#u1003-2').replaceWith("<p id='#u1003-2'><input id='submit' type='submit' name='submit' value='SIGN UP'></p>");

	 } else {

	}
});