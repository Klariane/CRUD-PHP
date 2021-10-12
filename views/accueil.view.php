<?php 

//Temporisation par l'intermediaire d'un buffer ob_start()
ob_start();
?>
<!--Je peux mettre du html ici no stress-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiBiothèque MGA</title>
    <link rel="stylesheet" href="public/CSS/style.css">
</head>
<body>
    <header id="showcase">

    <h1>Bienvenue à la bibliothèque MGA</h1>
    
    <a href="<?= URL ?>livres" class="button">En savoir plus...</a>
    </header>
    
</body>
</html>





<?php 

// $content = ob_get_clean(); // ici je deverse tout ce qui va etre entre ob_start et ob_get_clean
// $titre = "Bibliothèque MGA";
// require "template.php";

?>