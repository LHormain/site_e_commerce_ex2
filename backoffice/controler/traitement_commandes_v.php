<?php
//classement
if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);

    if ($ordre == 1) {
        $req_ordre = " ORDER BY id_commande ";
    }
    elseif ($ordre == 2) {
        $req_ordre = " ORDER BY id_user ";
    }
    else {
        $req_ordre = "";
    }
}
else {
    $req_ordre = "";
}

// récupération des paniers
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = intval($_GET['id']);
    // pour un client précis
    $paniers = req_commandes_ventes_client($bdd,$id_user,$req_ordre);
}
else {
    // pour tous les clients
    $paniers = req_commandes_ventes($bdd,$req_ordre);
}
$table = table_commandes_ventes_gestion($bdd,$paniers);
?>