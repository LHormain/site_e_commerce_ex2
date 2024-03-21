<?php
    $jour = time();
    // vente
    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        $id_commande = intval($_GET['id']);
        $produits = req_commande_vente($bdd,$id_commande);
        $choix_table = 1;
    }
    else {
        $choix_table = 0;
        $id_commande = $_SESSION['id_commande'];
        $produits = req_panier_vente($bdd,$id_commande);
    }

    // en tête page
    $breadcrumb = '
    <li class="breadcrumb-item " >Mon panier</li>
    <li class="breadcrumb-item active fw-bold" aria-current="page">Commander</li>
    <li class="breadcrumb-item " >Commande complétée</li>
    ';

    // encart coté
    $sous_titre = "Total à payer";

    // tableau
    $total_HT = 0;
    $total_TTC = 0;
    $TVA = 0;
    $nbr_produits = 0;
    $poids_livraison = 0;
    $dimension_livraison = 0;
    $dimension_totale = 0;
    $devis_livraison = 0;
    $frais_de_port = 0;

    $client = req_id_client($bdd);
    $livraisons = req_adresses_client($bdd,$client['id_user'], 2);
    $facturations = req_adresses_client($bdd,$client['id_user'], 1);

    //-------------------------
    // données du panier
    //-------------------------
    foreach ($produits as $lignes) {
        $total_HT += $lignes['prix_unitaire']*$lignes['quantite_produit'];
        $total_TTC += $lignes['prix_unitaire']*$lignes['quantite_produit']*(1+20/100);
        $nbr_produits += 1;
        $poids_livraison += $lignes['poids_produit'];
        if ($choix_table == 0) {
            $taille = req_produit_taille_select($bdd,$lignes['id_taille']);
        }
        else {
            $taille = req_produit_taille_select2($bdd,$lignes['id_taille']);
        }
        $dimension_livraison = $taille['longueur']+$taille['largeur']+$taille['hauteur'];
        $dimension_totale += $dimension_livraison;

        if ($lignes['devis_obligatoire'] == 1) {
            $devis_livraison = 1;
        }
        elseif ($dimension_livraison > 150) {
            $devis_livraison = 1;
        }
        elseif ($taille['longueur'] > 100) {
            $devis_livraison = 1;
        }
    }
    $TVA = $total_TTC-$total_HT;

    //---------------------------
    // données des adresses
    //---------------------------
    $adresses_livraison = '';
    $adresses_facturation = '';
    foreach ($livraisons as $lignes) {
        if (isset($lignes['complement_adresse'])) {
            $complement = $lignes['complement_adresse'];
        }
        else {
            $complement = '';
        }
        $adresses_livraison .= '<option value="'.$lignes['id_adresse'].'">'.$lignes['numero_adresse'].' '.$complement.' '.$lignes['rue_adresse'].' '.$lignes['code_postal_adresse'].' '.$lignes['ville_adresse'].' '.$lignes['nom_fr_fr'].'</option>';

    }

    foreach ($facturations as $lignes) {
        if (isset($lignes['complement_adresse'])) {
            $complement = $lignes['complement_adresse'];
        }
        else {
            $complement = '';
        }
        $adresses_facturation .= '<option value="'.$lignes['id_adresse'].'">'.$lignes['numero_adresse'].' '.$complement.' '.$lignes['rue_adresse'].' '.$lignes['code_postal_adresse'].' '.$lignes['ville_adresse'].' '.$lignes['nom_fr_fr'].'</option>';
    }

    //-------------------------------------------------
    // création d'un identifiant unique à 6 characters. 
    //-------------------------------------------------
    do {
        $token = bin2hex(random_bytes(3));
        // test si token unique
        $test = req_token_unique($bdd,$token,'factures');

    } while ($test != 0);

    //-------------------
    // frais de port
    //-------------------
    $zone1 = [6,75,140];
    $zone2 = [91,136,76,180,50,188,243,244];
    $zone3 = [153,77,237,78];
    $zone4 = [12,18,31,84,57,55,60,203,68,73,88,101,107,109,123,127,128,135,150,174,175,58,181,197,199,209,210,228,126,190,98];
    $zone5 = [2,4,22,161,125,144,219,204,137,34,86,226,142,242,225];

    if (in_array($livraisons[0]['id_pays'], $zone1)) {
        // $zone1 = ['france','monaco','andorre'];
        $zone_livraison = 1;
    }
    elseif (in_array($livraisons[0]['id_pays'], $zone2)) {
        // $zone2 =  outre mer partie 1
        $zone_livraison = 2;
    }
    elseif (in_array($livraisons[0]['id_pays'], $zone3)) {
        // $zone3 =  outre mer partie 2 
        $zone_livraison = 3;
    }
    elseif (in_array($livraisons[0]['id_pays'], $zone4)) {
        // $zone4 =  UE, suisse et royaume unis
        $zone_livraison = 4;
    }
    elseif (in_array($livraisons[0]['id_pays'], $zone5)) {
        // $zone5 =  Magreb, norvège et europe de l'est hors ue et russie
        $zone_livraison = 5;
    }
    else {
        // // zone 6 tout le reste
        $zone_livraison = 6;
    }

    $devis_test = req_devis_v($bdd,$id_commande);
    if (isset($devis_test['id_livraison'])) {
        // si il existe un montant de devis livraison : payer 
        $btn_envoyer = 'Passer au payement';
        $destination = "index.php?page=207&cas=1";
        $frais = number_format($devis_test['prix_livraisons'],2,'.',' ');
        $frais_de_port = $frais;
    }
    elseif ($poids_livraison > 15000 || $devis_livraison == 1 || $dimension_totale > 150) {
        // si supérieur à 15kg, ou dimension trop grande ou devis obligatoire :  devis livraison
        $btn_envoyer = 'Demander un devis livraison';
        $destination = "index.php?page=206";
        $frais = 'En attende de devis';
    }
    else {
        // prend la valeur des frais de port en fonction du poids et l'ajoute au total_TTC
        $btn_envoyer = 'Valider et passer au payement';
        $destination = "index.php?page=207&cas=0";
        $frais_de_port = req_frais_de_port($bdd,$poids_livraison,$zone_livraison);
        $frais = number_format($frais_de_port,2,'.',' ');
    }
    // ajout des frais de port au total
    $total_TTC += $frais_de_port;


    // btn payer envoie vers la banque et une foi payer à la banque renvoie sur une page caché ? (autre possibilité : écrit merci pour votre confiance plus récapitulatif de la commande avec message commande sera confirmé à la reception de votre payement)

?>