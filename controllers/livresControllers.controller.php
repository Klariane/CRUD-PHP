<?php 
 require_once "<models/LivreManager.class.php";

class LivresController
{
    private $LivreManager;

    public function __construct() //ce controlleur au moment de son instanciation il va lui meme creer un objet livreManager qui va appeler la fonction chargement livre presente dans le fichier livreManager.class.php
    {
        $this->LivreManager =new LivreManager; // je cree un objet livreManager
        $this->LivreManager->chargementLivres(); //je charge les livres
    }

    //pour appeler la route vers livres.view.php 

    public function afficherLivres() // ici je recupere tous mes livre que je met dans la variable $tableauDeLivre
    {
        $tableauDeLivre = $this->LivreManager->getLivres(); //je recupere tous mes livres que je mets a disposition dans ma variable $tableauDeLivre qui est affichee dans ma vue livres.view.php 
        require "views/livres.view.php"; //ces livres sont utilisé dans ma vue
    }

    public function afficherCeLivre($id)
    {
       $ceLivre= $this->LivreManager->getLivreById($id); // pour cette fonction mon controlleur a besoin de recuperer les informations du livre qu'on voudra afficher. Ce nest pas a lui de le faire, mais c'est au model (livreManager.class.php)de faire cette tâche. livreManager est disponible en tps qu'attribut de notre livreController. pour appeler le livreManager je fais $this->LivreManager et pr recuperer le livre jappelle la fonction getLivreById($id) qui est dans livreManager .je stocke le tout dans une variable $ceLivre. Je vais donc programmer la fonction getLivreById dans le model livreManager

       require "views/afficherLivre.view.php"; // je cree la vue qui va afficher le livre
    }

    public function ajoutLivre()
    {
        require "views/ajoutLivre.view.php";//apres avoir appelé la fonction dans le fichier index.php, je la crée ici
    }

    
    public function ajoutLivreValidation()
    {
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImageAjoute= $this->ajoutImage($file, $repertoire);

        $this->LivreManager->ajoutLivreBd($_POST['titre'], $_POST['nbPages'], $nomImageAjoute);

        $_SESSION['alert'] = [
            "type" => "success",
            "msg"  => "Ajout réalisé"
        ];

        header('location:' . URL . "livres");


    }

    public function suppressionLivre($id) 
    {
        $nomImage = $this->LivreManager->getLivreById($id)->getImage();//suppression de limage dans le repertoire
        unlink("public/images/".$nomImage);//suppression de limage dans le repertoire

        //suppression en base de donnée
        $this->LivreManager->suppressionLivreBD($id);

        
        $_SESSION['alert'] = [
            "type" => "success",
            "msg"  => "Suppression réalisée"
        ];

        header('location:' . URL . "livres");
    }

    public function modificationLivre($id)
    {
        //recuperer toutes les informations du livre
        $livreAModifier = $this->LivreManager->getLivreById($id);

        //jappelle la vue concernée

        require "views/modifierLivre.view.php";

    }

    public function modificationLivreValidation()//je n'ai aucune information à récupérer car tout a été transmis avec la method POST()
    {
        //je vais dans un 1er tps recuperer limage du livre quon veut modifier
        $imageActuelle = $this->LivreManager->getLivreById($_POST['identifiant'])->getImage();

        //verifier si oui ou non lutilisateur a entré une image
        $file = $_FILES['image'];


        if($file['size']  >0) //est ce que la taille de limage est > 0?
        {
            //si oui alors lutilisateur a demandé la suppression du livre
            unlink("public/images/".$imageActuelle);//suppression de limage dans le repertoire
            //je rajoute une nouvelle image
            $repertoire = "public/images/";
        $nomImageToAdd= $this->ajoutImage($file, $repertoire);
        } else
        {
            $nomImageToAdd = $imageActuelle;
        }
        //modification en BDD
        $this->LivreManager->modificationLivreBD($_POST['identifiant'], $_POST['titre'], $_POST['nbPages'], $nomImageToAdd);

        
        $_SESSION['alert'] = [
            "type" => "success",
            "msg"  => "Modification réalisée"
        ];

        header('location:' . URL . "livres"); //redirection de lutilisateur
    }

    private function ajoutImage($file, $dir){ //ajout image et gestion des exception
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");
    
        if(!file_exists($dir)) mkdir($dir,0777);
    
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];
        
        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }


}



?>