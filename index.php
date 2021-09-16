<?php

require_once "db.php";

query($dbconn, insert("`bbl_analytics`", [
	"device_model" => "Redmi 7",
	"region" => "ph",
	"sdk_version" => "29"
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
				<th>Android SDK</th>
			</tr>
HTML;

$res = query($dbconn, "SELECT * FROM bbl_analytics ORDER BY id ASC");

$count_query = query($dbconn, "SELECT COUNT(*) AS total FROM bbl_analytics");
$count_res = mysqli_fetch_assoc($count_query);

if($count_res["total"] > 100){
	query($dbconn, "TRUNCATE bbl_analytics");
}

while($row = mysqli_fetch_assoc($res)){
	echo <<<HTML
			<tr>
				<td>{$row["id"]}</td>
				<td>{$row["device_model"]}</td>
				<td>{$row["region"]}</td>
				<td>{$row["sdk_version"]}</td>
			</tr>
HTML;
}

echo <<<HTML
		</table>
	</body>
</html>
HTML;