<?php 

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
?>
<!--Je peux mettre du html ici no stress-->






<?php 

$content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
$titre = "Bibliothèque MGA";
require "template.php";

?>