<?php
include_once('controler/traitement_partenaires.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Liste des partenaires</h2>
    <a
        class="btn <?php if ($c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> "
        href="index.php?page=820&c=1"
        role="button"
        >Gestion</a
    >
    <a
        class="btn <?php if ($c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> "
        href="index.php?page=820&c=2"
        role="button"
        >Saisie</a
    >
    <div class="row">
        <?php
        include_once('controler/routeur_partenaires.php');
        ?>
    </div>
</div>