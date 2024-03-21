<?php
$texte_page_courante = '';

// ---------------------------------------------
//    récupération des données pour un update
// ---------------------------------------------
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_tb_txt = intval($_GET['id']);

    $donnees = req_tb_txt2($bdd,$id_tb_txt);
    $titre_tb_txt = $donnees['titre_tb_txt'];
    $texte_tb_txt = $donnees['descriptif_tb_txt'];
    $titre = 'Modification d\'un';
}
else {
    $titre_tb_txt = '';
    $texte_tb_txt = '';
    $titre = 'Saisie d\'un nouveau';
}

// traitement
if (isset($_POST['titre_tb_txt'], $_POST['descriptif_tb_txt'])
 && $_POST['titre_tb_txt'] != NULL
 && $_POST['descriptif_tb_txt'] != NULL
) {
    $titre_tb_txt = htmlspecialchars($_POST['titre_tb_txt']);
    $descriptif_tb_txt = htmlspecialchars($_POST['descriptif_tb_txt']);

    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        // update
        req_update_tb_txt($bdd,$id_tb_txt,$titre_tb_txt,$descriptif_tb_txt);
    }
    else {
        // insert
        req_insert_tb_txt($bdd,$titre_tb_txt,$descriptif_tb_txt);
    }


    $texte_page_courante = 'Le paragraphe a bien été enregistrée.';
}
?>