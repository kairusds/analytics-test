<?php

error_reporting(E_ALL);

$url = getenv("JAWSDB_URL");
$dbparts = parse_url($url);
$hostname = $dbparts["host"];
$username = $dbparts["user"];
$password = $dbparts["pass"];
$database = ltrim($dbparts["path"], "/");

$dbconn = mysqli_connect($hostname, $username, $password);

if(!$dbconn){
	die("Failed to connect to MySQL: " . mysqli_connect_error());
}
mysqli_select_db($dbconn, $database);

function query(&$conn, $sql){
	$res = null;
	try{
		$res = mysqli_query($conn, $sql);
	}catch(Exception $e){
		echo $e->getMessage();
	}
	return $res;
}

query($dbconn, "set names \"utf8\"");

$create_query = <<<SQL
CREATE TABLE IF NOT EXISTS `bbl_analytics` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `device_model` VARCHAR(50) NOT NULL,
  `region` varchar(3) DEFAULT "cn",
  `android_version` TINYINT(4) DEFAULT "1",
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE="MyISAM" DEFAULT CHARSET="utf8";
SQL;
query($dbconn, $create_query);

function compile_db_insert_string($data){
	$field_names  = "";
	$field_values = "";
	foreach ($data as $k => $v) {
		$field_names .= "{$k},";
		$field_values .= "\"{$v}\",";
	}
	$field_names  = preg_replace("/,$/", "", $field_names);
	$field_values = preg_replace("/,$/", "", $field_values);
	return [
		"FIELD_NAMES" => $field_names,
		"FIELD_VALUES" => $field_values
	];
}

function insert($tbl, $arr){
	$dba = compile_db_insert_string($arr);
	$sql = "INSERT INTO {$tbl} ({$dba['FIELD_NAMES']}) VALUES ({$dba['FIELD_VALUES']})";
	return $sql;
}