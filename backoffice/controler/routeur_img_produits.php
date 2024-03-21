<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c =intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_img_produits_gestion.php');
    }
    elseif ($c == 2) {
        include('vue/vue_img_produits_saisie.php');
    }
    else {
        include('vue/vue_img_produits_gestion.php');
    }
}
else {
    include('vue/vue_img_produits_gestion.php');
}

?>