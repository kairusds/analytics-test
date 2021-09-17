<?php

function iso_country_name($iso_code){
	$rest = file_get_contents("https://restcountries.eu/rest/v2/alpha/$iso_code");
	$api = json_decode($rest);
	return $api->name;
}