$('#u1003-2').click(function(){
	if ($('#u1003-2')[0].innerHTML == "GET STARTED") {
		$('#message').remove();
	    $('#form').fadeIn(300);
	    $('#u1003-2').replaceWith("<p id='#u1003-2'><input id='submit' type='submit' name='submit' value='SIGN UP'></p>");
	 } else {

	}
});

$('#login-submit').hover(function(){
	$('#pop-up').show();
	$('#login-message').hide();
});

$('#u987').mouseleave(function(){
	$('#pop-up').hide();
});