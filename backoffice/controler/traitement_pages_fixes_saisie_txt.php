<?php
// récupération de la page du site sur laquelle on travaille
if (isset($_GET['sc']) && $_GET['sc'] != NULL) {
    $id_pf = intval($_GET['sc']);

    $pages_fixes = req_pages_fixes($bdd,$id_pf);
    if (in_array($id_pf, [1,2,4])){
        $page = '830&c='.$id_pf;
    }
    elseif ($id_pf == 3) {
        $page = '400&c=5';
    }
    elseif ($id_pf == 5) {
        $page = '300&c=7';
    }
}
$titre = 'Saisie';
$titre_page = $pages_fixes['nom_pf'];
$titre_pf = '';
$texte_pf = '';
$texte_page ='';

// récupération des données pour un update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_txt_pf = intval($_GET['id']);
    $titre = 'Modification ';
    $pages_fixes_txt = req_pages_fixes_txt($bdd,$id_txt_pf);
    $titre_pf = $pages_fixes_txt['titre_pf'];
    $texte_pf = $pages_fixes_txt['texte_pf'];
}

// traitement du formulaire
if (isset($_POST['titre_pf'], $_POST['texte_pf'])
&& $_POST['titre_pf'] != NULL
&& $_POST['texte_pf'] != NULL
){
    $titre_pf = htmlspecialchars($_POST['titre_pf']);
    $texte_pf = htmlspecialchars($_POST['texte_pf']);

    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        //update
        req_update_pages_fixes($bdd,$titre_pf,$texte_pf,$id_txt_pf);
    }
    else {
        //insert
        req_insert_pages_fixes($bdd,$titre_pf,$texte_pf,$id_pf);
    }
    $texte_page = 'Données enregistrées';
}
else {
}
?>