<!--   ici j'ai rien inventé..... c'est exactement la meme chose que ce que tu nous a montré a peut etre une petite exception -->

<?php
    if(isset($_REQUEST["identifiant"], $_REQUEST["password"]))
    {
        $nomUsager = loginEncrypte($_REQUEST["identifiant"], $_REQUEST["password"]);
        if($nomUsager)
        {
            //nous sommes authentifiés
            $_SESSION["usager"] = $nomUsager;
            header("Location: index.php?command=Affichage");
            die();
        }
        else 
        {
            $message = "Mauvaise combinaison username / password.";
        }
    }
?>
<form method="POST">
    <label for="identifiant">Username : </label>
    <input type="text" name="identifiant"></br>
    <label for="password">Mot de passe : </label>
    <input type="password" name="password">
    <input type="submit" value="Authentification">
</form>
<?php 
    if(isset($donnees["message"]))
        echo "<p>" . $donnees["message"] . "</p>";
    ?>