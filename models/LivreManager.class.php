<?php


require_once "Model.class.php";
require_once "Livre.class.php";

class LivreManager extends Model{
    private $livres; //tableau de livre

    public function ajoutLivre($livre){
        $this->livres[] = $livre;
    }

    public function getLivres(){
        return $this->livres;
    }

    public function chargementLivres(){
        $req = $this->getBdd()->prepare("SELECT * FROM livres");//je prepare la requete pr selectionner tous mes livres
        $req->execute();// jexecute ma requete
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);//je recupere les element de la bdd sans doublon grace a fetch_assoc
        $req->closeCursor();//le cloture ma requete afin quon puisse executer une autre requete sur la bdd

        foreach($mesLivres as $livre){ //Je vais parcourir mes livres et recuperer à chaque fois les information d'un livre.pr chaque livre stocké dans la variable $mesLivres
            $l = new Livre($livre['id'],$livre['titre'],$livre['nbPages'],$livre['image']);//je cree un tableau à partir de la class Livre du fichier Livre.class.php 
            $this->ajoutLivre($l); //jenvoi les données $l en parametre de la fonction ajoutLivre()
        }
    }

    public function getLivreById($id)
    {
        for($i=0; $i< count($this->livres); $i++){ //je parcours le tableau de livre jusqu'a la taille du tableau -1
            if($this->livres[$i]->getId()===$id){ //je compare l'indentifiant du livre avec le paramètre transféré dans la function
                return $this->livres[$i];
            }
        }
        //lever une exception au cas où le livre n'existe pas
        throw new Exception("Le livre n'existe pas");//si on a pas trouvé le livre, la page d'erreur va safficher
    }


    public function ajoutLivreBd($titre, $nbPages, $image)
    {
        $req = " INSERT INTO livres (titre, nbPages, image ) VALUES (:titre, :nbPages, :image)";

        $stmt = $this->getBdd()->prepare($req);

        //bindValue permet de sécuriser les informations transmises à la requete
        $stmt->bindValue(":titre", $titre,PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages,PDO::PARAM_INT);
        $stmt->bindValue(":image", $image,PDO::PARAM_STR);

        $resultat = $stmt->execute();

        $stmt->closeCursor();

        if($resultat >0){
            $livreAjoute = new Livre($this->getBdd()->lastInsertID(),$titre,$nbPages,$image);
            $this->ajoutLivre($livreAjoute);
        }
    }


    public function suppressionLivreBD($id)
    {
        $req = "
        DELETE FROM livres WHERE id = :idLivre"; // requete

        $stmt = $this->getBdd()->prepare($req);//jutilise PDO pour lancer ma requete.jappelle getBdd() pour connecter a la BDD, jappelle prepare()pour preparer la requete
        $stmt ->bindValue(":idLivre", $id , PDO::PARAM_INT);//je renseigne le parametre idLivre dans ma requete. idLivre va prendre la valeur du parametre $id de ma function.pour faire cela jutilise bindvalue
        $resultat = $stmt->execute();
        $stmt->CloseCursor(); //liberer lacces à la BDD

        if($resultat>0)
        {
            $livreASupprimer=$this->getLivreById($id);
            unset($livreASupprimer);
        }
    }

    public function modificationLivreBD($id, $titre, $nbPages, $image)

    {
        $req = "
        update livres
        set titre = :titre, nbPages = :nbPages, image = :image
        WHERE id= :id ";
        
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":titre",$titre,PDO::PARAM_STR);
        $stmt->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        
        $resultat = $stmt->execute();
        $stmt->closeCursor();


        if($resultat > 0)
        {
            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setNbrePages($nbPages);
            $this->getLivreById($id)->setImage($image);
        }

        
    }
}











// require_once "Model.class.php";


// class LivreManager extends Model
// {
//     private $livres;

//     public function ajoutLivre($livres){
//         $this->livres[] = $livres; // j'enregistre la variable $livre dans le tableau $livres

//     }

//     public function getLivre(){
//         return $this->livres; //Ceci me permet de retourner le tableau stocké dans private $livres
//     }

//     public function chargementLivres(){
//         $req = $this->getBdd()->prepare("SELECT * FROM livres");//je prepare ma requete
//         $req-> execute();//jexecute la requete
//         $livres = $req->fetchAll(PDO::FETCH_ASSOC); //recuperer les données issues de la requete ci dessus
//         $req->closeCursor();
       
     
//     }


// }

?>