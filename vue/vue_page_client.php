<?php
include_once('controler/traitement_page_client.php');
?>
<div class="container ht_page ">
    <div class="row mb-lg-0 mb-3">
        <h1 class="my-3 my-lg-5 text-center">Bienvenus <?php echo $client['prenom_utilisateur'].' '.$client['nom_utilisateur']; ?></h1>
        <nav class="col-lg-3 bg-taupe d-flex flex-column mb-3 mb-lg-5">
            <h2 class="fs-5 p-3 text-center">Mon compte</h2>
            <!-- navigation -->
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=1#top"
                role="button"
                >Informations personnelles</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=2#top"
                role="button"
                >Mes paniers</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=3#top"
                role="button"
                >Mes commandes</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=4#top"
                role="button"
                >Mes devis événementiels</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=7#top"
                role="button"
                >Mes devis sur mesure</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=5#top"
                role="button"
                >Mes favoris</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=400&c=6#top"
                role="button"
                >Mes ateliers</a
            >
            <a
                class="fs-6 my-3"
                href="index.php?page=9&dis=1"
                role="button"
                >Déconnexion</a
            >
        </nav>
        <!-- contenue de la page -->
        <section class="col-lg-9">
            <?php
                echo $page_courante;
            ?>
        </section>
    </div>
</div>
<script src="public/assets/js/card_panier.js"></script>