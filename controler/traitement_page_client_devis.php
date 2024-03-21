<?php
//--------------------------------------------------------------
// création de la page contenant les devis événementiel 
// du client connecté
//--------------------------------------------------------------

    $id_user = req_id_client($bdd);
    //-----------------------------------------
    // les demandes de devis événementiel/location
    //-----------------------------------------
    $table_loc = '';
    $demande_loc = req_devis_l_client($bdd,$id_user['id_user']);

    foreach ($demande_loc as $ligne) {
        // modification d'un devis en attente de traitement
        if ($ligne['id_etat'] == 1) {
            $modifier = '<a href="index.php?page=212&mod=1"><img src="public/assets/img/icones/roue-dentee.png" class="img-fluis icones"></a>';
        }
        else {
            $modifier = 'Cette demande ne peu être modifiée';
        }

        // lien pour télécharger un devis
        if ($ligne['fichier_devis_location'] != NULL) {
            $lien = '<a href="public/assets/devis/'.$ligne['fichier_devis_location'].'" download="'.$ligne['fichier_devis_location'].'">Télécharger</a>';
        }
        else {
            $lien = "";
        }

        $table_loc .= '
        <tr
            class=""
        >
            <td scope="row">'.date('d/m/Y à H:i', $ligne['date_devis']).'</td>
            <td>'.$ligne['nom_etat'].'</td>
            <td>'.$modifier.'</td>
            <td>'.$lien.'</td>
            <td></td>
        </tr>
        ';
    }



    //--------------------------------------
    // construction de la page
    //--------------------------------------
    $page_courante = '
    <div class="row">
        <h2 class="fs-5 offset-1 col-10 mb-lg-5 mb-3 text-center text-md-start" id="top">Mes demandes de devis événementiel</h2>
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
                        <th>Date de la demande</th>
                        <th>État de la demande</th>
                        <th>Modifier la demande</th>
                        <th>Devis</th>
                        <th>Factures</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    '.$table_loc.'
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
    </div>
    ';
?>


