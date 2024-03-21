<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);
    if ($c == 1) {
        include('vue/vue_ateliers_gestion.php');
    }
    elseif ($c == 2) {
        include('vue/vue_ateliers_saisie.php');
    }
    elseif ($c == 3) {
        include('vue/vue_ateliers_gestion_horaire.php');
    }
    elseif ($c == 4) {
        include('vue/vue_ateliers_saisie_horaire.php');
    }
    elseif ($c == 5) {
        include('vue/vue_ateliers_gestion_image.php');
    }
    elseif ($c == 6) {
        include('vue/vue_ateliers_saisie_image.php');
    }
    elseif ($c == 7) {
        include('vue/vue_ateliers_txt.php');
    }
    else {
        include('vue/vue_ateliers_gestion.php'); 
    }
}
else {
    include('vue/vue_ateliers_gestion.php');
}


?>