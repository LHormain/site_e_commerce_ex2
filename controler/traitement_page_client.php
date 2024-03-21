<?php
//-----------------------------------------------------------
// routeur pour la page client
//-----------------------------------------------------------
$client = req_id_client($bdd);
$page_courante = '';

if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);

    if ($c == 1) { // information personnelles
        include('controler/traitement_page_client_perso.php');
    }
    elseif ($c == 2) { // paniers
        include('controler/traitement_page_client_paniers.php');
    }
    elseif ($c == 3) { //commandes
        include('controler/traitement_page_client_commandes.php');
    }
    elseif ($c == 4) { //demandes de devis événementiel
        include('controler/traitement_page_client_devis.php');
    }
    elseif ($c == 7) { //demandes de devis sur mesure
        include('controler/traitement_page_client_devis_sm.php');
    }
    elseif ($c == 5) { // favoris
        include('controler/traitement_page_client_favoris.php');
    }
    elseif ($c == 6) { // ateliers
        include('controler/traitement_page_client_ateliers.php');
    }
    else {
        include('controler/traitement_page_client_accueil.php');
    }
}
else {
    include('controler/traitement_page_client_accueil.php');
}
?>