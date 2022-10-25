<?php
    session_start();

    if(!isset($_REQUEST["command"])){
        header('Location: index.php?command=Accueil');
    }

    if(isset($_REQUEST["command"]))
    {
        $command = $_REQUEST["command"];
    }
    else 
    {
        $command = "Accueil";
    }
    
    require_once("modele.php");

    switch($command)
    {   
        case "Accueil":

            $donnees["titre"] = "Accueil";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/grosseFace.php");
            require_once("vues/footer.php");
            break;

        case "Login":

            $donnees["titre"] = "Login";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/login.php");
            require("vues/grosseFace.php");
            require_once("vues/footer.php");
            break;

        case "Logout":

            $donnees["titre"] = "Accueil";
            $donnees["nomUsager"] = $_SESSION["usager"];
            logout();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/grosseFace.php");
            require_once("vues/footer.php");
            break;

        case "Affichage":

            $donnees["titre"] ="affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;

        case "Supprimer":

            verifLogin();
            if(isset($_REQUEST["idArticle"]))
            {
            $id = $_REQUEST["idArticle"];
            }
            supprimerArticle($id);
            $donnees["msg"] = "Article Supprimé";
            $donnees["titre"] ="affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;

        case "Modifier":

            verifLogin();
            if(isset($_REQUEST["idArticle"]))
            {
            $id = $_REQUEST["idArticle"];
            $donnees["titre"] ="Modification";
            $donnees["articles"] = afficheArticleSeul($id);
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/form_modif.php");
            require_once("vues/footer.php");
            }
            break;

        case "ModificationFaite":

            // ici je tente une double vérification. je ne sais pas si c'est utile a ce point mais la function ne fonctionnera que si le nom Asager correspond au idAuteur. 
            
            verifLogin();
            if(isset($_REQUEST["idArticle"]) && isset($_REQUEST["titre"]) && isset($_REQUEST["texte"]) && isset($_REQUEST["idAuteur"]))
            {   
                $idAuteur = $_REQUEST["idAuteur"];
                $idUsager = $_SESSION["usager"];
                $idArticle = $_REQUEST["idArticle"];
                $titre = $_REQUEST["titre"];
                $texte = $_REQUEST["texte"];
                modifieArticle( $idUsager, $idAuteur, $idArticle, $titre, $texte);  
            }
            $donnees["msg"] = "Article Modifié";
            $donnees["titre"] ="affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;

        case "Creation":

            verifLogin();
            $donnees["titre"] = "Création";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/form_creation.php");
            require_once("vues/footer.php");
            break;

        case "CreationTermine":
            verifLogin();
            if(isset($_REQUEST["titre"]) && isset($_REQUEST["texte"]))
            {   
                $idUsager = $_REQUEST["idAuteur"];
                $titre = $_REQUEST["titre"];
                $texte = $_REQUEST["texte"];
            }
            creationArticle($idUsager, $titre, $texte);
            $donnees["msg"] = "Nouvel article créé";
            $donnees["titre"] ="Affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;
        case "Recherche":
            verifLogin();
            if(isset($_REQUEST["recherche"])){
                $key = $_REQUEST["recherche"];
            }
            $donnees["msg"] = "Voici les articles trouvés";
            $donnees["articles"] = rechercheArticle($key);
            $donnees["titre"] ="Recherche Articles";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;




    




        }


?>