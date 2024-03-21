<?php

if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c =intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_produits_gestion.php');
    }
    elseif ($c == 2) {
        include('vue/vue_produits_saisie.php');
    }
    elseif ($c == 3) {
        include('vue/vue_produits_section.php');
    }
    else {
        include('vue/vue_produits_section.php');
    }
}
else {
    include('vue/vue_produits_section.php');
}

?>