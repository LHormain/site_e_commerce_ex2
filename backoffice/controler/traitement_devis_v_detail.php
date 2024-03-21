<?php
$texte_page_courante ='';
//------------------------------------------
// affichage des données
//------------------------------------------

if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_commande = intval($_GET['id']);

    $devis = req_devis_v($bdd,$id_commande);
    $facture = req_facture($bdd,$id_commande);

    $prix_livraisons = $devis['prix_livraisons'];

    $nbr_produits = 0;
    $poids_livraison = 0;
    $dimension_livraison = 0;
    $dimension_totale = 0;

    $produits = req_commande_vente_detail($bdd,$id_commande);

    foreach ($produits as $lignes) {
        $nbr_produits += 1;
        $poids_livraison += $lignes['poids_produit'];
        $taille = req_produit_taille_select($bdd,$lignes['id_produit']);
        $dimension_livraison = $taille['longueur']+$taille['largeur']+$taille['hauteur'];
        $dimension_totale += $taille['longueur']*$taille['largeur']*$taille['hauteur'];

    }

    // change état à lu 
    req_devis_dl_lu($bdd,$id_commande);
}

//------------------------------------------
// traitement des données supplémentaires
//------------------------------------------
// enregistrement prix de livraison et changement de statue de en attente de traitement à en attente de réponse du client
if (isset($_POST['prix_livraison']) && $_POST['prix_livraison'] != NULL) {
    $prix_livraisons = htmlspecialchars($_POST['prix_livraison']);

    // enregistre le prix
    req_update_prix_dl($bdd,$prix_livraisons,$id_commande);

}

// enregistrement d'un fichier devis
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
            $devis = req_devis_v($bdd,$id_commande);
            if ($devis['fichier_devis_livraison'] != NULL) {
                // si oui le supprime
                if (file_exists($dossier."/".$devis['fichier_devis_livraison'])) {
                    unlink($dossier."/".$devis['fichier_devis_livraison']);
                }
            }
            // update le devis avec le nom du fichier fichier
            req_update_fichier_dl($bdd,$nom_fichier,$id_commande);

            $texte_page_courante = "Le devis a bien été enregistré.";
        }
    }
}

// rechargement des nouvelles données
$devis = req_devis_v($bdd,$id_commande);
$facture = req_facture($bdd,$id_commande);

$prix_livraisons = $devis['prix_livraisons'];

?>