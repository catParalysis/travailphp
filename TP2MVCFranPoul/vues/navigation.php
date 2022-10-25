<?php 
        echo "<nav>";
    if (!isset($_SESSION["usager"])) 
        {
        echo '<a href="index.php?command=Login">LOGIN</a>';
        echo '<a href="index.php?command=Affichage">LE BLOG</a>';
        }
        
    if(isset($_SESSION["usager"])) 
        {
        echo '<p>' . $_SESSION["usager"] . '</p>';
        echo '<a href="index.php?command=Affichage">LE BLOG</a>';
        echo '<a href="index.php?command=Creation">CRÉER UN ARTICLE</a>'; 
        echo '<a href="index.php?command=Logout">DÉCONNEXION</a>';
        }
        echo "</nav>";
    if (isset($donnees["msg"])) 
        {
            echo "<div><p><center>" . $donnees["msg"] . "<center></p></div>";
        }

    if (isset($donnees["nomUsager"])) 
        {
        echo "<h3>Merci, " . $donnees["nomUsager"] . " " ."d'être passé nous voir! n'oubliez pas d'aller voir notre page facebook!</h3>";    
        }
?>