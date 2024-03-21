<?php
if (isset($_POST['id_atelier']) && $_POST['id_atelier'] != NULL) {
    $id_atelier = intval($_POST['id_atelier']);

}
elseif (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_atelier = intval($_GET['id']);

}
elseif (isset($_GET['supa']) && $_GET['supa'] != NULL) {
    $id_atelier = intval($_GET['supa']);

    if (isset($_GET['supc'],$_GET['suph']) && $_GET['supc'] != NULL && $_GET['suph'] != NULL) {
        $id_user = intval($_GET['supc']);
        $id_date = intval($_GET['suph']);

        req_annule_atelier($bdd,$id_user,$id_date,$id_atelier);
    }
}
$donnees = req_ateliers($bdd,$id_atelier);

if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);
    if ($ordre == 1) {
        $req_ordre = ' ORDER BY utilisateurs.nom_utilisateur ';
    }
    elseif ($ordre == 2) {
        $req_ordre = ' ORDER BY calendrier_ateliers.date_atelier ';
    }
    else {
        $req_ordre = ' ORDER BY calendrier_ateliers.date_atelier ';
    }
}
else {
    $req_ordre = ' ORDER BY calendrier_ateliers.date_atelier ';
}
// tableau avec toutes les inscriptions
$inscriptions =req_inscriptions($bdd,$id_atelier, $req_ordre);

$table = table_ateliers_gestion_inscriptions($inscriptions);

// récapitulatif inscriptions
$horaires = req_stat_inscriptions($bdd,$id_atelier);

$recapitulatif = '';
foreach ($horaires as $lignes) {
    $recapitulatif .= '
    <p>'.date('d-m-Y à H:i', $lignes['date_atelier']).' : '.$lignes['nbr_participant'].' participants, reste '.($lignes['nbr_participant_max']-$lignes['nbr_participant']).' places.</p>
    ';
}
?>