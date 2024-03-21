<?php
    require_once('controler/traitement_ateliers.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Gestion des Ateliers</h2>
    <a class="btn <?php if ($c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=300&c=2" role="button">Saisie nouvel Atelier</a>
    <a class="btn <?php if ($c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=300&c=1" role="button">Gestion des Ateliers</a>
    <a class="btn <?php if ($c == 7) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?> " href="index.php?page=300&c=7" role="button">Gestion texte présentation</a>

<?php
    require_once('controler/routeur_ateliers.php');
?>

</div>