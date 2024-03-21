<?php
include_once('controler/traitement_categories.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Gestion des catégories de la boutique</h2>

    <a class="btn <?php if ($c == 5) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=500&c=5" role="button">Gestion des sections </a>
    <a class="btn <?php if ($c == 1) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=500&c=1" role="button">Gestion d'une catégorie </a>
    <a class="btn <?php if ($c == 2) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=500&c=2" role="button">Saisie d'une catégorie</a>
    <a class="btn <?php if ($c == 3) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=500&c=3" role="button">Gestion d'une sous catégorie</a>
    <a class="btn <?php if ($c == 4) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=500&c=4" role="button">Saisie d'une sous catégorie</a>

    <div class="row">
        <?php
        include_once('controler/routeur_categories.php');
        ?>
    </div>

</div>