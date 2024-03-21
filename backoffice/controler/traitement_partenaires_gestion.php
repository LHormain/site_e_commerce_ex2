<?php
// supprimer
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_partenaire = intval($_GET['sup']);

    req_sup_partenaire($bdd, $id_partenaire);
}

//afficher
$partenaires = req_partenaires($bdd);
$table = table_partenaires($partenaires);
?>