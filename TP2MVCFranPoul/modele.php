<?php

// webdev
/*
    define("SERVER", "localhost");
    define("USERNAME", "e2194690");
    define("PASSWORD", "1GRXSCzxK04Oyeu4gQdQ");
    define("DBNAME", "e2194690");
*/
    
// ecole mamp // maison Wamp     
/* define("SERVER", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DBNAME", "e2194690"); */

//XAMPP
    define("SERVER", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "e2194690"); 

//connexion a la db

function connectDB()
{

    $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

    if (!$c) {
        die("Erreur de connexion. MySQLI : " . mysqli_connect_error());
    }

    mysqli_query($c, "SET NAMES 'utf8'");

    return $c;
}


$connexion = connectDB();


// login encrypté, encore une fois c'est pas moi le génie la dedans haha, mais je pense l'utilise a bonne et du forme

function loginEncrypte($username, $password)
{
    global $connexion;
    $requete = "SELECT * FROM usagers WHERE username=?";

    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {

        mysqli_stmt_bind_param($reqPrep, "s", $username);

        mysqli_stmt_execute($reqPrep);
        $resultats = mysqli_stmt_get_result($reqPrep);


        if (mysqli_num_rows($resultats) > 0) {
            $rangee = mysqli_fetch_assoc($resultats);
            $motDePasseEncrypte = $rangee["password"];
            if (password_verify($password, $motDePasseEncrypte)) {
                //on est authentifié
                return $rangee["username"];
            } else
                return false;
        } else {
            return false;
        }
    }
}

// function logout que tu nous a montré

function logout()
{
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

// function d'affichage assez simple comme select

function affichage()
{

    global $connexion;
    $requete = "SELECT id, idAuteur, titre, texte FROM articles";

    $resultats = mysqli_query($connexion, $requete);

    return $resultats;
}

// funciton creation article, vue que j'insère j'ai décidé d'y aller avec les requêtes préparés

function creationArticle($idAuteur, $titre, $texte)
{

    global $connexion;

    $requete = "INSERT INTO articles(idAuteur, titre, texte) VALUES (?, ?, ?)";
    $reqPrep = mysqli_prepare($connexion, $requete);
    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "sss", $idAuteur, $titre, $texte);

        return mysqli_stmt_execute($reqPrep);
    } else
    var_dump($idAuteur);
    var_dump($titre);
    var_dump($texte);
        die("Erreur de requête préparée...");
}

// modification d'article celle la c'est celle que j'ai décidé de mettre le paquet pour éviter que quelqu,un s'en serve avec l'url. la fonction elle meme redirige si l'usager n'est pas le bon

function modifieArticle($idUsager, $idAuteur, $id, $titre, $texte)
{
    global $connexion;
    if($idUsager !== $idAuteur)
    {
        header('Location: index.php?command=Accueil');
    }

    $requete = "UPDATE articles SET titre=?, texte=? WHERE id=?";
    $reqPrep = mysqli_prepare($connexion, $requete);
    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "ssi", $titre, $texte, $id);

        return mysqli_stmt_execute($reqPrep);
    } else
        die("Erreur de requête préparée...");
}


// function delete,, encore une fois avec une req prep

function supprimerArticle($id)
{
    global $connexion;

    $requete = "DELETE FROM articles WHERE id=?";
    $reqPrep = mysqli_prepare($connexion, $requete);
    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "i", $id);

        return mysqli_stmt_execute($reqPrep);
    } else
        die("Erreur de requête préparée...");
}

// ici c'est pour la modification de l'article, je ne fetch qu'un seul article et si la personne y a acces c'est qu'elle est deja connecté

function afficheArticleSeul($id)
{
    global $connexion;

    $requete = "SELECT id, idAuteur, titre, texte FROM articles WHERE id=$id";

    $resultats = mysqli_query($connexion, $requete);

    return $resultats;
}

// ici c'est pour eviter de répéter ces instructions a chaques fois que je voulais empêcher quelqu'un de passer par l'url

function verifLogin(){
    if (!isset($_SESSION["usager"])) {
        header('Location: index.php?command=Accueil');
    }
}

// function de recherche, je me suis inspiré de ma function pour l'exercice de ligue.. 

function rechercheArticle($key){
    
    global $connexion;
    
    $requete = "SELECT id, idAuteur, titre, texte FROM articles WHERE titre LIKE ? OR texte LIKE ? OR idAuteur LIKE ?";

    $reqPrep = mysqli_prepare($connexion, $requete);
    if ($reqPrep) {
        $keyPrete = "%" . $key . "%";
        mysqli_stmt_bind_param($reqPrep, "sss", $keyPrete, $keyPrete, $keyPrete);
        mysqli_stmt_execute($reqPrep);  
        return mysqli_stmt_get_result($reqPrep);
    }
    else
        die("Erreur dans la requête....");
}

?>