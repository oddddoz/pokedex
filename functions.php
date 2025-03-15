<?php
require 'api.php';

function reset_db() {
	$db = connect_to_db();
	$sql = file_get_contents("pokemons.sql");

	try {
		$db->exec($sql);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		die();
	}

	return;
}

function connect_to_db() {
	try {
		$db = new PDO("mysql:host=mysql-container;dbname=testdb", "user", "password");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
		die();
	}
	
	return $db;
}

function get_pokemons($db): array {
	$query = $db->query("SELECT * FROM pokemons ORDER BY id");
	$results = $query->fetchAll();

	$pokemons = [];
	foreach ($results as $pokemon) {
		$pokemons[$pokemon["id"]] = $pokemon;
	}
	
	return $pokemons;
}

function get_pokemon($name, $db) {
	$query = $db->prepare("
		SELECT * FROM pokemons
		INNER JOIN pokemons_details
		ON pokemons.id = pokemons_details.pokemon_id
		WHERE name = :name
	");
	$query->execute(["name" => $name]);

	$pokemon = $query->fetch();

	return $pokemon;
}

function add_pokemon($name, $db) {
	try {
		$pokemon = retrieve_pokemon_data($name);
		
		try {
			$query = $db->prepare("INSERT INTO pokemons (id, name, type1, type2, img_url) VALUES (:id, :name, :type1, :type2, :img_url)");
			$query->execute([
				"id" => $pokemon["id"],
				"name" => $pokemon["name"],
				"type1" => $pokemon["type1"],
				"type2" => $pokemon["type2"],
				"img_url" => $pokemon["img_url"]
			]);

			add_pokemon_details($pokemon, $db);
		} catch (PDOException $e) {
			return "Pokemon already exists";
		}
	
	} catch (\Throwable $th) {
		return "Pokemon not found";
	}
}

function measurments_to_float($measurment) {
	// "1,5 m" -> 1.5 or "4,5 kg" -> 4.5
	return (float) str_replace(",", ".", explode(" ", $measurment)[0]);
}

function add_pokemon_details($pokemon, $db) {
	$query = $db->prepare("INSERT INTO pokemons_details (pokemon_id, height, weight, hp, atk, def, spe_atk, spe_def, speed) VALUES (:pokemon_id, :height, :weight, :hp, :atk, :def, :spe_atk, :spe_def, :speed)");
	try {
		$query->execute([
			"pokemon_id" => $pokemon["id"],
			"height" => measurments_to_float($pokemon["height"]),
			"weight" => measurments_to_float($pokemon["weight"]),
			"hp" => $pokemon["hp"],
			"atk" => $pokemon["atk"],
			"def" => $pokemon["def"],
			"spe_atk" => $pokemon["spe_atk"],
			"spe_def" => $pokemon["spe_def"],
			"speed" => $pokemon["speed"]
		]);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		die();
	}
}

function delete_pokemon($name, $db) {
	$query = $db->prepare("DELETE FROM pokemons WHERE name = :name");
	$query->execute(["name" => $name]);
}

function update_nickname($name, $nickname, $db) {
	$query = $db->prepare("UPDATE pokemons SET nickname = :nickname WHERE name = :name");
	$query->execute([
		"nickname" => $nickname,
		"name" => $name
	]);
}

function display_pokemon_table_row($pokemon) {
	$id = $pokemon["id"];
	$img_url = $pokemon["img_url"];
	$name = $pokemon["name"];
	$type1 = $pokemon["type1"];
	$type2 = $pokemon["type2"];

	echo "<tr>";
	echo "<td>
		<a href='pokemon.php?name=" . $name . "'>
		<img src='$img_url' alt='" . $name . "'></td></a></td>";
	echo "<td><a href='pokemon.php?name=" . $name . "'>" . $name . "</a></td>";
	echo "<td>";
	echo "<span class='type " . $type1 . "'>" . $type1 . "</span>";
	if ($type2) {
		echo "<span class='type " . $type2 . "'>" . $type2 . "</span>";
	}
	echo "</td>";
	echo "<td>
		<form action='index.php' method='post'>
			<input type='hidden' name='delete' value='" . $id . "'>
			<button type='submit'>Delete</button>
		</form>";
	echo "</tr>";
}

function display_pokemon_details() {
	// TODO: 
}
?>
