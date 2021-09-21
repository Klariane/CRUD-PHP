<?php 


class Livre //cette classe permet de recuperer les informations liées au livres . Si je cree une instance de ce livre cad un objet new livre je vais devoir renseigner en parametre les id titre nbrePages image.
{

    private $id;
    private $titre;
    private $nbrePages;
    private $image;

    //  public static $livres; //nouvel attribut contenant la liste des livres. ce tableau des livres sera rempli dans le constructeur au moment de la creation de chacun des livres




    public function __construct($id, $titre, $nbrePages, $image)
    {

        $this->id = $id; // $this->id fait référence à private $id et $id renvoit au parametre de la fonction public function __construct($id, $titre, $nbrePages, $image)
        $this->titre = $titre;
        $this->nbrePages = $nbrePages;
        $this->image = $image;
        //  self::$livres[]=$this; //le tableau $livres va recuperer la liste des livres
        
    }

    public function getId(){
       return  $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }


    public function getTitre(){
        return  $this->titre;
     }
     public function setTitre($titre){
         $this->titre=$titre;
     }


     public function getNbrePages(){
        return  $this->nbrePages;
     }
     public function setNbrePages($nbrePages){
         $this->nbrePages=$nbrePages;
     }

     public function getImage(){
        return  $this->image;
     }
     public function setImage($image){
         $this->image=$image;
     }


}


?>