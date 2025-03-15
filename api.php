<?php

function retrieve_pokemon_data($name) {
	$url = "https://tyradex.app/api/v1/pokemon/" . $name;
	$options = [
		"http" => [
			"header" => "Content-Type: application/json\r\n" .
				"cache-control: no-cache\r\n",
			"method" => "GET"
		],
		"ssl" => [
			"verify_peer" => false,
			"verify_peer_name" => false
		]
	];

	$context = stream_context_create($options);
	$response = file_get_contents($url, false, $context);

	$data = json_decode($response, true);

	if (!isset($data["pokedex_id"])) {
		throw new Exception("Pokemon not found");
	}
	
	return parse_pokemon_data($data);
};

function parse_pokemon_data($data) {
	return [
		"id" => $data["pokedex_id"],
		"name" => $data["name"]["fr"],
		"img_url" => $data["sprites"]["regular"],
		"type1" => $data["types"][0]["name"],
		"type2" => $data["types"][1]["name"] ?? NULL,

		"height" => $data["height"],
		"weight" => $data["weight"],

		"hp" => $data["stats"]["hp"],
		"atk" => $data["stats"]["atk"],
		"def" => $data["stats"]["def"],
		"spe_atk" => $data["stats"]["spe_atk"],
		"spe_def" => $data["stats"]["spe_def"],
		"speed" => $data["stats"]["vit"]
	];
} 
