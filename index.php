<?php

require_once "db.php";
require_once "country.php";

$device_arr = ["G011A", "G011C", "G013A", "G013C", "G020A"];
$android_ver_arr = ["5.1", "6", "8", "9", "10"];

function rand_array($arr){
	return $arr[array_rand($arr)];
}

query($dbconn, insert("`bbl_analytics`", [
	"device_model" => rand_array($device_arr),
	"region" => random_country_code(),
	"android_version" => rand_array($android_ver_arr)
]));

echo <<<HTML
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
		<title>Analytics Test</title>
		<style>
			table {
				display: block;
				border-collapse: collapse;
				overflow-x: auto;
				white-space: nowrap;
			}
			table, td, th {
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<table>
			<tr>
				<th>ID</th>
				<th>Device Model</th>
				<th>Region</th>
				<th>Android Version</th>
				<th>Timestamp</th>
			</tr>
HTML;

$res = query($dbconn, "SELECT * FROM bbl_analytics ORDER BY id ASC");

$count_query = query($dbconn, "SELECT COUNT(*) AS total FROM bbl_analytics");
$count_res = mysqli_fetch_assoc($count_query);

if($count_res["total"] > 500){
	query($dbconn, "DROP TABLE IF EXISTS `{$database}`.`bbl_analytics`");
}

while($row = mysqli_fetch_assoc($res)){
	echo <<<HTML
			<tr>
				<td>{$row["id"]}</td>
				<td>{$row["device_model"]}</td>
				<td>{$row["region"]}</td>
				<td>{$row["android_version"]}</td>
				<td>{$row["date"]}</td>
			</tr>
HTML;
}

echo <<<HTML
		</table>
	</body>
</html>
HTML;