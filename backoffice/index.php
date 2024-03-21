<?php
    session_start();    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qualis Arma - Back Office</title>
    <!-- icône onglet -->
    <link rel="shortcut icon" type="image/ico" href="../favicon.ico"/>
    <!-- bootstrap 5 -->
    <link href="../public/assets/bootstrap_5/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container-fluid">
        <div class="row">

            <?php
    if (isset($_SESSION['connexion']) && ($_SESSION['connexion'] == 1 || $_SESSION['connexion'] == 2)) {
        require_once('modele/connexion_bdd.php');
        require_once('modele/fonctions.php');
        require_once('vue/composants/vue_nav.php');
        
        if (isset($_GET['page']) && $_GET['page'] != NULL) {
            $page = htmlspecialchars($_GET['page']);
            if ($page == 1) {
                include('vue/vue_accueil.php');
            }
            elseif ($page == 2) {
                include('controler/deconnexion.php');
            }
            elseif ($page == 300) {
                include('vue/vue_ateliers.php');
            }
            elseif ($page == 310) {
                include('vue/vue_ateliers_inscriptions.php');
            }
            elseif ($page == 320) {
                include('vue/vue_ateliers_entreprises.php');
            }
            elseif ($page == 400) {
                include('vue/vue_galerie.php');
            }
            elseif ($page == 410) {
                include('vue/vue_devis_sm.php');
            }
            elseif ($page == 500) {
                include('vue/vue_categories.php');
            }
            elseif ($page == 510) {
                include('vue/vue_filtres.php');
            }
            elseif ($page == 520) {
                include('vue/vue_produits.php');
            }
            elseif ($page == 530) {
                include('vue/vue_img_produits.php');
            }
            elseif ($page == 540) {
                include('vue/vue_promo.php');
            }
            elseif ($page == 600) {
                include('vue/vue_paniers_v.php');
            }
            elseif ($page == 601) {
                include('vue/vue_paniers_v_detail.php');
            }
            elseif ($page == 610) {
                include('vue/vue_commandes_v.php');
            }
            elseif ($page == 620) {
                include('vue/vue_devis_v.php');
            }
            elseif ($page == 621) {
                include('vue/vue_devis_v_detail.php');
            }
            elseif ($page == 630) {
                include('vue/vue_frais_port.php');
            }
            elseif ($page == 700) {
                include('vue/vue_paniers_l.php');
            }
            elseif ($page == 710) {
                include('vue/vue_paniers_l_detail.php');
            }
            elseif ($page == 730) {
                include('vue/vue_commandes_l.php');
            }
            elseif ($page == 720) {
                include('vue/vue_devis_l.php');
            }
            elseif ($page == 721) {
                include('vue/vue_devis_l_detail.php');
            }
            elseif ($page == 800) {
                include('vue/vue_contacts.php');
            }
            elseif ($page == 810) {
                include('vue/vue_clients.php');
            }
            elseif ($page == 811) {
                include('vue/vue_newsletter.php');
            }
            elseif ($page == 820) {
                include('vue/vue_partenaires.php');
            }
            elseif ($page == 830) {
                include('vue/vue_pages_fixes.php');
            }
            elseif ($page == 840) {
                include('vue/vue_faq.php');
            }
            else {
                include('vue/vue_accueil.php');
            }
        }
        else {
            include('vue/vue_accueil.php');
        }
    }
    else {
        require_once('vue/vue_connexion.php');
    }
            ?>

        </div>
    </div>

    <!-- JS de bootstrap  -->
    <script src="../public/assets/bootstrap_5/js/bootstrap.bundle.min.js"></script>

</body>
</html>