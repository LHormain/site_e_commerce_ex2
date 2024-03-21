<?php

if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_devis = intval($_GET['id']);

    //--------------------------------------------
    // traitement de l'ajout d'un fichier devis
    //--------------------------------------------
    $dossier = '../public/assets/devis';
    $timestamp = time();

    if (isset($_FILES['file']) && $_FILES['file'] != NULL) {
        $extensions_valides = array('pdf','PDF','docx','DOCX','docm','DOCM','dotx','DOTX','dotm','DOTM');
        $extension_upload = substr(strrchr($_FILES['file']['name'],'.'),1);
        
        if(in_array($extension_upload, $extensions_valides)) {
            $nom_fichier = trim_image_name($_FILES['file']['name']).$timestamp.'.'.$extension_upload;
            $chemin = $dossier."/".$nom_fichier; 
            
            $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin); 
            if($resultat) {
                // test si le devis a deja un fichier
                $devis = req_devis_l_unique($bdd,$id_devis);
                if ($devis['fichier_devis_location'] != NULL) {
                    // si oui le supprime
                    if (file_exists($dossier."/".$devis['fichier_devis_location'])) {
                        unlink($dossier."/".$devis['fichier_devis_location']);
                    }
                }
                // update le devis avec le nom du fichier fichier
                req_insert_devis_location($bdd,htmlspecialchars($nom_fichier),$id_devis);

                $texte_page_courante = "Le devis a bien été enregistré.";
            }
        }
    }
    if (isset($_FILES['file2']) && $_FILES['file2'] != NULL) {
        $extensions_valides = array('pdf','PDF','docx','DOCX','docm','DOCM','dotx','DOTX','dotm','DOTM');
        $extension_upload = substr(strrchr($_FILES['file2']['name'],'.'),1);
        
        if(in_array($extension_upload, $extensions_valides)) {
            $nom_fichier = trim_image_name($_FILES['file2']['name']).$timestamp.'.'.$extension_upload;
            $chemin = $dossier."/".$nom_fichier; 
            
            $resultat = move_uploaded_file($_FILES['file2']['tmp_name'], $chemin); 
            if($resultat) {
                // test si le devis a deja un fichier
                $devis = req_devis_l_unique($bdd,$id_devis);
                if ($devis['fichier_facture_location'] != NULL) {
                    // si oui le supprime
                    if (file_exists($dossier."/".$devis['fichier_facture_location'])) {
                        unlink($dossier."/".$devis['fichier_facture_location']);
                    }
                }
                // update le devis avec le nom du fichier fichier
                req_insert_facture_location($bdd,htmlspecialchars($nom_fichier),$id_devis);

                $texte_page_courante = "Le devis a bien été enregistré.";
            }
        }
    }
    //---------------------------------
    // traitement affichage page 
    //---------------------------------
    $devis = req_devis_l_unique($bdd,$id_devis);
    // update le statu du devis à lu
    req_devis_l_lu($bdd,$id_devis);

    // crée le select pour l'état du devis
    $etats_devis = req_etat_devis($bdd);
    $select_devis = '
    
    <select class="form-select form-select-lg" id="select_etat">
    ';
    foreach ($etats_devis as $lignes) {
        if ($lignes['id_etat'] == 1 && $devis['id_etat'] > 1) {
            $etat = 'disabled';
        }
        elseif ($lignes['id_etat'] == $devis['id_etat']) {
            $etat = 'selected';
        }
        else {
            $etat = '';
        }
        $select_devis .= '<option value="'.$lignes['id_etat'].'" '.$etat.'>'.$lignes['nom_etat'].'</option>';
    }
    $select_devis .= '</select>
    <label for="" class="form-label">État</label>';
}


?>

