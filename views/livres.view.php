<?php  
// require_once "Livre.class.php"; // Maintenant que j'ai récupéré le fichier Livre.class.php, je peux recuperer la classe livre et le constructeur pr generer les livre

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
if(!empty($_SESSION['alert'])) :
?>
<div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
<?= $_SESSION['alert']['msg'] ?>
</div>

<?php 
unset($_SESSION['alert']);

endif; ?>

<table class= "table text-center">
<tr class="table-dark">
<th>Image</th>
<th>Titre</th>
<th>Nombre de pages</th>
<th colspan="2">Actions</th>
</tr>

<?php


for($i = 0; $i<count($tableauDeLivre); $i++): ?> <!--Pour acceder au tableau $livres je tape la classe suivi de lattribut static livre-->
<tr>
    <td class="align-middle"><img src="public/images/<?=$tableauDeLivre[$i]->getImage(); ?>" alt="livre1" width="60px"></td>
    <td class="align-middle"><a href="<?= URL ?>livres/l/<?=$tableauDeLivre[$i]->getId(); ?>"><?=$tableauDeLivre[$i]->getTitre(); ?></a></td>
    <td class="align-middle"><?=$tableauDeLivre[$i]->getNbrePages(); ?></td>
    <td class="align-middle"><a href="<?=URL?>livres/m/<?= $tableauDeLivre[$i]->getId();?>" class="btn btn-warning">Modifier</a></td>
    <td class="align-middle">
            <form method="POST" action="<?=URL?>livres/s/<?= $tableauDeLivre[$i]->getId();?>" onsubmit="return confirm('Voulez-vous vraiment supprimer le livre?');">
            <button class="btn btn-danger" type="submit">Supprimer</button>
            </form>
    </td>
    
</tr>
<?php endfor;  ?>


</table>

<a href="<?= URL  ?>livres/a" class="btn btn-success d-block">Ajouter</a>


<?php 

$content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
$titre = "Les livres de la bibliothèque";
require "template.php";

?>