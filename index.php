<?php 

//************************************LE ROUTEUR***************************************
//dans ce fichier on va creer le routeur. Le fichier de routage va permettre la reconnaissance des requete faites par lutilisateur via l'URL
session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));// je défini ma constante url et je remplace ma seule route qui est index.php par du vide et je vais recomposer lensemble de mon chemin. isset($_SERVER['HTTPS']) ? "https" : "http" condition ternaire

require_once "controllers/livresControllers.controller.php";
$livreController = new LivresController; //jinstancie mon controlleur de livre afin de pouvoir appeler les fonction presente dans le controlleur de livre

try{
if(empty($_GET['page'])){


require "views/accueil.view.php";

}else{

    //je vais recomposer l'url pr gerer lensemble de mes routes sur le site

    $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL); // je vais decomposer la partie page= qui va contenir plusieurs elements separés par des slash pr justement avoir les informations dans lurl

    switch($url[0]){ //jaurai dans lurl index.php?page=accueil oder livre
        case "accueil": require "views/accueil.view.php";
        break;

        case "livres": //retourner les resultats du controlleur à lutilisateur //Ici jappelle la fonction afficher livre presente dans le controlleur de livre. si jai le mot livres dans l'url alr jaffiche cette page ci
        if(empty($url[1])){
            $livreController->afficherLivres(); 
        } 
        
        else if($url[1] === "l"){
            $livreController->afficherCeLivre($url[2]);//afficher un seul livre
        }

        else if($url[1] === "a"){
            $livreController->ajoutLivre();//je vais créer cette function dans livresController.controller.php
        }

        else if($url[1] === "m"){
           $livreController->modificationLivre($url[2]);//appeler une fonction du controller
        }

        else if($url[1] === "s"){
            $livreController->suppressionLivre($url[2]);
        }

        else if($url[1] === "av"){ //traiter la route
            $livreController->ajoutLivreValidation(); 
        }

        else if($url[1] === "mv"){ //traiter la route
            $livreController->modificationLivreValidation(); 
        }

        else {
            throw new Exception("La page n'existe pas");
        }
        break;
        default : throw new Exception("La page n'existe pas");
    }

}
}

catch(Exception $e){
    $msg = $e->getMessage();
    require "views/error.view.php";
}



?>