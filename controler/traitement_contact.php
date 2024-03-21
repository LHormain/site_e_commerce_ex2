<?php
$texte_page_courante = '';
// récupération des objets du message pour le select
$sujets = req_sujet_contacts($bdd);
$select = "";
foreach ($sujets as $lignes) {
    $select .= '<option value="'.$lignes['id_sujet'].'">'.$lignes['nom_sujet'].'</option>
    ';
}

// si le client est connecté auto remplissage des champs
if (isset($_SESSION['id_client'])) {
    $client = req_id_client($bdd);
}
else {
    $client = ['nom_utilisateur' => '', 'prenom_utilisateur' => '', 'mail_utilisateur' => '', 'tel_utilisateur' => '',];
}

// message après envoie du message de contact
if (isset($_GET['m']) && $_GET['m'] != NULL) {
    $m = intval($_GET['m']);

    if ($m == 0) {
        $texte_page_courante = 'Une erreur est survenue. Veuillez réessayer ultérieurement. ';
    }
    elseif ($m == 1) {
        $texte_page_courante = 'Votre message a été envoyé avec succès. Notre équipe traitera votre demande dans les plus brefs délais. <br> Merci de nous avoir contactés.';
    }
    else {
        $texte_page_courante = '';
    }
}

?>