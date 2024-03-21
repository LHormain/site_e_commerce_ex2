<?php
//------------------------
//       supprimer
//------------------------
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_atelier = intval($_GET['sup']);
    // supprime tout, même les inscriptions
    req_sup_ateliers($bdd, $id_atelier);
}

//--------------------------------------
//      recuperation des ateliers
//--------------------------------------
$donnees = req_tous_ateliers($bdd);

$table = table_ateliers_gestion($bdd,$donnees);

?>