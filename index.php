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
                    $pokemons = getPokemons();

                    foreach ($pokemons as $pokemon) {
                        echo "<tr>";
                        echo "<td><img src='https://img.pokemondb.net/sprites/home/normal/" . strtolower($pokemon[0]) . ".png' alt='" . $pokemon[0] . "'></td>";
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
                <tr>
                    <td><img src="https://img.pokemondb.net/sprites/home/normal/squirtle.png" alt="Squirtle"></td>
                    <td>Squirtle</td>
                    <td><span class="type water">Water</span></td>
                </tr>
            </tbody>
        </table>
        <form class="add-pokemon" action="index.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">

            <button type="submit">Add Pokemon</button>
        </form>
    </div>
    <?php
        require 'pokemons.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $add_pokemon_msg = addPokemon(
                $_POST["name"],
                $_POST["type1"],
                $_POST["type2"],
                $_POST["level"]
            );
        } 
        ?>

        
</body>
</html>
