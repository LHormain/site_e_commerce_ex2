<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_ateliers_participatif.php');
    }
    elseif ($c == 2) {
        include('vue/vue_ateliers_entreprises.php');
    }
    else {
        include('vue/vue_ateliers_participatif.php');
    }
}
else {
    include('vue/vue_ateliers_participatif.php');
}
?>