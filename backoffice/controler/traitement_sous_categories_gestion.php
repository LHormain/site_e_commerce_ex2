<?php
//---------------------------------------------------------------------
//                           supprimer
//---------------------------------------------------------------------
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_filtre = intval($_GET['sup']);

    req_sup_sous_categorie($bdd, $id_filtre);
}

//---------------------------------------------------------------------
//                           affichage
//---------------------------------------------------------------------
// récupération des section 
$sections = req_sections($bdd);
$select = select_sections($sections,0);

// récupération de la section à afficher
if (isset($_POST['section']) && $_POST['section'] != NULL) {
    $section = intval($_POST['section']);
    $select = select_sections($sections,$section);

    $sous_categories = req_sous_categories($bdd,$section);
    $table = table_sous_categories($sous_categories);
}

?>