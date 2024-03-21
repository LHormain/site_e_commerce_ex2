<?php
$table_img_produit = '';

// DELETE
if (isset($_GET['sup'])
&& $_GET['sup'] != NULL) {
    $id_image = intval($_GET['sup']);

    $donnees = req_select_img_produit($bdd,$id_image);
    $chemin = '../public/assets/img/produits/'.$donnees['nom_img_produit'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }

    req_sup_img_produit($bdd,$id_image);
}


// récupération des données de la BDD

$images = req_images_produit($bdd,$id_produit);


$table_img_produit = '';
foreach ($images[0] as $donnees) {
    $table_img_produit .= table_img_produit_gestion($donnees);
}

?>