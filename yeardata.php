<?php
    $username = ""; 
    $password = "";   
    $host = "localhost";
    $database="dMeter";
    
	$year = 2008;
	
    $conn = new mysqli($host, $username, $password, $database);
	
	$sql = "SELECT SUM(EnergyUse) AS EnergyUse, YEAR(Day) AS Year FROM energy_usage GROUP BY YEAR(Day)";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$all_rows = $result->fetch_all(MYSQLI_ASSOC);
		$all_rows = json_encode($all_rows);
		print ($all_rows);
	}
?>