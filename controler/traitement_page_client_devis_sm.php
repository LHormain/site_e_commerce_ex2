<?php
    //--------------------------------------------
    // les demandes de devis sur mesure du client
    // connecté
    //--------------------------------------------
    $demande_sm = req_devis_sm($bdd);
    $table_sm = '';

    foreach ($demande_sm as $ligne) {
        // lien pour télécharger un devis
        if ($ligne['fichier_devis_sm'] != NULL) {
            $lien = '<a href="public/assets/devis/'.$ligne['fichier_devis_sm'].'" download="'.$ligne['fichier_devis_sm'].'">Télécharger</a>';
        }
        else {
            $lien = "";
        }
        // lien pour télécharger la facture
        if ($ligne['fichier_facture_sm'] != NULL) {
            $lien2 = '<a href="public/assets/devis/'.$ligne['fichier_facture_sm'].'" download="'.$ligne['fichier_facture_sm'].'">Télécharger</a>';
        }
        else {
            $lien2 = "";
        }

        $table_sm .= '
        <tr
            class=""
        >
            <td scope="row">'.date('d/m/Y à H:i', $ligne['date_contact']).'</td>
            <td>'.$ligne['nom_etat'].'</td>
            <td>'.$lien.'</td>
            <td>'.$lien2.'</td>
        </tr>
        ';
    }

    //--------------------------------------
    // construction de la page
    //--------------------------------------
    $page_courante = '
    <div class="row">
        <h2 class="fs-5 offset-1 col-10 text-center text-md-start" id="top">Mes demandes de devis sur mesure</h2>
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
                        <th>Devis</th>
                        <th>Factures</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    '.$table_sm.'
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
    </div>
    ';
?>