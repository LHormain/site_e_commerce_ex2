<?php
//---------------------------------------------------------------------
//                           supprimer
//---------------------------------------------------------------------
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_produit = intval($_GET['sup']);
    // supprime les images
    // dossier
    $images = req_images_produit($bdd,$id_produit);
    if ($images[1] != 0) {
        foreach ($images[0] as $donnees) {
            $chemin = '../public/assets/img/produits/'.$donnees['nom_img_produit'];
            if (file_exists($chemin)) {
                unlink($chemin);
            }
        }
    }
    // BDD
    req_sup_produit($bdd,$id_produit);
}

//---------------------------------------------------------------------
//                           affichage
//---------------------------------------------------------------------

// récupération de la section à afficher
if (isset($_POST['section']) && $_POST['section'] != NULL) { 
    // si on viens du formulaire de choix de la section
    $id_section = intval($_POST['section']);
}
elseif (isset($_GET['s']) && $_GET['s'] != NULL) {
    // si on ordonne les résultats de la recherche
    $id_section = intval($_GET['s']);
}
$section = req_section($bdd,$id_section);

// classement des résultats de la recherche en BDD
if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
    $ordre = intval($_GET['ordre']);

    if ($ordre == 1) {
        $ordre_req = 'ORDER BY produits.nom_produit';
    }
    elseif ($ordre == 2) {
        $ordre_req = 'ORDER BY categories.nom_categorie';
    }
    elseif ($ordre == 3) {
        $ordre_req = 'ORDER BY filtres.nom_filtre';
    }
    elseif ($ordre == 4) {
        $ordre_req = 'ORDER BY produits.prix_ht_produit';
    }
    elseif ($ordre == 5) {
        $ordre_req = 'ORDER BY produits.stock_produit';
    }
    elseif ($ordre == 6) {
        $ordre_req = 'ORDER BY produits.piece_unique DESC';
    }
    elseif ($ordre == 7) {
        $ordre_req = 'ORDER BY produits.promo_produit DESC';
    }
    else {
        $ordre_req = 'ORDER BY produits.id_produit';
    }
}
else {
    $ordre_req = 'ORDER BY produits.id_produit';
}

$produits = req_produits($bdd,$id_section,$ordre_req);

$table = table_produits($bdd,$produits);
?>