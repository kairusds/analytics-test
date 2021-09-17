<?php

function iso_country_name($iso_code){
	$file = file_get_contents("countries.json");
	$countries = json_decode($file, true);

	for($i = 0; $i < count($countries); $i++){
		if($countries[$i]["Code"] == $iso_code)
			return $countries[$i]["Name"];
	}

	return null;
}