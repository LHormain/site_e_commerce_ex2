<?php
include_once('controler/composants/traitement_nav.php');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container ">
        <a class="navbar-brand" href="index.php?page=1">
            <img src="public/assets/img/logo/qualisarmalogo1.jpg" alt="logo du site et lien vers accueil" title="logo du site et lien vers accueil" class="logo">
        </a>
        <button
            class="navbar-toggler d-lg-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId"
            aria-controls="collapsibleNavId"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0 text-center" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 ">
                <!-- section 1 boutique : reproduction historique -->
                <!-- section 2 boutique : vente mobilier et decoration -->
                <!-- section 3 boutique : location événementiel -->
                <?php echo $navigation; ?>
                <li class="nav-item">
                    <a href="index.php?page=202&s=4&f=0&c=0&p=1" class="nav-link">Promo</a>
                </li>
                <!-- ateliers -->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="dropdownId4"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >Ateliers </a
                    >
                    <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownId4"
                    >
                        <a class="dropdown-item" href="index.php?page=230&c=1"
                            >Particuliers</a
                        >
                        <a class="dropdown-item" href="index.php?page=230&c=2"
                            >Entreprises</a
                        >
                    </div>
                </li>
                <!-- confection meuble sur mesure -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=220">Sur mesure</a>
                </li>
                <!-- contact -->
                <li class="nav-item" id="contact">
                    <a class="nav-link" href="index.php?page=300">Contact</a>
                </li>
            </ul>
            <div class="row flex-column d-lg-none">
                <div class="col-12 ">
                    <!-- facebook -->
                    <?php echo $facebook; ?>
                    <?php echo $instagram; ?>
                </div>
                <!-- recherche -->
                <!-- <form method= "post" action="" class="col-12 my-2 my-0 text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recherche">
                    <input type="text" class="d-none" id="recherche" >
                    <button type="button" class="btn btn-link p-0 ">
                        <img src="public/assets/img/icones/loupe.png" alt="icône du bouton recherche" title="icône du bouton recherche" class="img-fluid icones " id="icone_recherche">
                    </button>
                </form> -->
                <!-- panier -->
                <div class=" dropdown open col-lg-1 text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Panier">
                        <button
                            class="btn btn-link dropdown-toggle"
                            type="button"
                            id="btn_paniers"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                        <img src="public/assets/img/icones/trolley.png" alt=" panier" title=" panier" class=" icones">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btn_paniers">
                            <a class="dropdown-item" href="index.php?page=204&c=1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Boutique">Boutique</a>
                            <a class="dropdown-item" href="index.php?page=204&c=2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Location">Location</a>
                        </div>
                        
                    </div>
                <!-- langue -->
                <!-- <div class="dropdown open col-12 " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Langue">
                    <button
                        class="btn btn-link dropdown-toggle"
                        type="button"
                        id="triggerId"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <img src="public/assets/img/icones/langue.png" alt="choix de la langue" title="choix de la langue" class=" icones">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <button class="dropdown-item" href="#">Français</button>
                        <button class="dropdown-item" href="#">English</button>
                    </div>
                </div> -->
                <!-- connexion -->
                <div class="dropdown open col-lg-1 text-center">
                        <button
                            class="btn btn-link dropdown-toggle"
                            type="button"
                            id="triggerId"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                        <img src="public/assets/img/icones/user.png" alt=" connexion client" title=" connexion client" class=" icones">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <?php  
                                if (!isset($_SESSION['id_client'])) {
                                    ?>
                                    <a class="dropdown-item" href="index.php?page=310" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Connexion">Connexion</a>
                                    <a class="dropdown-item" href="index.php?page=311" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inscription">Inscription</a>
                                    <?php
                                }
                                else {
                                    ?>
                                    <a class="dropdown-item" href="index.php?page=400" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Connexion">Mon compte</a>
                                    <a class="dropdown-item" href="index.php?page=9&dis=1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Connexion">Déconnexion</a>
                                    <?php
                                }
                            ?>
                        </div>
                        
                    </div>
            </div>
        </div>
    </div>
</nav>

