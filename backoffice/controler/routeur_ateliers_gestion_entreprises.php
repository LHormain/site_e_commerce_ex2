<?php
if (isset($_GET['d']) && $_GET['d'] != NULL) {
    $d = intval($_GET['d']);

    if ($d == 1) {
        include('vue/vue_ateliers_gestion_texte_entreprises.php');
    }
    elseif ($d == 2) {
        include('vue/vue_ateliers_gestion_images_entreprises.php');
    }
    else {
        include('vue/vue_ateliers_gestion_texte_entreprises.php');
    }
}
else {
    include('vue/vue_ateliers_gestion_texte_entreprises.php');
}

?>