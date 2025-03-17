<!DOCTYPE html>
<?php
require 'functions.php';

$name = $_GET["name"];

$db = connect_to_db();
$pokemon = get_pokemon($name, $db);

?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de <?= htmlspecialchars($pokemon["name"]) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pokedex">
        <h1><?= htmlspecialchars($pokemon["name"]) ?><?= $pokemon["nickname"] ? " (" . htmlspecialchars($pokemon["nickname"]) . ")" : "" ?></h1>

		<form action="actions/update_pokemon_nickname.php" method="POST" class="nickname-form">
			<input type="hidden" name="name" value="<?= htmlspecialchars($pokemon['name']) ?>">
			
			<label for="nickname">Surnom :</label>
			<input type="text" id="nickname" name="nickname" 
				   value="<?= htmlspecialchars($pokemon['nickname'] ?? '') ?>" 
				   placeholder="Ajouter un surnom">
			
			<button type="submit">Enregistrer</button>
		</form>
        <img src="<?= htmlspecialchars($pokemon["img_url"]) ?>" alt="Image de <?= htmlspecialchars($pokemon["name"]) ?>" id="main_img">	
        <div class="types">
            <span class="type <?= htmlspecialchars($pokemon["type1"]) ?>"><?= htmlspecialchars($pokemon["type1"]) ?></span>
            <?php if ($pokemon["type2"]): ?>
                <span class="type <?= htmlspecialchars($pokemon["type2"]) ?>"><?= htmlspecialchars($pokemon["type2"]) ?></span>
            <?php endif; ?>
        </div>
        <table>
            <tr>
                <th>Hauteur</th>
                <td><?= htmlspecialchars($pokemon["height"]) ?> m</td>
            </tr>
            <tr>
                <th>Poids</th>
                <td><?= htmlspecialchars($pokemon["weight"]) ?> kg</td>
            </tr>
            <tr>
                <th>PV</th>
                <td><?= htmlspecialchars($pokemon["hp"]) ?></td>
            </tr>
            <tr>
                <th>Attaque</th>
                <td><?= htmlspecialchars($pokemon["atk"]) ?></td>
            </tr>
            <tr>
                <th>Défense</th>
                <td><?= htmlspecialchars($pokemon["def"]) ?></td>
            </tr>
            <tr>
                <th>Attaque Spéciale</th>
                <td><?= htmlspecialchars($pokemon["spe_atk"]) ?></td>
            </tr>
            <tr>
                <th>Défense Spéciale</th>
                <td><?= htmlspecialchars($pokemon["spe_def"]) ?></td>
            </tr>
            <tr>
                <th>Vitesse</th>
                <td><?= htmlspecialchars($pokemon["speed"]) ?></td>
            </tr>
        </table>
        <a href="index.php" class="back-button">Retour à la liste</a>
    </div>
</body>
</html>

