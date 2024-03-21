<?php
$titre = 'Inscription';
$btn_envoyer = 'S\'inscrire';
$test = 1; // inscription
$lien = '';
$client = ['nom_utilisateur' => '', 'prenom_utilisateur' => '', 'mail_utilisateur' => '', 'tel_utilisateur' => '','newsletter' => 1];
$adresse_facturation = ['id_adresse' => 0, 'rue_adresse' => '', 'ville_adresse' => '', 'code_postal_adresse' => '', 'complement_adresse' => '', 'numero_adresse' => '', 'id_pays' => 75];
$adresse_livraison = ['id_adresse' => 0, 'rue_adresse' => '', 'ville_adresse' => '', 'code_postal_adresse' => '', 'complement_adresse' => '', 'numero_adresse' => '', 'id_pays' => 75];

$pays = req_pays($bdd);
$liste_option_facturation = '';
$liste_option_livraison = '';

// Pour une update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_user = intval($_GET['id']);
    $titre = 'Modifier votre compte';
    $btn_envoyer = 'Modifier mes données';
    $test = 2; //update
    
    $client = req_id_client($bdd);
    $lien = '&id='.$client['id_user'];

    if (isset($_GET['fac']) && $_GET['fac'] != NULL) {
        $fac = intval($_GET['fac']);
        if ($fac != 0) {
            $adresse_facturation = req_adresse_client($bdd, $fac);

            foreach ($pays as $lignes) {
                if ($lignes['id_pays'] == $adresse_facturation['id_pays']) {

                    $liste_option_facturation .= '<option value="'.$lignes['id_pays'].'" selected>'.$lignes['nom_fr_fr'].'</option>';
                }
                else {

                    $liste_option_facturation .= '<option value="'.$lignes['id_pays'].'">'.$lignes['nom_fr_fr'].'</option>';
                }
            }
        }
    }

    if (isset($_GET['liv']) && $_GET['liv'] != NULL) {
        $liv = intval($_GET['liv']);
        if ($liv != 0) {
            $adresse_livraison = req_adresse_client($bdd, $liv);

            foreach ($pays as $lignes) {
                if ($lignes['id_pays'] == $adresse_livraison['id_pays']) {

                    $liste_option_livraison .= '<option value="'.$lignes['id_pays'].'" selected>'.$lignes['nom_fr_fr'].'</option>';
                }
                else {

                    $liste_option_livraison .= '<option value="'.$lignes['id_pays'].'">'.$lignes['nom_fr_fr'].'</option>';
                }
            }
        }
    }

}
else {
    // création du select pays
    
    foreach ($pays as $lignes) {
        if ($lignes['id_pays'] == $adresse_livraison['id_pays']) {

            $liste_option_facturation .= '<option value="'.$lignes['id_pays'].'" selected>'.$lignes['nom_fr_fr'].'</option>';
            $liste_option_livraison .= '<option value="'.$lignes['id_pays'].'" selected>'.$lignes['nom_fr_fr'].'</option>';
        }
        else {

            $liste_option_facturation .= '<option value="'.$lignes['id_pays'].'">'.$lignes['nom_fr_fr'].'</option>';
            $liste_option_livraison .= '<option value="'.$lignes['id_pays'].'">'.$lignes['nom_fr_fr'].'</option>';
        }
    }
}

// résultat de l'inscription ou la mise à jour des données personnelles 
$message = '';
if (isset($_GET['m']) && $_GET['m']) {
    $m = intval($_GET['m']);
    
    if ($m == 1) {
        $message = 'Votre compte a été correctement créé.<br> Bienvenue sur <strong>'.$nom_entreprise.'</strong>';
    }
    elseif ($m == 2) {
        $message = 'Vous devez entrer deux fois le même mot de passe.';
    }
    elseif ($m == 3) {
        $message = 'Un compte pour cette adresse mail existe déjà. Veuillez en choisir une autre ou vous connecter.';
    }
    elseif ($m == 4) {
        $message = 'Vos données ont été correctement modifiées';
    }
    elseif ($m == 5) {
        $message = 'Mot de passe incorrecte';
    }
    
}
?>