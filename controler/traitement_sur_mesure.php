<?php
// récupération de la description du projet sur mesure et des images correspondantes
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_projet = intval($_GET['id']);
    $projet = req_projet($bdd,$id_projet);

    $carousel = carousel_tb($projet,0,count($projet)-1,'carouselProjet');
    $carousel_indicator = $carousel[0];
    $carousel_item = $carousel[1];
}
?>