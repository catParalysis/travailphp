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
function affichage()
{

    global $connexion;
    $requete = "SELECT id, idAuteur, titre, texte FROM articles";

    $resultats = mysqli_query($connexion, $requete);

    return $resultats;
}
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
function afficheArticleSeul($id)
{
    global $connexion;

    $requete = "SELECT id, idAuteur, titre, texte FROM articles WHERE id=$id";

    $resultats = mysqli_query($connexion, $requete);

    return $resultats;
}
function verifLogin(){
    if (!isset($_SESSION["usager"])) {
        header('Location: index.php?command=Accueil');
    }
}
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