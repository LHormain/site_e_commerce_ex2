<?php
if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);
    if ($ordre == 1) {
        $req_ordre = ' ORDER BY devis_livraisons.date_devis ';
    }
    elseif ($ordre == 2) {
        $req_ordre = ' ORDER BY utilisateurs.nom_utilisateur ';
    }
    elseif ($ordre == 3) {
        $req_ordre = ' ORDER BY devis_livraisons.id_etat ';
    }
    else {
        $req_ordre = '';
    }
}
else {
    $req_ordre = '';
}

if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = htmlspecialchars($_GET['id']);
    // pour un client en particulier
    $devis = req_devis_v_client($bdd,$req_ordre,$id_user);
}
else {
    // pour tous les clients
    $devis = req_devis_v_all($bdd,$req_ordre);
}
$table = table_devis_v($bdd,$devis);
?>