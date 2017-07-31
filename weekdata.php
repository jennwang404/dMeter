<?php
    $username = "dmeterco"; 
    $password = "301CollegeAve#";   
    $host = "localhost";
    $database="dMeter";
	$month = 7;
	$year = 2016;
	if (isset($_GET["secondGraph"])){
		$secondGraph = $_GET["secondGraph"];
		$sql = "SELECT Energy, $secondGraph, DAY(t.day) AS Day, MONTH(t.day) AS Month, YEAR(t.day) AS Year FROM Energy_Uses e INNER JOIN $secondGraph t on t.Day = e.Day WHERE MONTH(t.day) = $month AND YEAR(t.day) = $year GROUP BY t.day";
	}
	else
		$sql = "SELECT Energy, DAY(t.day) AS Day, MONTH(t.day) AS Month, YEAR(t.day) AS Year FROM Community_Uses WHERE MONTH(t.day) = $month AND YEAR(t.day) = $year GROUP BY t.day";
	
	
    $conn = new mysqli($host, $username, $password,$database);
    
   if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
	//$sql = "SELECT * FROM dmeter.Temperature";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		print ("[");
		$i = 0;
		while($row = $result->fetch_assoc()){
			$i = $i + 1;
			//print ($rows);
			print ("{");
			print ('"Energy":');
			print ($row["Energy"]);
			print (",");
			if (isset($_GET["secondGraph"])){
				print ('"'.$secondGraph.'":');
				print ($row[$secondGraph]);
				print (",");
			}
			print ('"Day":');
			print ($row["Day"]);
			print (",");
			print ('"Month":');
			print ($row["Month"]);
			print (",");
			print ('"Year":');
			print ($row["Year"]);
			if ($i == $result->num_rows)
				print ("}");
			else
				print ("},");
		}
		print ("]");
	}
	else{
		print($sql);
	}
?>