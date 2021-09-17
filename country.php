<?php

$csv = array_map("str_getcsv", file("iso3166.csv"));

function random_country_code(){
	global $csv;
	return strtolower($csv[array_rand($csv)][0]);
}

function iso_country_name($iso_code){
	global $csv;
	foreach($csv as $line){
		if(strtolower($line[0]) == $iso_code) return $line[1];
	}

	return null;
}