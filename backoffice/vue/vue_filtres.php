<?php
include_once('controler/traitement_filtres.php');
?>
<div class="col-10 p-5 text-center">
    <h2  class="mt-3">Gestion des Customisations</h2>

    <a class="btn <?php if ($c == 1) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=510&c=1" role="button">Gestion des customisations </a>
    <a class="btn <?php if ($c == 2) { echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=510&c=2" role="button">Saisie d'une nouvelle customisation</a>
    
    <div class="row">
        <?php
        include_once('controler/routeur_filtres.php');
        ?>
    </div>
</div>