<?php
// suppression d'une image
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_img = intval($_GET['sup']);

    $image = req_img_site($bdd,$id_img);
    $chemin = '../public/assets/img/site/'.$image['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    req_sup_image_projet($bdd,$id_img);
}

// affichage
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_projet = intval($_GET['id']);

    $projet = req_projet($bdd,$id_projet);
    $images = req_galerie_img_projet($bdd,$id_projet);

    $table = table_galerie_img_projet($bdd,$images);

}
?>