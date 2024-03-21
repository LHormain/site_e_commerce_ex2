<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) {
        include('vue/vue_categories_gestion.php');
    }
    elseif ($c == 2) {
        include('vue/vue_categories_saisie.php');
    }
    elseif ($c == 3) {
        include('vue/vue_sous_categories_gestion.php');
    }
    elseif ($c == 4) {
        include('vue/vue_sous_categories_saisie.php');
    }
    elseif ($c == 5) {
        include('vue/vue_sections.php');
    }
    else {
        include('vue/vue_categories_gestion.php');
    }
}
else {
    include('vue/vue_categories_gestion.php');
}
?>