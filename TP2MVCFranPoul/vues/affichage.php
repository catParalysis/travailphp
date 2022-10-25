<?php

while($rangee = mysqli_fetch_assoc($donnees["articles"]))
    {
        echo '<div class="articles"><h4>' . htmlspecialchars($rangee["titre"], ENT_QUOTES) . "</h4><p>Écrit par : " . htmlspecialchars($rangee["idAuteur"], ENT_QUOTES)  . "</p><p>" .  htmlspecialchars($rangee["texte"], ENT_QUOTES) .  "</p>";
    if ((isset($_SESSION["usager"]) && $_SESSION["usager"] === $rangee["idAuteur"]))
    {
        echo '<form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Modifier"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Modifier"></form><form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Supprimer"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Supprimer"></form></div><hr>';
    }
    else
        echo "</div>";
    }
    ?>