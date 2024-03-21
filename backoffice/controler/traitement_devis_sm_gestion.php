<?php
// supprimer
    if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
        $id_contact = intval($_GET['sup']);

        req_sup_devis($bdd,$id_contact);
        // req_sup_contacts($bdd, $id_contact);
    }

// affichage des demandes
    if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
        $ordre = intval($_GET['ordre']);
        if ($ordre == 1) {
            $req_ordre = ' ORDER BY date_contact ';
        }
        elseif ($ordre == 2) {
            $req_ordre = ' ORDER BY nom_contact ';
        }
        elseif ($ordre == 3) {
            $req_ordre = ' ORDER BY mail_contact ';
        }
        else {
            $req_ordre = '';
        }
    }
    else {
        $req_ordre = '';
    }
    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        $mail_user = htmlspecialchars($_GET['id']);
        // pour un client en particulier
        $devis = req_devis_sur_mesure_client($bdd,$req_ordre,$mail_user);
    }
    else {
        $devis = req_devis_sur_mesure($bdd,$req_ordre);
        // pour tous les clients
    }
    $table = table_devis_sm($bdd,$devis);
?>