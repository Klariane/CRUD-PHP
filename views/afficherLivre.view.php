<?php 

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
?>
<!--Je peux mettre du html ici no stress-->

<div class="row">

<div class = "col-6">
    <img src="<?= URL ?>public/images/<?= $ceLivre->getImage(); ?>">

</div>

<div class = "col-6">
<p>Titre : <?=$ceLivre->getTitre(); ?> </p>
<p>Nombre de Pages : <?=$ceLivre->getNbrePages(); ?> </p>
</div>

</div>




<?php 

$content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
$titre = $ceLivre->getTitre();
require "template.php";

?>