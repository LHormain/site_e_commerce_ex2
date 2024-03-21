<?php
$titre = '';
$texte_page_courante = '';
// -----------------------------
// récupération des section 
// -----------------------------
$sections = req_sections($bdd);
$couleurs_init = req_couleurs($bdd,'ORDER BY ordre_affichage');
$matieres_init = req_matieres($bdd,'ORDER BY ordre_affichage');
$tailles_init = req_tailles($bdd,'ORDER BY ordre_affichage');
$customisations_init = req_customisations($bdd,'ORDER BY ordre_affichage');

// récupération des données pour une update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_produit = intval($_GET['id']);
    
    $titre = "Modification d'un nouveau produit";
    $produit = req_produit($bdd, $id_produit);
    $nom_produit = $produit['nom_produit'];
    $description_produit = $produit['description_produit'];
    $prix_ht_produit = $produit['prix_ht_produit'];
    $origine_produit = $produit['origine_produit'];
    $estim_tps_livraison = $produit['estim_tps_livraison'];
    $devis = $produit['devis_obligatoire'];

    $dimensions_produit = req_dimensions_produit($bdd,$id_produit);
    if ($dimensions_produit[1] >= 1) {
        $longueur_ref_produit = $dimensions_produit[0][0]['longueur'];
        $largeur_ref_produit = $dimensions_produit[0][0]['largeur'];
        $hauteur_ref_produit = $dimensions_produit[0][0]['hauteur'];
        $id_taille_ref = $dimensions_produit[0][0]['id_taille'];
    }
    else {
        $longueur_ref_produit = 0;
        $largeur_ref_produit = 0;
        $hauteur_ref_produit = 0;
        $id_taille_ref = '';
    }
    $select_jeux_tailles = select_dimensions($bdd,$dimensions_produit[0]);

    $poids_produit = $produit['poids_produit'];
    $customisable = $produit['customisable'];
    $promo_produit = $produit['promo_produit'];
    
    $select = select_sections($sections,$produit['id_section']);

    $categories = req_categories($bdd,$produit['id_section']);
    $select_cat = select_cat($categories,$produit['id_cat']);
    
    $filtres = req_sous_categories($bdd,$produit['id_section']);
    $select_filtre = select_filtre($filtres,$produit['id_filtre']);

    $select_couleurs = select_box($bdd,$couleurs_init,'couleurs',$id_produit);
    $select_matieres = select_box($bdd,$matieres_init,'matieres',$id_produit);
    $select_custom = select_box($bdd,$customisations_init,'customisations',$id_produit);
    $select_tailles = select_tailles($bdd,$tailles_init,$id_produit);
}
else {
    $titre = "Saisie d'un nouveau produit";
    $nom_produit = "";
    $description_produit = "";
    $prix_ht_produit = 0;
    $origine_produit = "";
    $longueur_ref_produit = "";
    $largeur_ref_produit = "";
    $hauteur_ref_produit = "";
    $poids_produit = "";
    $id_taille_ref = '';
    $customisable = 0;
    $promo_produit = 0;
    $estim_tps_livraison = '';
    $devis = 1;
    
    $select = select_sections($sections,0);

    $categories = req_categories($bdd,$sections[0]['id_section']);
    $select_cat = select_cat($categories,0);

    $filtres = req_sous_categories($bdd,$sections[0]['id_section']);
    $select_filtre = select_filtre($filtres,0);

    // création des checkbox pour la customisation
    $select_couleurs = select_box($bdd,$couleurs_init,'couleurs',0);
    $select_matieres = select_box($bdd,$matieres_init,'matieres',0);
    $select_custom = select_box($bdd,$customisations_init,'customisations',0);
    $select_tailles = select_tailles($bdd,$tailles_init,0);
    $select_jeux_tailles = '';
}
//----------------------
// traitement
//----------------------
if (isset($_POST['nom_produit'],
        $_POST['description_produit'],
        $_POST['section'],
        $_POST['id_cat'],
        $_POST['id_filtre'],
        $_POST['prix_ht_produit'],
        $_POST['longueur_ref_produit'],
        $_POST['largeur_ref_produit'],
        $_POST['hauteur_ref_produit'],
        $_POST['poids_produit'],
        $_POST['customisable'],
        $_POST['promo_produit'],
        $_POST['origine_produit'],
        $_POST['estim_tps_livraison'],
        $_POST['devis_obligatoire']
)
&& $_POST['nom_produit'] != NULL
&& $_POST['description_produit'] != NULL
&& $_POST['section'] != NULL
&& $_POST['id_cat'] != NULL
&& $_POST['id_filtre'] != NULL
&& $_POST['prix_ht_produit'] != NULL
&& $_POST['longueur_ref_produit'] != NULL
&& $_POST['largeur_ref_produit'] != NULL
&& $_POST['hauteur_ref_produit'] != NULL
&& $_POST['poids_produit'] != NULL
&& $_POST['customisable'] != NULL
&& $_POST['promo_produit'] != NULL
&& $_POST['origine_produit'] != NULL
&& $_POST['estim_tps_livraison'] != NULL
&& $_POST['devis_obligatoire'] != NULL
) {
    $nom_produit = htmlspecialchars($_POST['nom_produit']);
    $description_produit = htmlspecialchars($_POST['description_produit']);
    $section = intval($_POST['section']);
    $id_cat = intval($_POST['id_cat']);
    $id_filtre = intval($_POST['id_filtre']);
    $prix_ht_produit = htmlspecialchars($_POST['prix_ht_produit']);
    $longueur_ref_produit = htmlspecialchars($_POST['longueur_ref_produit']);
    $largeur_ref_produit = htmlspecialchars($_POST['largeur_ref_produit']);
    $hauteur_ref_produit = htmlspecialchars($_POST['hauteur_ref_produit']);
    $poids_produit = htmlspecialchars($_POST['poids_produit']);
    $customisable = intval($_POST['customisable']);
    $promo_produit = intval($_POST['promo_produit']);
    $origine_produit = htmlspecialchars($_POST['origine_produit']);
    $estim_tps_livraison = htmlspecialchars($_POST['estim_tps_livraison']);
    $devis_obligatoire = intval($_POST['devis_obligatoire']);

    // si les données numériques entrées contiennent une virgule, les remplaces par un point.
    if (str_contains($prix_ht_produit, ',')) {
        $prix_ht_produit = str_replace(',', '.', $prix_ht_produit);
    }
    if (str_contains($poids_produit, ',')) {
        $poids_produit = str_replace(',', '.', $poids_produit);
    }
    // if (str_contains($longueur_ref_produit, ',')) {
    //     $longueur_ref_produit = str_replace(',', '.', $longueur_ref_produit);
    // }
    // if (str_contains($largeur_ref_produit, ',')) {
    //     $largeur_ref_produit = str_replace(',', '.', $largeur_ref_produit);
    // }
    // if (str_contains($hauteur_ref_produit, ',')) {
    //     $hauteur_ref_produit = str_replace(',', '.', $hauteur_ref_produit);
    // }

    //---------------------------------------------
    // enregistrement des données principales
    //---------------------------------------------
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ){
        $id_produit = intval($_GET['id']);
        if (isset($_POST['id_taille_ref']) && $_POST['id_taille_ref'] != NULL) {
            $id_taille_ref = intval($_POST['id_taille_ref']);
        }
        // UPDATE 
        req_update_produit($bdd,
                           $id_produit,
                           $nom_produit,
                           $description_produit,
                           $id_cat,
                           $id_filtre,
                           $prix_ht_produit,
                           $longueur_ref_produit,
                           $largeur_ref_produit,
                           $hauteur_ref_produit,
                           $poids_produit,
                           $customisable,
                           $promo_produit,
                           $id_taille_ref,
                           $origine_produit,
                           $estim_tps_livraison,
                           $devis_obligatoire);
    }
    else {
        // INSERT
        $id_produit = req_insert_produit($bdd,
                           $nom_produit,
                           $description_produit,
                           $id_cat,
                           $id_filtre,
                           $prix_ht_produit,
                           $poids_produit,
                           $customisable,
                           $promo_produit,
                           $origine_produit,
                           $estim_tps_livraison,
                           $devis_obligatoire);
        $id_dimension = req_dimensions_produit_insert($bdd,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$id_produit,0);
    }
    //---------------------------------------------------------
    // enregistrement des données customisable si elles existe
    //---------------------------------------------------------

        //couleurs

    if (isset($_POST['couleurs'],$_POST['prix_couleurs']) 
    && $_POST['couleurs'] != NULL
    && $_POST['prix_couleurs'] != NULL
    && $customisable == 1
    ) {
        // cas checkbox/ customisable
        $couleurs = $_POST['couleurs'];
        $prix_couleurs = $_POST['prix_couleurs'];

        // création d'un array prix sans les entrées  nulles
        $i = 0;
        foreach ($prix_couleurs as $prix) {
            if (isset($prix) && $prix != NULL) {
                $prix_array[$i] = htmlspecialchars($prix);
                $i++;
            }
        }

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            //update (efface les anciens et enregistre les nouveaux)
            req_custom_couleur_sup($bdd,$id_produit);

            $i = 0;
            foreach ($couleurs as $couleur) {
                req_custom_couleur_insert($bdd,$id_produit,intval($couleur),$prix_array[$i]);
                $i++;
            }
        }
        else {
            //insert
            $i = 0;
            foreach ($couleurs as $couleur) {
                req_custom_couleur_insert($bdd,$id_produit,intval($couleur),$prix_array[$i]);
                $i++;
            }
        }
    }
    elseif (isset($_POST['couleurs_r']) 
        && $_POST['couleurs_r'] != NULL
        && $customisable == 0
        ) {
        // cas radio /non customisable
        $couleur = intval($_POST['couleurs_r']);

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            $id_produit = intval($_GET['id']);
            //update (efface l'ancien et enregistre le nouveau)
            req_custom_couleur_sup($bdd,$id_produit);
            req_custom_couleur_insert($bdd,$id_produit,$couleur,0);
        }
        else {
            //insert
            req_custom_couleur_insert($bdd,$id_produit,$couleur,0);
        }
    }

        //matières
        
    if (isset($_POST['matieres'],$_POST['prix_matieres']) 
    && $_POST['matieres'] != NULL
    && $_POST['prix_matieres'] != NULL
    && $customisable == 1
    ) {
        // cas checkbox/ customisable
        $matieres = $_POST['matieres'];
        $prix_matieres = $_POST['prix_matieres'];

        // création d'un array prix sans les entrées  nulles
        $i = 0;
        foreach ($prix_matieres as $prix) {
            if (isset($prix) && $prix != NULL) {
                $prix_array[$i] = htmlspecialchars($prix);
                $i++;
            }
        }

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            //update (efface les anciens et enregistre les nouveaux)
            req_custom_matiere_sup($bdd,$id_produit);

            $i = 0;
            foreach ($matieres as $matiere) {
                req_custom_matiere_insert($bdd,$id_produit,intval($matiere),$prix_array[$i]);
                $i++;
            }
        }
        else {
            //insert
            $i = 0;
            foreach ($matieres as $matiere) {
                req_custom_matiere_insert($bdd,$id_produit,intval($matiere),$prix_array[$i]);
                $i++;
            }
        }
    }
    elseif (isset($_POST['matieres_r']) 
        && $_POST['matieres_r'] != NULL
        && $customisable == 0
        ) {
        // cas radio /non customisable
        $matiere = intval($_POST['matieres_r']);

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            $id_produit = intval($_GET['id']);
            //update (efface l'ancien et enregistre le nouveau)
            req_custom_matiere_sup($bdd,$id_produit);
            req_custom_matiere_insert($bdd,$id_produit,$matiere,0);
        }
        else {
            //insert
            req_custom_matiere_insert($bdd,$id_produit,$matiere,0);
        }
    }

        //autre customisations
        
    if (isset($_POST['customisations'],$_POST['prix_customisations']) 
    && $_POST['customisations'] != NULL
    && $_POST['prix_customisations'] != NULL
    && $customisable == 1
    ) {
        // cas checkbox/ customisable
        $customisations = $_POST['customisations'];
        $prix_customisations = $_POST['prix_customisations'];

        // création d'un array prix sans les entrées  nulles
        $i = 0;
        foreach ($prix_customisations as $prix) {
            if (isset($prix) && $prix != NULL) {
                $prix_array[$i] = htmlspecialchars($prix);
                $i++;
            }
        }

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            //update (efface les anciens et enregistre les nouveaux)
            req_custom_customisation_sup($bdd,$id_produit);

            $i = 0;
            foreach ($customisations as $customisation) {
                req_custom_customisation_insert($bdd,$id_produit,intval($customisation),$prix_array[$i]);
                $i++;
            }
        }
        else {
            //insert
            $i = 0;
            foreach ($customisations as $customisation) {
                req_custom_customisation_insert($bdd,$id_produit,intval($customisation),$prix_array[$i]);
                $i++;
            }
        }
    }
    elseif (isset($_POST['customisations_r']) 
        && $_POST['customisations_r'] != NULL
        && $customisable == 0
        ) {
        // cas radio /non customisable
        $customisation = intval($_POST['customisations_r']);

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            $id_produit = intval($_GET['id']);
            //update (efface l'ancien et enregistre le nouveau)
            req_custom_customisation_sup($bdd,$id_produit);
            req_custom_customisation_insert($bdd,$id_produit,$customisation,0);
        }
        else {
            //insert
            req_custom_customisation_insert($bdd,$id_produit,$customisation,0);
        }
    }

        // tailles
        // update les jeux de dimensions existants
    if (isset($_POST['longueur'],
        $_POST['largeur'],
        $_POST['hauteur'],
        $_POST['prix_dimensions'],
        $_POST['id_dimension']
        )
        && $_POST['longueur'] != NULL
        && $_POST['largeur'] != NULL
        && $_POST['hauteur'] != NULL
        && $_POST['prix_dimensions'] != NULL
        && $_POST['id_dimension'] != NULL
        && $customisable == 1
    ) {
        // attention ce sont des arrays
        $longueur = $_POST['longueur'];
        $largeur = $_POST['largeur'];
        $hauteur = $_POST['hauteur'];
        $prix_dimensions = $_POST['prix_dimensions'];
        $id_dimension = $_POST['id_dimension'];
        $i = 0;
        foreach ($id_dimension as $lignes) {
            if (isset($longueur[$i],$largeur[$i],$hauteur[$i],$prix_dimensions[$i])) {
                req_dimensions_produit_update($bdd,htmlspecialchars($longueur[$i]),htmlspecialchars($largeur[$i]),htmlspecialchars($hauteur[$i]),intval($id_dimension[$i]),htmlspecialchars($prix_dimensions[$i]),$id_produit);
            }
            $i++;
        }
    }
        // insert nouvelles dimensions
    if (isset($_POST['longueur_new'],
    $_POST['largeur_new'],
    $_POST['hauteur_new'],
    $_POST['prix_dimensions_new']
        )
        && $_POST['longueur_new'] != NULL
        && $_POST['largeur_new'] != NULL
        && $_POST['hauteur_new'] != NULL
        && $_POST['prix_dimensions_new'] != NULL
    ) {
       $longueur_new = htmlspecialchars($_POST['longueur_new']); 
       $largeur_new = htmlspecialchars($_POST['largeur_new']); 
       $hauteur_new = htmlspecialchars($_POST['hauteur_new']); 
       $prix_dimensions_new = htmlspecialchars($_POST['prix_dimensions_new']); 
        req_dimensions_produit_insert($bdd,$longueur_new,$largeur_new,$hauteur_new,$id_produit,$prix_dimensions_new);
    }
        // autres type de tailles (diamètres, circonférences, volume, ... )
    if (isset($_POST['id_autre_taille'],
            $_POST['min'],
            $_POST['max'],
            $_POST['step'],
            $_POST['prix_step']
            )
            && $_POST['id_autre_taille'] != NULL
            && $_POST['min'] != NULL
            && $_POST['max'] != NULL
            && $_POST['step'] != NULL
            && $_POST['prix_step'] != NULL
    ) {
        // attention ce sont tous des arrays de taille identique
        $id_taille = $_POST['id_autre_taille'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $step = $_POST['step'];
        $prix_step = $_POST['prix_step'];

        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            $id_produit = intval($_GET['id']);
            //update (efface l'ancien enregistrement et enregistre le nouveau)
            req_custom_taille_sup($bdd,$id_produit);
            $i = 0;
            foreach ($id_taille as $lignes) {
                if(isset($min[$i],$max[$i],$step[$i],$prix_step[$i])
                && $min[$i] != NULL 
                && $max[$i] != NULL 
                && $step[$i] != NULL 
                && $prix_step[$i] != NULL) {
                    req_custom_taille_insert($bdd,$id_produit,intval($lignes),htmlspecialchars($min[$i]),htmlspecialchars($max[$i]),htmlspecialchars($step[$i]),htmlspecialchars($prix_step[$i]));
                }
                $i++;
            }
        }
        else {
            // insert
            $i = 0;
            foreach ($id_taille as $lignes) {
                if(isset($min[$i],$max[$i],$step[$i],$prix_step[$i])
                && $min[$i] != NULL 
                && $max[$i] != NULL 
                && $step[$i] != NULL 
                && $prix_step[$i] != NULL) {
                    req_custom_taille_insert($bdd,$id_produit,intval($lignes),htmlspecialchars($min[$i]),htmlspecialchars($max[$i]),htmlspecialchars($step[$i]),htmlspecialchars($prix_step[$i]));
                }
                $i++;
            }
        }

    }
 

    //affichage des nouvelles données en cas de succès
    $select_cat = select_cat($categories,$id_cat);
    $select_filtre = select_filtre($filtres,$id_filtre);
    $select_couleurs = select_box($bdd,$couleurs_init,'couleurs',$id_produit);
    $select_matieres = select_box($bdd,$matieres_init,'matieres',$id_produit);
    $select_custom = select_box($bdd,$customisations_init,'customisations',$id_produit);
    $select_tailles = select_tailles($bdd,$tailles_init,$id_produit);
    $texte_page_courante =' <h2>L\'opération à été réalisé avec succès</h2>';
}
?>