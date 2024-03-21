<?php
$texte_page_courante = '';

if (isset($_GET['id']) && $_GET['id']) {
    $id_contact = intval($_GET['id']);

    //-------------------------------------------
    // traitement de l'ajout d'un fichier devis
    //-------------------------------------------
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
                $devis = req_devis($bdd,$id_contact);
                if ($devis['fichier_devis_sm'] != NULL) {
                    // si oui le supprime
                    if (file_exists($dossier."/".$devis['fichier_devis_sm'])) {
                        unlink($dossier."/".$devis['fichier_devis_sm']);
                    }
                }
                // update le devis avec le nom du fichier fichier
                req_insert_devis_sur_mesure($bdd,htmlspecialchars($nom_fichier),$id_contact);

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
                $devis = req_devis($bdd,$id_contact);
                if ($devis['fichier_facture_sm'] != NULL) {
                    // si oui le supprime
                    if (file_exists($dossier."/".$devis['fichier_facture_sm'])) {
                        unlink($dossier."/".$devis['fichier_facture_sm']);
                    }
                }
                // update le devis avec le nom du fichier fichier
                req_insert_facture_sur_mesure($bdd,htmlspecialchars($nom_fichier),$id_contact);

                $texte_page_courante = "Le devis a bien été enregistré.";
            }
        }
    }
    //---------------------------
    // affichage de la page
    //---------------------------
    req_lu_contact($bdd, $id_contact);
    $contact = req_contact($bdd, $id_contact);
    $devis = req_devis($bdd,$id_contact);

    $etats = req_etat_devis($bdd);
    $select = options_select($etats,$devis['id_etat']);
}

?>