<?php 

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
?>


<form method="POST" action="<?= URL ?>livres/mv" enctype="multipart/form-data">
  <div class="form-group">
    <label for="titre">Titre : </label>
    <input type="text" class="form-control" id="titre" name = "titre" value="<?= $livreAModifier->getTitre() ?>" >
  </div>

  <div class="form-group mt-3 mb-3">
    <label for="nbPages">Nombre de pages : </label>
    <input type="number" class="form-control" id="nbPages" name = "nbPages" value="<?= $livreAModifier->getNbrePages() ?>">
  </div>

 <h3>Images : </h3>
 <img src="<?= URL ?>public/images/<?=$livreAModifier->getImage() ?>">
  <div class="form-group mt-3 mb-3" >
    <label for="image">Image : </label>
    <input type="file" class="form-control-file" id="image" name ="image">
  </div>

  <input type="hidden" name="identifiant" value="<?=$livreAModifier->getId(); ?>"> <!--ca va me permettre de recuperer dans $_POST la propriété identifiant qui contiendra l'id-->
  <button type="submit" class="btn btn-primary">Valider</button>
</form>



<?php 

$content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
$titre = "Modification du livre: ".$livreAModifier->getId(); ;
require "template.php";

?>