<!DOCTYPE html>
<?php
    require 'functions.php';

    $err_msg = $_GET["err"] ?? null;

    $db = connect_to_db();
    $pokemons = get_pokemons($db);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="pokedex">
        <h1>Pokédex</h1>
        <form class="add-pokemon" action="actions/add_pokemon.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <button type="submit">Add Pokemon</button>
        </form>

        <?php echo isset($err_msg) ? "<p class='error'>$err_msg</p>" : "";?>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($pokemons as $name => $pokemon) {
                        display_pokemon_table_row($pokemon);
                    }

                    if (count($pokemons) == 0) {
                        echo "<tr><td colspan='3'>No pokemons found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>  
</body>
</html>
