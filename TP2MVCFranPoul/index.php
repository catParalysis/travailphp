<?php
    // ouverture de session
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
    //le coeur du controlleur
    switch($command)
    {   
        // accueil
        case "Accueil":

            $donnees["titre"] = "Accueil";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/grosseFace.php");
            require_once("vues/footer.php");
            break;
        // login
        case "Login":

            $donnees["titre"] = "Login";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require("vues/login.php");
            require("vues/grosseFace.php");
            require_once("vues/footer.php");
            break;

        // logout
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
        
        //affichage et données pour la page 
        case "Affichage":

            $donnees["titre"] ="affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;
        //la function supprimer pour enlever un article a la fois et le message pour la suppression
        case "Supprimer":
            // VERIFLOGIN cette fonction est au début de chacune des commandes qui pourrais etre utilisé par quelqu'un qui contourne par l'url, donc elle sert de premiere ligne de défence...
            verifLogin();
            if(isset($_REQUEST["idArticle"]))
            {
            $id = $_REQUEST["idArticle"];
            }
            supprimerArticle($id);
            $donnees["msg"] = "Article Supprimé";
            $donnees["titre"] ="Affichage";
            $donnees["articles"] = affichage();
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/affichage.php");
            require_once("vues/footer.php");
            break;
        // la function modifier, c'est assez semblable au autres je vérifie
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
        // création de l'article avec une verif login encore 
        case "Creation":

            verifLogin();
            $donnees["titre"] = "Création";
            require_once("vues/header.php");
            require_once("vues/navigation.php");
            require_once("vues/form_recherche.html");
            require_once("vues/form_creation.php");
            require_once("vues/footer.php");
            break;
        // on envois les données recueillies dans la création vers la function qui inserera la table dans la DB
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
        //  function de recheche qui cheche dans les articles , titres, auteur et textes
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