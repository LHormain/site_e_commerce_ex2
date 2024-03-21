<header class="d-none d-lg-block bg-taupe">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-2 ">
                <!-- facebook -->
                <?php echo $facebook; ?>
                <!-- instagram -->
                <?php echo $instagram; ?>
            </div>
            <div class="col my-2 ">
                <div class="row justify-content-end align-items-center">
                    <!-- recherche -->
                    <!-- <form method= "post" action="" class="col-lg-5 my-2 my-lg-0 text-end" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recherche">
                        <input type="text" class="d-none" id="recherche" >
                        <button type="button" class="btn btn-link p-0 ">
                            <img src="public/assets/img/icones/loupe.png" alt=" bouton de recherche" title="bouton de recherche" class="img-fluid icones " id="icone_recherche">
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
                    <!-- <div class="dropdown open col-lg-1 text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Langue">
                        <button
                            class="btn btn-link dropdown-toggle"
                            type="button"
                            id="btn_langue"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <img src="public/assets/img/icones/langue.png" alt="choix de la langue" title="choix de la langue" class=" icones">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btn_langue">
                            <button class="dropdown-item" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="français">Français</button>
                            <button class="dropdown-item" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="english">English</button>
                        </div>
                    </div> -->
                    <!-- connexion client -->
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
    </div>
</header>

<!-- <script src="public/assets/js/recherche.js"></script> -->