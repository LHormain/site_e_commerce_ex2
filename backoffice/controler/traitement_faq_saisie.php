<?php
$titre = 'Saisie';
$question_faq = '';
$reponse_faq = '';
$texte_page ='';

// récupération des données pour un update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_faq = intval($_GET['id']);
    $titre = 'Modification ';
    $faq = req_faq($bdd,$id_faq);
    $question_faq = $faq['question_faq'];
    $reponse_faq = $faq['reponse_faq'];
}

// traitement du formulaire
if (isset($_POST['question_faq'], $_POST['reponse_faq'])
&& $_POST['question_faq'] != NULL
&& $_POST['reponse_faq'] != NULL
){
    $question_faq = htmlspecialchars($_POST['question_faq']);
    $reponse_faq = htmlspecialchars($_POST['reponse_faq']);

    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        //update
        req_update_faq($bdd,$question_faq,$reponse_faq,$id_faq);
    }
    else {
        //insert
        req_insert_faq($bdd,$question_faq,$reponse_faq);
    }
    $texte_page = 'Données enregistrées';
}
else {
}
?>