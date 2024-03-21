<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1 ) {
        include('vue/vue_ateliers_gestion_choix_inscriptions.php');
    }
    elseif ($c == 2) {
        include('vue/vue_ateliers_gestion_inscriptions.php');
    }
    else {
        include('vue/vue_ateliers_gestion_choix_inscriptions.php');
    }
}
else {
    include('vue/vue_ateliers_gestion_choix_inscriptions.php');
}
?>