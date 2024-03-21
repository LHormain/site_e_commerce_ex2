<?php
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_commande = intval($_GET['id']);

    //-----------------------------------
    // ajout d'une copie de la facture
    //-----------------------------------
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
                $si_facture = req_facture_v_unique($bdd,$id_commande);
                if ($si_facture['fichier_facture'] != NULL) {
                    // si oui le supprime
                    if (file_exists($dossier."/".$si_facture['fichier_facture'])) {
                        unlink($dossier."/".$si_facture['fichier_facture']);
                    }
                }
                // update le devis avec le nom du fichier fichier
                req_insert_facture($bdd,htmlspecialchars($nom_fichier),$si_facture['id_facture']);
    
                $texte_page_courante = "La facture a bien été enregistrée.";
            }
        }
    }

    //--------------------------
    // traitement de la page
    //--------------------------

    if (isset($_GET['c']) && $_GET['c'] != NULL) {
        $c = intval($_GET['c']);

        if ($c == 1) {
            // détail du panier
            $panier = req_panier_vente($bdd,$id_commande);
            $page = 600;
            $titre = 'Panier';
        }
        elseif ($c == 2) {
            // détail de la commande
            $panier = req_commande_vente($bdd,$id_commande);
            $page = 610;
            $titre = 'Commande';

            $facture = req_facture($bdd,$id_commande); 
        }
        elseif ($c == 3) {
            // détail de la commande
            $panier = req_commande_vente($bdd,$id_commande);
            $page = 620;
            $titre = 'Commande';

            $facture = req_facture($bdd,$id_commande); 
        }

        $table = '';
        $prix = 0;
        foreach ($panier[0] as $ligne) {
            $sous_total = $ligne['quantite_produit']*$ligne['prix_unitaire'];
            $prix += $sous_total;

            $table .= '
            <tr class="table-anticbeige">
                <td>'.$ligne['id_produit'].'</td>
                <td>'.$ligne['nom_produit'].'</td>
                <td>'.$ligne['quantite_produit'].'</td>
                <td>'.$ligne['prix_unitaire'].'</td>
                <td>'.number_format($sous_total,2,'.', ' ').'</td>
                <td>'.number_format($sous_total*(1+20/100),2,'.',' ').'</td>
            </tr>
            ';
        }
    }
}
?>