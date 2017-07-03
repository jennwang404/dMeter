function day_function() {
	document.getElementById('day').style.display = 'block';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'none';
}

function week_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'block';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'none';
}

function month_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'block';
	document.getElementById('year').style.display = 'none';
}

function year_function() {
	document.getElementById('day').style.display = 'none';
	document.getElementById('week').style.display = 'none';
	document.getElementById('month').style.display = 'none';
	document.getElementById('year').style.display = 'block';
}
