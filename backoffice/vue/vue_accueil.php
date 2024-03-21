<?php
include_once('controler/traitement_accueil.php');
?>
<div class="col-10">
    <h1 class="text-center mt-5">Accueil</h1>
    <div class="row">
        <!-- Ateliers -->
        <h2 class=" ">Ateliers</h2>
        <a href="index.php?page=300" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-noisette">
                Gestion Ateliers
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des ateliers bricolages pour les particuliers
                </p>
            </div>
        </a>
        <a href="index.php?page=320" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-noisette">
                Gestion page Team building
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion de l'annonce pour les ateliers destinés aux entreprises
                </p>
            </div>
        </a>
        <a href="index.php?page=310" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-noisette">
                Inscriptions
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des inscriptions aux ateliers
                </p>
            </div>
        </a>
        <!-- Sur mesure -->
        <h2 class="">Sur mesure</h2>
        <a href="index.php?page=400" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-or">
                Galerie
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Galeries des travaux sur mesure déjà réalisé pour des clients
                </p>
            </div>
        </a>
        <a href="index.php?page=410" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-or">
                Demande de devis<span class="badge bg-bleu-nuit fs-6 position-absolute top-0 start-100 translate-middle p-2"><?php echo $nbr_devis_sm; ?></span>
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des demandes de devis de produits sur mesure
                </p>
            </div>
        </a>
        <!-- Produits -->
        <h2 class="">Produits</h2>
        <a href="index.php?page=500" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-scienne">
                Catégories
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestions des catégories et sous catégories (thèmes) de la boutique 
                </p>
            </div>
        </a>
        <a href="index.php?page=510" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-scienne">
                Customisation
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des caractéristiques customizables pour les différents produits de la boutique (matériaux, couleur, taille, ...)
                </p>
            </div>
        </a>
        <a href="index.php?page=520" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-scienne">
                Produits
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion de l'ensemble des produits de la boutique
                </p>
            </div>
        </a>
        <a href="index.php?page=540" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-scienne">
                Promotions
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion de la promotion s'applicant sur les produits à vendre sur le site
                </p>
            </div>
        </a>
        <!-- Boutique -->
        <h2 class="">Boutique</h2>
        <a href="index.php?page=600" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-terracotta">
                Paniers
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Paniers clients
                </p>
            </div>
        </a>
        <a href="index.php?page=610" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-terracotta">
                Commandes et factures<span class="badge bg-bleu-nuit fs-6 position-absolute top-0 start-100 translate-middle p-2"><?php echo $nbr_livraison; ?></span>
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Commandes et facture de la boutique vente
                </p>
            </div>
        </a>
        <a href="index.php?page=620" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-terracotta">
                Devis livraisons<span class="badge bg-bleu-nuit fs-6 position-absolute top-0 start-100 translate-middle p-2"><?php echo $nbr_devis_liv; ?></span>
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Devis de livraison pour les commandes de plus de X kg.
                </p>
            </div>
        </a>
        <a href="index.php?page=630" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-terracotta">
                Frais de port pour les petites commandes de moins de 15 kg
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Table contenant les frais de port utiliser pour le calcul du prix total de la commande si celle ci ne nécessite pas de devis livraison.
                </p>
            </div>
        </a>
        <!-- Boutique locations -->
        <h2 class="">Boutique locations événementiel</h2>
        <a href="index.php?page=700" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-camel">
                Paniers événementiel
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Paniers location clients
                </p>
            </div>
        </a>
        <a href="index.php?page=730" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-camel">
                Commandes événementiel
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Liste des paniers associer aux devis déjà traité
                </p>
            </div>
        </a>
        <a href="index.php?page=720" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-camel">
                Devis locations<span class="badge bg-bleu-nuit fs-6 position-absolute top-0 start-100 translate-middle p-2"><?php echo $nbr_devis_loc; ?></span>
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Devis location pour l'événementiel
                </p>
            </div>
        </a>
        <!-- Administratif / Gestion du site-->
        <h2 class="">Administratif</h2>
        <a href="index.php?page=800" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-redbeige">
                Contacts<span class="badge bg-bleu-nuit fs-6 position-absolute top-0 start-100 translate-middle p-2"><?php echo $nbr_contact; ?></span>
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Ensemble des messages de contact qui ne sont pas des demandes de devis
                </p>
            </div>
        </a>
        <a href="index.php?page=810" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-redbeige">
                Clients
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Liste des clients
                </p>
            </div>
        </a>
        <a href="index.php?page=820" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-redbeige">
                Partenaires
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Liste des partenaires
                </p>
            </div>
        </a>
        <a href="index.php?page=830" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-redbeige">
                Pages fixes
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des textes de la page Qui sommes-nous, Décoration sur mesure, Sur mesure: nos réalisations et du slider de la page d'accueil
                </p>
            </div>
        </a>
        <a href="index.php?page=840" class="card text-center col-2 p-0 m-3">
            <div class="card-header text-light bg-redbeige">
                FAQ
            </div>
            <div class="card-body  text-dark">
                <img src="" alt="" class="img-fluid rounded-top" >
                <p class="card-text">
                    Gestion des questions fréquemment posées
                </p>
            </div>
        </a>
        
    </div>
</div>