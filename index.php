<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/main.css">
    <title>Document</title>
</head>
<body>
    <div class="pokedex">
        <h1>Pokédex</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require 'pokemons.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $err_msg = addPokemon($_POST["name"]);
                    }

                    $pokemons = getPokemons();

                    foreach ($pokemons as $pokemon) {
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
                ?>  
            </tbody>
        </table>
        <form class="add-pokemon" action="index.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">

            <button type="submit">Add Pokemon</button>
            </form>
            <?php
                if (isset($err_msg)) {
                    echo "<p class='error'>$err_msg</p>";
                }
            ?>
    </div>  
</body>
</html>
