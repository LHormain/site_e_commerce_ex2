<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_galerie_gestion.php');
    }
    elseif ($c == 2) {
        include('vue/vue_galerie_saisie_projet.php');
    }
    elseif ($c == 3) {
        include('vue/vue_galerie_gestion_img_projet.php');
    }
    elseif ($c == 4) {
        include('vue/vue_galerie_saisie_img_projet.php');
    }
    elseif ($c == 5) {
        include('vue/vue_galerie_txt.php');
    }
    else {
        include('vue/vue_galerie_gestion.php');
    }
}
else {
    include('vue/vue_galerie_gestion.php');
}
?>