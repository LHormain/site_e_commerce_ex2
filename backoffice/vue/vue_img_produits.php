<?php
    include_once('controler/traitement_img_produits.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Gestion des images produits</h2>
    <a class="btn <?php if (isset($id_produit) && $c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=530&c=2&id_produit=<?php echo $id_produit; ?>" role="button">Saisie d'une nouvelle image</a>
    <a class="btn <?php if (isset($id_produit) && $c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=530&c=1&id_produit=<?php echo $id_produit; ?>" role="button">Gestion des images</a>
    <a
        class="btn btn-camel text-light  "
        href="index.php?page=520&c=1&s=<?php echo $section['id_section']; ?>"
        role="button"
        >Retour à la gestion des produits</a
    >
    <?php
    include_once('controler/routeur_img_produits.php');
    ?>
</div>