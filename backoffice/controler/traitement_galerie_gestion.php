<?php
// supprimer un projet
if (isset($_GET['sup']) && $_GET['sup']) {
    $id_projet = intval($_GET['sup']);
    req_sup_projet($bdd, $id_projet);
}

// affichage des projets
$projets = req_galerie_projet($bdd);
$table = table_galerie_projet($bdd, $projets);

?>