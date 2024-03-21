<?php
//--------------------------------------------------------
// création de la page de récapitulatif des ateliers 
// pour le client connecté
//--------------------------------------------------------
    // récupération des réservations
    $inscriptions = req_ts_ateliers_client($bdd);
    $table_atelier = '';

    foreach ($inscriptions as $ligne) {
        if ($ligne['fichier_facture'] != NULL) {
            $facture = '<a href="public/assets/devis/'.$ligne['fichier_facture'].'" download="'.$ligne['fichier_facture'].'">Télécharger</a>';
        }
        else {
            $facture = '';
        }

        $table_atelier .= '
        <tr
            class=""
        >
            <td scope="row">'.date('d/m/Y à H:i', $ligne['date_atelier']).'</td>
            <td>'.$ligne['nom_atelier'].'</td>
            <td>'.$ligne['nbr_inscrit'].'</td>
            <td>'.$ligne['nom_etat_commande'].'</td>
            <td>'.$facture.'</td>
        </tr>
        ';
    }

    $page_courante = '
    <div class="row">
        <h2 class="fs-5 offset-1 col-10 text-center text-md-start" id="top">Mes ateliers</h2>
        <div
            class="table-responsive offset-1 col-10 "
        >
            <table
                class="table  table-hover table-borderless  align-start"
            >
                <thead class="table-light">
                    <caption>
                    </caption>
                    <tr>
                        <th>Horaire</th>
                        <th>Nom de l\'atelier</th>
                        <th>Nombre de place réservé</th>
                        <th>État</th>
                        <th>Facture</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    '.$table_atelier.'
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
    </div>
    ';

?>

