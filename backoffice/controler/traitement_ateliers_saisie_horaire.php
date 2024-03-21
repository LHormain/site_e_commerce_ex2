<?php
$texte_page_courante = '';

// récupération de l'atelier
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_atelier = intval($_GET['id']);

    $donnees = req_ateliers($bdd,$id_atelier);
    $nom_atelier = $donnees['nom_atelier'];
}
// ---------------------------------------------
//    récupération des données pour un update
// ---------------------------------------------
if (isset($_GET['h'])
&& $_GET['h'] != NULL
){
    $id_horaire = intval($_GET['h']);
    $donnees = req_horaire($bdd,$id_horaire);

    $date_atelier = date('Y-m-d\TH:i',$donnees['date_atelier']); // date sous format pour le input
    $titre = 'Modification d\'une';
}
else {
    $date_atelier = '';
    $titre = 'Saisie d\'une nouvelle';
}
// traitement
if (isset($_POST['date_atelier']) && $_POST['date_atelier'] != NULL) {
    $date_atelier = strtotime(htmlspecialchars($_POST['date_atelier'])); // transforme en timestamp

    if (isset($_GET['h']) && $_GET['h'] != NULL) {
        // update
        req_update_horaire($bdd,$id_horaire,$date_atelier);

    }
    else {
        // insert
        req_insert_horaire($bdd,$id_atelier,$date_atelier);
    }


    $texte_page_courante = 'La date a bien été enregistrée.';
}
?>