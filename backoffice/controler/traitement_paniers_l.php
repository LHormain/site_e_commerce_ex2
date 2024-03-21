<?php

// récupération des paniers
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = intval($_GET['id']);
    // pour un client précis
    $paniers = req_paniers_locations_client($bdd,$id_user);
}
else {
    // pour tous les clients
    $paniers = req_paniers_locations($bdd);
}
$table = table_paniers_locations_gestion($bdd,$paniers);
?>