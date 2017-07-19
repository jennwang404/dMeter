<?php
    $username = "dmeterco"; 
    $password = "301CollegeAve#";   
    $host = "https://p3plcpnl0992.prod.phx3.secureserver.net:2083";
    $database="dMeter";
    $secondGraph = "temperature";
	if (isset($_GET["secondGraph"])){
		$secondGraph = $_GET["secondGraph"];
	}
	
	$month = 7;
	$year = 2016;
	
    $conn = new mysqli($host, $username, $password, $database);
	
	$sql = "SELECT Energy, Temperature, DAY(t.day) AS Day, MONTH(t.day) AS Month, YEAR(t.day) AS Year FROM Energy_Uses e INNER JOIN $secondGraph t on t.Day = e.Day WHERE MONTH(t.day) = $month AND YEAR(t.day) = $year GROUP BY t.day";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$all_rows = $result->fetch_all(MYSQLI_ASSOC);
		$all_rows = json_encode($all_rows);
		print ($all_rows);
	}
?>