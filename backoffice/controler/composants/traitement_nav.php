<?php

if (isset($_GET['page']) && $_GET['page'] != NULL) {
    $page = intval($_GET['page']);

    if (isset($_GET['c']) && $_GET['c'] != NULL) {
        $c = intval($_GET['c']);
    }
    else {
        $c=1;
    }
}
else {
    $page=1;
}

?>