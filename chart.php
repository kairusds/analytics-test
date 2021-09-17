<?php

require_once "db.php";
require_once "country.php";

$res = query($dbconn, "SELECT * FROM bbl_analytics");

$devices = [];
$regions = [];
$android_versions = [];
while($row = mysqli_fetch_assoc($res)){
	$device = $row["device_model"];
	$region = iso_country_name($row["region"]);
	$android_ver = $row["android_version"];

	if(!isset($devices[$device])) $devices[$device] = 0;
	$devices[$device]++;

	if(!isset($regions[$region])) $regions[$region] = 0;
	$regions[$region]++;

	if(!isset($android_versions[$android_ver])) $android_versions[$android_ver] = 0;
	$android_versions[$android_ver]++;
}

function print_array($arr = ["null", "null"]){
	$x = 0;
	$str = "";
	foreach($arr as $key => $val){
		$str .= "[\"{$key}\", $val]";
		$x++;
		if($x < count($devices)) $str .= ",";
	}
	return $str;
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
				const devicesData = google.visualization.arrayToDataTable([
					["Device Models", "Popularity"],<?php echo print_array($devices); ?>
				]);
				const regionsData = google.visualization.arrayToDataTable([
					["Regions", "Popularity"],<?php echo print_array($regions); ?>
				]);
				const androidVersionsData = google.visualization.arrayToDataTable([
					["Android Versions", "Popularity"],<?php echo print_array($android_versions); ?>
				]);

				const $ = (selector) => document.querySelector(selector);

				const devicesChart = new google.visualization.PieChart($("#devices-chart"));
				const regionsChart = new google.visualization.GeoChart($("#regions-chart"));
				const androidVersionsChart = new google.visualization.Bar($("#android-versions-chart"));

				devicesChart.draw(devicesData, {title: "Device Models"});
				regionsChart.draw(regionsData, {});
				androidVersionsChart.draw(androidVersionsData, {title: "Android Versions"});
			}
		</script>
	</head>
	<body>
		<?php
		var_dump($devices);
		var_dump($regions);
		var_dump($android_versions);
		?>
		<div id="devices-chart"></div>
		<div id="regions-chart"></div>
		<div id="android-versions-chart"></div>
	</body>
</html>