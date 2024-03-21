<?php
if (isset($_GET['id_produit']) && $_GET['id_produit'] != NULL) {
    $id_produit = intval($_GET['id_produit']);

    $produit = req_produit($bdd,$id_produit);
    $section = req_categorie($bdd,$produit['id_cat']);
}
?>