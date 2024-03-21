<?php
// supprimer une horaire
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_horaire = intval($_GET['sup']);

    // ne peut supprimer que si il n'y a pas d’inscription
    req_sup_horaire($bdd,$id_horaire);
}

//récupération des données
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_atelier = intval($_GET['id']);

    $donnees = req_ateliers($bdd,$id_atelier);

    $horaire = req_horaires_atelier($bdd,$id_atelier);

    $table = table_ateliers_gestion_horaire($bdd,$horaire);
    
}
?>