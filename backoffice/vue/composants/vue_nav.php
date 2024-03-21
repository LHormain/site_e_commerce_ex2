<?php
include_once('controler/composants/traitement_nav.php');
?>

<nav class="col-2 bg-noir">
    <!-- Accueil -->
    <a class="btn <?php if ($page == 1) { echo 'btn-outline-camel text-taupe';} else { echo 'btn-camel';} ?> w-100 mt-5 mb-3" href="index.php?page=1" role="button" >Accueil</a>

    <div class="accordion accordion-flush my-3" id="accordionNav">
        <div class="accordion-item bg-noir">
            
            <!-- Ateliers -->
            <h2 class="accordion-header mt-1" id="flush-headingTwo">
                <button
                    class="btn <?php if (in_array($page, [300,310])) {echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseTwo"
                    aria-expanded="true"
                    aria-controls="flush-collapseTwo"
                >
                    Ateliers
                </button>
            </h2>
            <div
                id="flush-collapseTwo"
                class="accordion-collapse collapse <?php if (in_array($page, [300,310,320])) { echo 'show';} ?>"
                aria-labelledby="flush-headingTwo"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 300) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=300" role="button" >Gestions ateliers</a>
                    <?php 
                    if ($page == 300) {
                        ?>
                        <a class="btn <?php if ($page == 300 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=300&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 300 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=300&c=2" role="button" >Saisie</a>
                        <a class="btn <?php if ($page == 300 && $c == 7) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=300&c=7" role="button" >Gestion texte présentation</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 320) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=320" role="button" >Gestions ateliers Teams building </a>
                    <?php
                    if ($page == 320) {
                        ?>
                        <a class="btn <?php if ($page == 320 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=320&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 320 && ($c == 2 || $c == 3)) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=320&c=3" role="button" >Saisie</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 310) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=310" role="button" >Inscriptions</a>
                </div>
            </div>
            <!-- Sur mesure -->
            <h2 class="accordion-header mt-1" id="flush-headingThree">
                <button
                    class="btn <?php if (in_array($page, [400,410])) {echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseThree"
                    aria-expanded="true"
                    aria-controls="flush-collapseThree"
                >
                    Sur mesure
                </button>
            </h2>
            <div
                id="flush-collapseThree"
                class="accordion-collapse collapse <?php if (in_array($page, [400,410])) { echo 'show';} ?>"
                aria-labelledby="flush-headingThree"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 400) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=400" role="button" >Galerie</a>
                    <?php 
                    if ($page == 400) {
                        ?>
                        <a class="btn <?php if ($page == 400 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=400&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 400 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=400&c=2" role="button" >Saisie</a>
                        <a class="btn <?php if ($page == 400 && $c == 5) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=400&c=5" role="button" >Gestion texte présentation</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 410) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=410" role="button" >Demande de devis</a>
                </div>
            </div>
            <!-- produits -->
            <h2 class="accordion-header mt-1" id="flush-headingOne">
                <button
                    class="btn <?php if (in_array($page, [500,510,520,530,540])) {echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne"
                    aria-expanded="true"
                    aria-controls="flush-collapseOne"
                >
                    Produits
                </button>
            </h2>
            <div
                id="flush-collapseOne"
                class="accordion-collapse collapse <?php if (in_array($page, [500,510,520,530,540])) { echo 'show';} ?>"
                aria-labelledby="flush-headingOne"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 500) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=500" role="button" >Catégories</a>
                    <?php 
                    if ($page == 500) {
                        ?>
                        <a class="btn <?php if ($page == 500 && $c == 5) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=500&c=5" role="button" >Gestion des Sections</a>
                        <a class="btn <?php if ($page == 500 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=500&c=1" role="button" >Gestion catégorie</a>
                        <a class="btn <?php if ($page == 500 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=500&c=2" role="button" >Saisie catégorie</a>
                        <a class="btn <?php if ($page == 500 && $c == 3) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=500&c=3" role="button" >Gestion sous catégorie</a>
                        <a class="btn <?php if ($page == 500 && $c == 4) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=500&c=4" role="button" >Saisie sous catégorie</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 510) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=510" role="button" >Customisations</a>
                    <?php 
                    if ($page == 510) {
                        ?>
                        <a class="btn <?php if ($page == 510 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=510&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 510 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=510&c=2" role="button" >Saisie</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 520 || $page == 530 ) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=520" role="button" >Produits</a>
                    <?php 
                    if ($page == 520 || $page == 530) {
                        ?>
                        <a class="btn <?php if ($page == 520 && ($c == 1 || $c == 3)) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=520&c=3" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 520 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=520&c=2" role="button" >Saisie</a>
                        <button class="btn <?php if ($page == 530 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=530&c=1" role="button" disabled>Gestion images</button>
                        <button class="btn <?php if ($page == 530 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=530&c=2" role="button" disabled>Saisie images</button>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 540) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=540" role="button" >Promotions</a>
                    <?php 
                    if ($page == 540) {
                        ?>
                        <a class="btn <?php if ($page == 540) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1"  href="index.php?page=540" role="button">Gestion</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Boutique -->
            <h2 class="accordion-header mt-1" id="flush-headingFour">
                <button
                    class="btn <?php if (in_array($page, [600,601,610,620,621,630])) {echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseFour"
                    aria-expanded="true"
                    aria-controls="flush-collapseFour"
                >
                    Boutique
                </button>
            </h2>
            <div
                id="flush-collapseFour"
                class="accordion-collapse collapse <?php if (in_array($page, [600,601,610,620,621,630])) { echo 'show';} ?>"
                aria-labelledby="flush-headingFour"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 600) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=600" role="button" >Paniers</a>
                    <a class="btn <?php if ($page == 610) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=610" role="button" >Commandes et factures</a>
                    <a class="btn <?php if ($page == 620 || $page == 621) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=620" role="button" >Devis livraisons</a>
                    <a class="btn <?php if ($page == 630) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=630" role="button" >Frais de port</a>
                </div>
            </div>
            <!-- Boutique location -->
            <h2 class="accordion-header mt-1" id="flush-headingFive">
                <button
                    class="btn <?php if (in_array($page, [700,710,720,721,730])) {echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseFive"
                    aria-expanded="true"
                    aria-controls="flush-collapseFive"
                >
                    Boutique locations
                </button>
            </h2>
            <div
                id="flush-collapseFive"
                class="accordion-collapse collapse <?php if (in_array($page, [700,710,720,721,730])) { echo 'show';} ?>"
                aria-labelledby="flush-headingFive"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 700) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=700" role="button" >Paniers événementiel</a>
                    <button class="btn <?php if ($page == 710) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=710" role="button" disabled>Détail événementiel</button>
                    <a class="btn <?php if ($page == 730) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=730" role="button" >Commandes événementiel</a>
                    <a class="btn <?php if ($page == 720) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=720" role="button" >Devis locations</a>
                </div>
            </div>
            <!-- Administratif -->
            <h2 class="accordion-header mt-1" id="flush-headingSix">
                <button
                    class="btn <?php if (in_array($page, [800,810])){echo 'btn-outline-camel text-taupe';} else { echo 'collapsed btn-camel';} ?> w-100"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseSix"
                    aria-expanded="true"
                    aria-controls="flush-collapseSix"
                >
                    Administratif
                </button>
            </h2>
            <div
                id="flush-collapseSix"
                class="accordion-collapse collapse <?php if (in_array($page, [800,810,820,830,840])) { echo 'show';} ?>"
                aria-labelledby="flush-headingSix"
                data-bs-parent="#accordionNav"
            >
                <div class="accordion-body text-center">
                    <a class="btn <?php if ($page == 800) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=800" role="button" >Contacts</a>
                    <a class="btn <?php if ($page == 810) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=810" role="button" >Clients</a>
                    <a class="btn <?php if ($page == 820) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=820" role="button" >Partenaires</a>
                    <?php 
                    if ($page == 820) {
                        ?>
                        <a class="btn <?php if ($page == 820 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=820&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 820 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=820&c=2" role="button" >Saisie</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 830) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=830" role="button" >Pages Fixes</a>
                    <?php 
                    if ($page == 830) {
                        ?>
                        <a class="btn <?php if ($page == 830 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=830&c=1" role="button" >Qui sommes-nous</a>
                        <a class="btn <?php if ($page == 830 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=830&c=2" role="button" >Décoration sur mesure</a>
                        <!-- <a class="btn <?php if ($page == 830 && $c == 3) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=830&c=3" role="button" >Sur mesure : nos réalisations</a> -->
                        <a class="btn <?php if ($page == 830 && $c == 4) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-75 my-1" href="index.php?page=830&c=4" role="button" >Slider page d'accueil</a>
                        <?php
                    }
                    ?>
                    <a class="btn <?php if ($page == 840) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-100 my-1" href="index.php?page=840" role="button" >FAQ</a>
                    <?php 
                    if ($page == 840) {
                        ?>
                        <a class="btn <?php if ($page == 840 && $c == 1) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=840&c=1" role="button" >Gestion</a>
                        <a class="btn <?php if ($page == 840 && $c == 2) {echo 'btn-outline-taupe';} else {echo 'btn-taupe';} ?> w-50 my-1" href="index.php?page=840&c=2" role="button" >Saisie</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- déconnexion -->
    <a class="btn <?php if ($page == 2) {echo 'btn-outline-camel text-taupe';} else {echo 'btn-camel';} ?> w-100 my-3" href="index.php?page=2&dis=1" role="button" >Déconnexion</a>

</nav>