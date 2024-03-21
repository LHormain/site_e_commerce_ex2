<?php
session_start();    
    // Connexion à une base de donné //
    require_once('modele/connexion_bdd.php');

    // debut des includes //
    require_once('modele/fonctions.php');
    
    req_purge_panier_sans_client($bdd);
    req_purge_panier_avec_client($bdd);
    
if (!isset($_SESSION['id_commande'])) { 
    // pour panier achat
    do {
        $_SESSION['id_commande'] = time();

        $test = test_id_commande($bdd,$_SESSION['id_commande']);
    } while ($test != 0);
}
if (!isset($_SESSION['id_location'])) {
    // pour panier location
    do {
        $_SESSION['id_location'] = time();

        $test = test_id_location($bdd,$_SESSION['id_location']); // test paniers_location
        $test2 = test_id_location2($bdd,$_SESSION['id_location']); // test commandes_location
    } while ($test != 0 && $test2 != 0);
}

if (isset($_GET['page']) && $_GET['page'] != NULL) {
    $page = intval($_GET['page']);

    if ($page == 1) {
        $nom_page = "Qualis Arma ";
    }
    elseif ($page == 200) {
        $nom_page = "Qualis Arma: ";
    }
    elseif ($page == 201) {
        // ajouter le nom de la section du site
        if (isset($_GET['s']) && $_GET['s'] != NULL) {
            $id_section = intval($_GET['s']);
            $donnees = req_section($bdd,$id_section);
        }
        $nom_page = "Qualis Arma: ".$donnees['nom_section'];
    }
    elseif ($page == 202) {
        // ajouter le nom de la catégorie
        if (isset($_GET['c']) && $_GET['c'] != NULL) {
            $id_cat = intval($_GET['c']);
            if ($id_cat != 0) {
                $donnees = req_categorie($bdd,$id_cat);
            }
            else {
                $donnees['nom_categorie']='promotions';
            }
        }
        $nom_page = "Qualis Arma: ".$donnees['nom_categorie'];
    }
    elseif ($page == 203) {
        // prendre nom du produits dans dbb et inclure
        if (isset($_GET['c']) && $_GET['c'] != NULL) {
            $id_produit = intval($_GET['c']);
            $donnees = req_produit($bdd,$id_produit);
        }
        $nom_page = "Qualis Arma: ".$donnees['nom_produit'];
    }
    elseif ($page == 204) {
        $nom_page = "Qualis Arma: Panier";
    }
    elseif ($page == 205) {
        $nom_page = "Qualis Arma: Commande";
    }
    elseif ($page == 206) {
        $nom_page = "Qualis Arma: Demande de devis";
    }
    elseif ($page == 210) {
        $nom_page = "Qualis Arma: Nos partenaires";
    }
    elseif ($page == 220) {
        $nom_page = "Qualis Arma: Nos créations sur mesure";
    }
    elseif ($page == 221) {
        // inclure le nom de la creation sur mesure
        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            $id_projet = intval($_GET['id']);
            $donnees = req_projet($bdd,$id_projet);
        }
        $nom_page = "Qualis Arma: ".$donnees[0]['nom_projet'];
    }
    elseif ($page == 230) {
        $nom_page = "Qualis Arma: Nos ateliers";
    }
    elseif ($page == 300) {
        $nom_page = "Qualis Arma: Contact";
    }
    elseif ($page == 310) {
        $nom_page = "Qualis Arma: Connexion";
    }
    elseif ($page == 311) {
        $nom_page = "Qualis Arma: Inscription";
    }
    elseif ($page == 320) {
        $nom_page = "Qualis Arma: Inscription à un atelier";
    }
    elseif ($page == 400) {
        $nom_page = "Qualis Arma: Mon compte client";
    }
    elseif ($page == 401) {
        $nom_page = "Qualis Arma: Devis";
    }
    elseif ($page == 5) {
        $nom_page = "Qualis Arma: Qui sommes nous";
    }
    elseif ($page == 6) {
        $nom_page = "Qualis Arma: FAQ";
    }
    elseif ($page == 7) {
        $nom_page = "Qualis Arma: Mentions légales";
    }
    elseif ($page == 8) {
        $nom_page = "Qualis Arma: Plan du site";
    }
    else {
        $nom_page = "Qualis Arma ";
    }
}
else {
    $nom_page = "Qualis Arma ";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vente et location de mobilier, matériel de décoration et reproduction historique. Découvrez également nos ateliers bricolages.">
    <title><?php echo $nom_page; ?></title>
    <!-- icône onglet -->
    <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
    <!-- bootstrap 5 -->
    <link href="public/assets/bootstrap_5/css/bootstrap.min.css" rel="stylesheet">
    <!-- polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Montserrat:ital,wght@0,200;0,400;0,700;1,200;1,400;1,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="public/assets/css/fontawesome-6.4.0/css/all.css">
    <!-- css perso -->
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <?php

        require_once('modele/configuration.php');

        ?>
        
        <div class="sticky-lg-top shadow-sm">
            <?php
            require_once('vue/composants/vue_header.php');
            require_once('vue/composants/vue_nav.php');
            ?>
        </div>
        <?php

        require_once('vue/composants/vue_scroll_top.php');

        if (isset($_GET['page']) && $_GET['page'] != NULL) {
            $page = intval($_GET['page']);

            if ($page == 1) {
                include('vue/vue_accueil.php');
            }
            elseif ($page == 201) {
                include('vue/vue_sous_cat.php');
            }
            elseif ($page == 202) {
                include('vue/vue_catalogue.php');
            }
            elseif ($page == 203) {
                include('vue/vue_produits.php');
            }
            elseif ($page == 204) {
                include('vue/vue_panier.php');
            }
            elseif ($page == 205) {
                include('vue/vue_commande.php');
            }
            elseif ($page == 207) {
                include('controler/enregistrement_commande.php');
            }
            elseif ($page == 206) {
                include('vue/vue_devis_livraison.php');
            }
            elseif ($page == 210) {
                include('vue/vue_partenaires.php');
            }
            elseif ($page == 211) {
                include('vue/vue_deco_sm.php');
            }
            elseif ($page == 212) {
                include('vue/vue_devis_location.php');
            }
            elseif ($page == 213) {
                include('controler/enregistrement_devis_location.php');
            }
            elseif ($page == 220) {
                include('vue/vue_galerie.php');
            }
            elseif ($page == 221) {
                include('vue/vue_sur_mesure.php');
            }
            elseif ($page == 230) {
                include('vue/vue_ateliers.php');
            }
            elseif ($page == 300) {
                include('vue/vue_contact.php');
            }
            elseif ($page == 301) {
                include('controler/enregistrement_contact.php');
            }
            elseif ($page == 310) {
                include('vue/vue_connexion.php');
            }
            elseif ($page == 311) {
                include('vue/vue_inscription.php');
            }
            elseif ($page == 312) {
                include('controler/enregistrement_inscription.php');
            }
            elseif ($page == 313) {
                include('vue/vue_mdp_oublier.php');
            }
            elseif ($page == 314) {
                include('vue/vue_mdp_reinitialise.php');
            }
            elseif ($page == 315) {
                include('vue/vue_mdp_oublier_sortie.php');
            }
            elseif ($page == 31) {
                include('vue/vue_mdp_oublier_sortie.php');
            }
            elseif ($page == 320) {
                include('vue/vue_inscription_atelier.php');
            }
            elseif ($page == 321) {
                include('controler/enregistrement_inscription_atelier.php');
            }
            elseif ($page == 400) {
                include('vue/vue_page_client.php');
            }
            elseif ($page == 5) {
                include('vue/vue_qui.php');
            }
            elseif ($page == 6) {
                include('vue/vue_faq.php');
            }
            elseif ($page == 7) {
                include('vue/vue_legal.php');
            }
            elseif ($page == 8) {
                include('vue/vue_plan.php');
            }
            elseif ($page == 9) {
                include('vue/vue_deconnexion.php');
            }
            else {
                include('vue/vue_accueil.php');
            }
        }
        else {
            include('vue/vue_accueil.php');
        }
    
        require_once('vue/composants/vue_footer.php');
    

    ?>

    <!-- JS de bootstrap  -->
    <script src="public/assets/bootstrap_5/js/bootstrap.bundle.min.js"></script>

    <!-- JS perso -->
    <script src="public/assets/js/scroll_top.js"></script>
    <script src="public/assets/js/mise_en_valeur_txt.js"></script>
</body>
</html>