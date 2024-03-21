<?php

if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_ateliers_gestion_entreprises.php');
    }
    elseif ($c == 2) {
        include('vue/vue_ateliers_saisie_entreprises.php');
    }
    elseif ($c == 3) {
        include('vue/vue_ateliers_saisie_texte_entreprises.php');
    }
    else {
        include('vue/vue_ateliers_gestion_entreprises.php');
    }
}
else {
    include('vue/vue_ateliers_gestion_entreprises.php');
}

?>