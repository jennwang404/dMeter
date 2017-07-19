<?php
    $username = ""; 
    $password = "";   
    $host = "localhost";
    $database="dMeter";
    $secondGraph = "temperature";
	if (isset($_GET["secondGraph"])){
		$secondGraph = $_GET["secondGraph"];
	}
	
    $conn = new mysqli($host, $username, $password, $database);
	
	$sql = "SELECT SUM(EnergyUse) AS EnergyUse, AVG(temp) AS Temp, YEAR(t.day) AS Year FROM energy_usage e INNER JOIN $secondGraph t on DAY(t.day) = DAY(e.day) AND MONTH(t.day) = MONTH(e.day) AND YEAR(t.day) = YEAR(e.day)+9 GROUP BY YEAR(t.day)";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$all_rows = $result->fetch_all(MYSQLI_ASSOC);
		$all_rows = json_encode($all_rows);
		print ($all_rows);
	}
?>