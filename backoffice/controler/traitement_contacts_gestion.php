<?php
// supprimer
    if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
        $id_contact = intval($_GET['sup']);

        req_sup_contacts($bdd, $id_contact);
    }

// affichage des demandes
if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);
    if ($ordre == 1) {
        $ordre_req = 'ORDER BY contacts.id_contact';
    }
    elseif ($ordre == 2) {
        $ordre_req = 'ORDER BY contacts.nom_contact';
    }
    elseif ($ordre == 3) {
        $ordre_req = 'ORDER BY contacts.date_contact';
    }
    elseif ($ordre == 4) {
        $ordre_req = 'ORDER BY contacts.id_sujet';
    }
    else {
        $ordre_req = 'ORDER BY contacts.id_user';
    }
}
else {
    $ordre_req = 'ORDER BY contacts.id_contact';
}
    $message = req_contacts($bdd,$ordre_req);
    $table = table_contacts($message);
?>