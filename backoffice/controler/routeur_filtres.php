<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_filtres_gestion.php');
    }
    elseif ($c ==2) {
        include('vue/vue_filtres_saisie.php');
    }
    else {
        include('vue/vue_filtres_gestion.php');
    }
}
else {
    include('vue/vue_filtres_gestion.php');
}
?>