$('#u1003-2').click(function(){
	if ($('#u1003-2')[0].innerHTML == "GET STARTED") {
	    $('#u937-10').animate({
	      height: '250px'
	    });
	    $('#u937-10').append('<form method="post" action="">Email:  <input class="width1" type="text" name="email">  Password:  <input class="width2" type="text" name="password"><br><br>First Name:  <input class="width1" type="text" name="firstname">  Last Name:  <input class="width2" type="text" name="lastname"><br><br>NYSEG Account Number:  <input class="width1" type="text" name="nyseg"><br><br>  Home Address:  <input class="width3" type="text" name="address"><br><br>Phone Number (optional):  <input class="width1" type="text" name="phone">');
	    $('#u1003-4').animate({
	      marginLeft: '75%'
	    }, 600);
	    $('#u1003-2')[0].innerHTML = "SIGN UP";
	 } else {
	    document.forms[0].submit();
	 }
});
