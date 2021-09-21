<?php 




abstract class Model{//ne peut pas etre instanciable
    private static $pdo;// accessible par toutes les classes qui vont heriter de la classe model

    private static function setBdd(){// la connexion à la bdd se fera par lintermediaire de cette fonction. Pirvate permet davoir des insfo accessible seulement par la classe model
        self::$pdo = new PDO("mysql:host=localhost;dbname=biblio;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    protected function getBdd(){//protected cad accessible depuis les classes filles. Cette fonction va appeler la connexion à la bdd
        if(self::$pdo === null){ //eske jai une instance $PDO qui existe autrement eske jai une connexion à la bdd
            self::setBdd(); // si je nai pas dobjet PDO autrement dit de connexion a la base de données, je la cree
        }
        return self::$pdo;
    }
}






?>