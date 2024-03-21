<?php
        include_once('controler/traitement_ateliers_gestion_entreprises.php');
    ?>
<div class="text-center row">
    <h3 class="mb-3">Gestion de la page atelier team building</h3>

    <div>
        <a class="btn <?php if ($d == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?>" href="index.php?page=320&d=2" role="button">Illustrations et clients</a>
        <a class="btn <?php if ($d == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';} ?>" href="index.php?page=320&d=1" role="button">Texte</a>
    </div>

    <?php
        include_once('controler/routeur_ateliers_gestion_entreprises.php');
    ?>
</div>
