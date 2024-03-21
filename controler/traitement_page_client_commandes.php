<?php
//----------------------------------------------
// création de la page de gestion des commandes
// vente du client connecté
//----------------------------------------------
    //------------------------------
    // annulation d'une commande
    //------------------------------
    if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
        $id_livraison = intval($_GET['sup']);

        req_annulation_commande($bdd,$id_livraison);
    }
    //------------------------------
    //gestion de la page
    //------------------------------
    if (isset($_GET['d']) && $_GET['d'] != NULL) {
        $d = intval($_GET['d']);
    }
    else {
        $d = 0;
    }
    // récupération des commandes
    $table = '';
    $id_user = req_id_client($bdd);
    $commandes = req_commandes_ventes_client($bdd,$id_user['id_user']);

    foreach ($commandes as $ligne) {
        // cherche si devis livraison associé
        $cherche_devis = req_devis_v($bdd,$ligne['id_commande']);
        if ($cherche_devis != NULL ) {
            $devis = '<a href="index.php?page=400&c=3&d='.$cherche_devis['id_livraison'].'#devis'.$cherche_devis['id_livraison'].'">voir le devis</a>';
            $prix = number_format($ligne['montant_commande'],2,',',' ');
            // met en valeur la ligne du devis sélectionner sur le tableau commande
            if ($d == $cherche_devis['id_livraison']) {
                $couleur = 'table-sable';
            }
            else {
                $couleur = '';
            }
        }
        else {
            $devis = 'pas de devis';
            $prix = number_format($ligne['montant_commande'],2,',',' ');
            $couleur = '';
        }
        
        // si il y a une copie de la facture
        if ($ligne['fichier_facture'] != NULL) {
            $facture = '<a href="public/assets/devis/'.$ligne['fichier_facture'].'" download="'.$ligne['fichier_facture'].'">Télécharger</a>';
        }
        else {
            $facture = '';
        }

        $table .= '
        <tr
            class="'.$couleur.'"
        >
            <td scope="row">'.date('d/m/Y à H:i', $ligne['date_commande']).'</td>
            <td>'.$ligne['id_commande'].'</td>
            <td>'.$ligne['nom_etat_commande'].'</td>
            <td>'.$ligne['nom_etat_livraison'].'</td>
            <td>'.$prix.'</td>
            <td>'.$devis.'</td>
            <td>'.$facture.'</td>
        </tr>
        ';
    }
    //--------------------------------------
    // les demandes de devis livraisons
    //--------------------------------------
    $table_liv = '';
    $demande_liv = req_devis_v_client($bdd,$id_user['id_user']);


    foreach ($demande_liv as $ligne) {
        // lien pour télécharger un devis
        if ($ligne['fichier_devis_livraison'] != NULL) {
            $lien = '<a href="public/assets/devis/'.$ligne['fichier_devis_livraison'].'" download="'.$ligne['fichier_devis_livraison'].'">Télécharger</a>';
        }
        else {
            $lien = "";
        }

        // met en valeur la ligne du devis sélectionner sur le tableau commande
        if ($d == $ligne['id_livraison']) {
            $couleur = 'table-sable';
        }
        else {
            $couleur = '';
        }

        // lien pour annuler commande
        if ( $ligne['id_etat'] == 5) {
            $annuler = '<a href="index.php?page=400&c=3&sup='.$ligne['id_livraison'].'">Annuler la commande</a>';
            $payer = '<a href="index.php?page=205&id='.$ligne['id_commande'].'" class="btn btn-gris-souris rounded-pill">Payer</a></td>';
        }
        elseif ($ligne['id_etat'] == 1 ) {
            $annuler = '<a href="index.php?page=400&c=3&sup='.$ligne['id_livraison'].'">Annuler la commande</a>';
            $payer = '';
        }
        elseif ($ligne['id_etat'] == 4) {
            $annuler = '-';
            $payer = '';
        }
        else {
            $annuler = "Pour tous renseignements, contacter nous";
            $payer = '';
        }

        $table_liv .= '
        <tr
            class="'.$couleur.' "
            id="devis'.$ligne['id_livraison'].'"
        >
            <td scope="row">'.date('d/m/Y à H:i', $ligne['date_commande']).'</td>
            <td>'.number_format($ligne['montant_commande']-$ligne['prix_livraisons'],2,',',' ').'</td>
            <td>'.number_format($ligne['prix_livraisons'],2,',',' ').'</td>
            <td>'.number_format($ligne['montant_commande'],2,',',' ').'</td>
            <td>'.$ligne['nom_etat'].'</td>
            <td>'.$lien.'</td>
            <td>'.$payer.'
            <td>'.$annuler.'</td>
        </tr>
        ';
    }
    //--------------------------------------
    // construction de la page
    //--------------------------------------
    $page_courante = '
    <div class="row">
        <h2 class="fs-5 offset-1 col-10 text-center text-md-start" id="top">Mes commandes</h2>
        <div
            class="table-responsive offset-1 col-10  "
        >
            <table
                class="table  table-hover table-borderless  align-start "
            >
                <thead class="table-light">
                    <caption>
                    </caption>
                    <tr class="">
                        <th>Date</th>
                        <th>N° de commande</th>
                        <th>État commande</th>
                        <th>État livraison</th>
                        <th>Montant TTC en €</th>
                        <th>Devis associé</th>
                        <th>Facture</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    '.$table.'
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
        <h2 class="fs-5 offset-1 col-10 text-center text-md-start">Devis livraison</h2>
        <div
            class="table-responsive offset-1 col-10 "
        >
            <table
                class="table  table-hover table-borderless  align-start "
            >
                <thead class="table-light">
                    <caption>
                    </caption>
                    <tr>
                        <th>Date de la demande</th>
                        <th>Montant des achats TTC en €</th>
                        <th>Montant du devis livraison en €</th>
                        <th>Montant total à payer en €</th>
                        <th>État de la demande</th>
                        <th>Devis</th>
                        <th>Valider et passer au payement</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    '.$table_liv.'
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
    </div>
    ';

?>