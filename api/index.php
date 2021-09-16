<?php

if(!isset($_GET["page"])){
	require_once dirname(__FILE__) . "/../index.php";
}else if(isset($_GET["page"]) && $_GET["page"] == "chart"){
	require_once dirname(__FILE__) . "/../chart.php";
}