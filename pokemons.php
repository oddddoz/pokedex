<?php
function english_type_name($french_type_name) {
	switch (trim($french_type_name)) {
		case 'Feu':
			return 'Fire';
		case 'Eau':
			return 'Water';
		case 'Plante':
			return 'Grass';
		case 'Insecte':
			return 'Bug';
		case 'Normal':
			return 'Normal';
		case 'Poison':
			return 'Poison';
		case 'Fée':
			return 'Fairy';
		case 'Vol':
			return 'Flying';
		case 'Combat':
			return 'Fighting';
		case 'Sol':
			return 'Ground';
		case 'Roche':
			return 'Rock';
		case 'Spectre':
			return 'Ghost';
		case 'Acier':
			return 'Steel';
		case 'Psy':
			return 'Psychic';
		case 'Électrik':
			return 'Electric';
		case 'Glace':
			return 'Ice';
		case 'Dragon':
			return 'Dragon';
		case 'Ténèbres':
			return 'Dark';
		case 'Fer':
			return 'Steel';
		default:
			return $french_type_name;
			break;
	}
}

function getPokemons() {
	$pokemons = [];

	$file = fopen("pokemons.csv","r");

	while (($data = fgetcsv($file)) !== FALSE) {
		array_push($pokemons, $data);
	}

	fclose($file);
	return $pokemons;
}

function retrieve_pokemon_data($name) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://tyradex.app/api/v1/pokemon/" . $name,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		 "Content-Type: application/json",
		 "cache-control: no-cache"
		),
		CURLOPT_RETURNTRANSFER => true,
	));

	$response = curl_exec($curl);
	$data = json_decode($response, true);
	$err = $data["status"];
	if (isset($err)) {
		throw new Exception("Pokemon not found");
	}

	$name = $data["name"]["fr"];
	$img_url = $data["sprites"]["regular"];

	$types = [];
	foreach ($data["types"] as $type) {
		array_push($types, $type["name"]);		
	}
	
	return [$name, $types, $img_url];
};

function does_pokemon_exist($name) {
	$pokemons = getPokemons();

	foreach ($pokemons as $pokemon) {
		if (strtolower($pokemon[0]) == strtolower($name)) {
			return true;
		}
	}

	return false;
}

function save_pokemon_to_csv($name, $types, $img_url) {
	$file = fopen("pokemons.csv","a");

	fputcsv($file, [$name, $types[0], $types[1], $img_url]);

	fclose($file);
}

function display_pokemon_row($pokemon) {
	echo "<tr>";
	echo "<td><img src='$pokemon[3]' alt='" . $pokemon[0] . "'></td>";
	echo "<td>" . $pokemon[0] . "</td>";
	echo "<td>";
	if ($pokemon[1]) {
		echo "<span class='type " . strtolower(english_type_name($pokemon[1])) . "'>" . $pokemon[1] . "</span>";
	}
	if ($pokemon[2]) {
		echo "<span class='type " . strtolower(english_type_name($pokemon[2])) . "'>" . $pokemon[2] . "</span>";
	}
	echo "</td>";
	echo "</tr>";
}

function addPokemon($name) {
	try {
		$pokemon_exists = does_pokemon_exist($name);

		if ($pokemon_exists) {
			throw new Exception("Pokemon already exists");
		}

		list($name, $types, $img_url) = retrieve_pokemon_data($name);

		save_pokemon_to_csv($name, $types, $img_url);

	} catch (\Throwable $th) {
		// On intercepte l'exception (l'erreur) et on return son message
		return $th->getMessage();
	}
}
?>
