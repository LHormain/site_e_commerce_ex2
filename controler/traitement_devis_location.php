<?php
$lien = '';
$texte_page_courante = '';
$test_devis = 0;
$modifier = 0;
$date_evenement = '';
$nbr_invite = '';
$type_evenement = '';
$message_devis = '';
$adresse_evenement = '';

// si le client est connecté auto remplissage des champs.
// normalement obligé d'être connecté pour arriver sur cette page
if (isset($_SESSION['id_client'])) {
    $client = req_id_client($bdd);
    $test_devis = req_devis_client_existe($bdd,$client['id_user']);
    if ($test_devis != 0) {
        if (isset($_GET['mod']) && $_GET['mod'] != NULL) {
            // si le client veut modifier le devis en attente. normalement ne peut pas avoir plus d'un devis en attente à la foi
            $modifier = 1;
            $devis = req_devis_l_client_m($bdd,$client['id_user']);
            $date_evenement = date('Y-m-d', $devis['date_evenement_devis']);
            $nbr_invite = $devis['nbr_invite'];
            $type_evenement = $devis['type_evenement'];
            $message_devis = $devis['message_devis'];
            $adresse_evenement = $devis['adresse_evenement'];
            $lien = '&mod='.$devis['id_devis'];
        }
        else {
            // si le client a déjà un devis en attente. message qu'il ne peut pas en déposer un second

            $texte_page_courante = 'Vous avez déjà un devis en attente de traitement.<br> Vous pouvez modifier ce devis dans votre espace client. Pour tous autres renseignements contacter nous au '.$tel_site.' ou par mail. ';
        }
    }
} 
else {
    $client = ['nom_utilisateur' => '', 'prenom_utilisateur' => '', 'mail_utilisateur' => '', 'tel_utilisateur' => '',];
}

// liste de souhait
$liste_produit = '';
$id_commande = $_SESSION['id_location'];
$produits = req_panier_location($bdd,$id_commande);

foreach ($produits as $lignes) {
    $liste_produit .= '
    <tr>
        <td scope="row"><img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table me-3"></a>'.$lignes['nom_produit'].'</td>
        <td>'.$lignes['quantite_produit'].'</td>
    </tr>
    ';
}

// récupération des données après envoie du formulaire
if (isset($_GET['m']) && $_GET['m'] != NULL) {
    $m = intval($_GET['m']);

    if ($m == 0) {
        $texte_page_courante = 'Une erreur est survenue. Veuillez réessayer ultérieurement. ';
    }
    elseif ($m == 1) {
        $texte_page_courante = 'Votre demande de devis a été envoyé avec succès. Notre équipe traitera votre demande dans les plus brefs délais. <br> Merci de nous avoir contactés.';
    }
}
?>