<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);
    if ($c == 1) {
        include('vue/vue_qui.php');
    }
    elseif ($c == 2) {
        include('vue/vue_deco.php');
    }
    elseif ($c == 3) {
        include('vue/vue_galerie_txt.php');
    }
    elseif ($c == 4) {
        include('vue/vue_slider.php');
    }
    elseif ($c == 5) {
        include('vue/vue_pages_fixes_saisie_txt.php');
    }
    elseif ($c == 6) {
        include('vue/vue_pages_fixes_saisie_img.php');
    }
    else {
        include('vue/vue_qui.php'); 
    }
}
else {
    include('vue/vue_qui.php');
}
?>