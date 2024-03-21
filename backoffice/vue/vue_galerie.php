<?php
include_once('controler/traitement_galerie.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Gestion de la Galerie des projets sur mesure</h2>
    <a class="btn <?php if ($c == 2 && $page == 400) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=400&c=2" role="button">Saisie nouveau projet fini</a>
    <a class="btn <?php if ($c == 1 && $page == 400) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=400&c=1" role="button">Gestion des projets</a>
    <a class="btn <?php if ($c == 5 && $page == 400) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=400&c=5" role="button">Gestion texte présentation</a>
    <a class="btn btn-camel text-light" href="index.php?page=410&c=1" role="button">Gestion des Devis</a>

<?php
include_once('controler/routeur_galerie.php');
?>

</div>