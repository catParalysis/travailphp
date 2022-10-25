<?php
//  Formulaire de création assez simple! difficile d'en dire plus...
 echo "<form class='formModif' method='POST' action='index.php'><P>Titre de l'article :</P><INPUT type='text' size='45' name='titre' value='Entrez votre titre ici...'><br><P>Texte de l'article :</P><br><textarea name='texte' rows=10 cols=70>Votre texte ici...</textarea><br><br><INPUT type='hidden' name='idAuteur' value='" . $_SESSION["usager"] . "'><input type='hidden' name='command' value='CreationTermine'><input type='submit' value='Créer'></form>";

?>