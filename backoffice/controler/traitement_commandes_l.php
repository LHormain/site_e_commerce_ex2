<?php

// récupération des paniers
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = intval($_GET['id']);
    // pour un client précis
    $paniers = req_commandes_locations_client($bdd,$id_user);
}
else {
    // pour tous les clients
    $paniers = req_commandes_locations($bdd);
}
$table = table_commandes_locations_gestion($bdd,$paniers);
?>