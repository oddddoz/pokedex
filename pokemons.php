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

function addPokemon($name, $type1, $type2, $level) {
	$pokemon_exists = false;

	$pokemons = getPokemons();
	foreach ($pokemons as $pokemon) {
		if ($pokemon[0] == $name) {
			$pokemon_exists = true;
			break;
		}
	}

	if ($pokemon_exists) {
		return "Pokemon already exists";
	}

	$file = fopen("pokemons.csv","a");

	fputcsv($file, [$name, $type1, $type2, $level]);

	fclose($file);
}
?>
