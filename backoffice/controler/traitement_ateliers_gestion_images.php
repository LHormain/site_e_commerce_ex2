<?php
// supprimer une image
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_img_atelier = intval($_GET['sup']);

    $image = req_img_site($bdd,$id_img_atelier);
    $chemin = '../public/assets/img/site/'.$image['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    req_sup_image_atelier($bdd,$id_img_atelier);

}

// récupération des donné sur l'atelier
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_atelier = intval($_GET['id']);

    $donnees = req_ateliers($bdd,$id_atelier);

    // affichage des images
    $images = req_images_atelier($bdd,$id_atelier);

    $table = table_ateliers_gestion_img($images);
}
?>