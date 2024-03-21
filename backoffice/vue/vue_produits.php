<?php
    include_once('controler/traitement_produits.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Gestion des produits</h2>
    <a class="btn <?php if ($c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=520&c=2" role="button">Saisie d'un nouveau produit</a>
    <a class="btn <?php if ($c == 3 || $c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=520&c=3" role="button">Gestion des produits</a>

    <?php
    include_once('controler/routeur_produits.php');
    ?>
</div>