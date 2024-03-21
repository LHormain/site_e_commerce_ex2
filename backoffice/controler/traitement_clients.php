<?php
// désactivation client?

// si cherche un client précis
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = intval($_GET['id']);
}
else {
    $id_user = 0;
}

// affichage
if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);
    
    if ($ordre == 1) {
        $ordre_req = 'ORDER BY identifiant_client';
    }
    elseif ($ordre == 2) {
        $ordre_req = 'ORDER BY nom_utilisateur';
    }
    elseif ($ordre == 3) {
        $ordre_req = 'ORDER BY prenom_utilisateur';
    }
    else {
        $ordre_req = 'ORDER BY id_user';
    }
}
else {
    $ordre_req = 'ORDER BY id_user';
}

$clients = req_clients($bdd,$ordre_req);
$table = table_clients($clients, $bdd,$id_user);
?>