<?php
// supprimer un logo ou une image
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_img = intval($_GET['sup']);

    $image = req_img_site($bdd,$id_img);
    $chemin = '../public/assets/img/site/'.$image['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    req_sup_image_tb($bdd,$id_img);

}


// affichage
$logos = req_tb($bdd,1);
$images = req_tb($bdd, 2);

$table_logo = table_tb($logos,1);
$table_image = table_tb($images,2);

?>