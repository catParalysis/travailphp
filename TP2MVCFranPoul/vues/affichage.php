<?php
/* Dans la vue partielle d'affichage, je me sert de la boucle de fetching pour afficher le contenu de chacun des articles. Puis avec une conditionelle if toute simple j'ajoute un form qui permet de modifier ou supprimer si l'usager est l'auteur des articles */
while($rangee = mysqli_fetch_assoc($donnees["articles"]))
    {
        echo '<hr><div class="articles"><h4>' . htmlspecialchars($rangee["titre"], ENT_QUOTES) . "</h4><p>Écrit par : " . htmlspecialchars($rangee["idAuteur"], ENT_QUOTES)  . "</p><p>" .  htmlspecialchars($rangee["texte"], ENT_QUOTES) .  "</p>";
    if ((isset($_SESSION["usager"]) && $_SESSION["usager"] === $rangee["idAuteur"]))
    {
        echo '<form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Modifier"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Modifier"></form><form class="articleTopForm" method="POST" action="index.php"><input type="hidden" name="command" value="Supprimer"><input type="hidden" name="idArticle" value="' . $rangee["id"] . '"><input type="submit" value="Supprimer"></form></div>';
    }
    else
        echo "</div>";
    }
    ?>