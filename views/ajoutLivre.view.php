<?php 

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
?>
<!--Je peux mettre du html ici no stress-->


<form method="POST" action="<?= URL ?>livres/av" enctype="multipart/form-data">
  <div class="form-group">
    <label for="titre">Titre : </label>
    <input type="text" class="form-control" id="titre" name = "titre" >
  </div>

  <div class="form-group mt-3 mb-3">
    <label for="nbPages">Nombre de pages : </label>
    <input type="number" class="form-control" id="nbPages" name = "nbPages" >
  </div>

 
  <div class="form-group mt-3 mb-3" >
    <label for="image">Image : </label>
    <input type="file" class="form-control-file" id="image" name ="image">
  </div>

  
  <button type="submit" class="btn btn-primary">Valider</button>
</form>



<?php 

$content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
$titre = "Ajout d'un livre";
require "template.php";

?>