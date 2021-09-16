<?php

require_once "db.php";

$res = query($dbconn, "SELECT * FROM bbl_analytics");

$devices = [];
while($row = mysqli_fetch_assoc($res)){
	$device = $row["device_model"];
	if(!isset($devices[$device])) $devices[$device] = 1;
	$devices[$device]++;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
		<title>Chart Test</title>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load("current", {"packages": ["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart(){
				const data = google.visualization.arrayToDataTable([
					["Device Models", "Amount"],
					<?php
						$x = 0;
						if(empty($devices)) echo "[\"None\", 0]";
						foreach($devices as $d => $a){
							echo "[\"{$d}\", $a]";
							if($x < count($devices)) echo ",";
							$x++;
						}
					?>
				]);
				const options = {
					title: "Device Model Analytics"
				};
				const chart = new google.visualization.PieChart(document.getElementById("piechart"));
				chart.draw(data, options);
			}
		</script>
	</head>
	<body>
		<div id="piechart" style="width: 600px; height: 200px;"></div>
	</body>
</html>