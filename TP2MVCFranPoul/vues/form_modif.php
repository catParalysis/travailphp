<?php

while($rangee = mysqli_fetch_assoc($donnees["articles"]))
{
    echo "<form class='formModif' method='POST' action='index.php'><P>Titre de l'article :</P><INPUT type='text' size='45' name='titre' value='" . $rangee["titre"] . "'><br><P>Texte de l'article :</P><br><textarea name='texte' rows=10 cols=70>" . $rangee["texte"] . "</textarea>" . "<br><input type='hidden' name='idArticle' value='" . $rangee["id"] . "'><br><INPUT type='hidden' name='idAuteur' value='" . $rangee["idAuteur"] . "'><input type='hidden' name='command' value='ModificationFaite'><input type='submit' value='Modifier'></form>";
}

?>