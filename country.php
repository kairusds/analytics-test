<?php

function iso_country_name($iso_code){
	$rest = file_get_contents("https://restcountries.eu/rest/v2/alpha/$iso_code");
	$country = json_decode($rest);
	return $country->name;
	/* $file = file_get_contents("countries.json");
	$countries = json_decode($file, true);

	for($i = 0; $i < count($countries); $i++){
		if(strtolower($countries[$i]["Code"]) == $iso_code)
			return $countries[$i]["Name"];
	}

	return null; */
}