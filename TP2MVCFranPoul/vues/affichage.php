<?php

while($rangee = mysqli_fetch_assoc($donnees["articles"]))
    {
        echo '<div class="articles"><h4>' . $rangee["titre"] . "</h4><p>Écrit par : " . $rangee["idAuteur"]  . "</p><p>" . $rangee["texte"].  "</p>";
    if ((isset($_SESSION["usager"]) && $_SESSION["usager"] === $rangee["idAuteur"]))
    {
        echo '<form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Modifier"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Modifier"></form><form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Supprimer"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Supprimer"></form></div><hr>';
    }
    else
        echo "</div>";
    }

    ?>