<?php
include_once('controler/traitement_sur_mesure.php');
?>
<div class="container ht_page ">
    <div class="row">
        <!-- fils d'ariane -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="index.php?page=220">Sur mesure</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $projet[0]['nom_projet'] ?></li>
            </ol>
        </nav>
        <!-- contenu page -->
        <h1 class="text-center my-3"><?php echo $projet[0]['nom_projet'] ?></h1>
        <section>
            <div class="mb-lg-5 d-flex justify-content-center">
                <div id="carouselProjet" class="carousel slide  carousel-dark" data-bs-ride="carousel" >
                    <div class="carousel-indicators ">
                        <?php echo $carousel_indicator; ?>
                    </div>
                    <div class="carousel-inner" role="listbox">
                        <?php echo $carousel_item; ?>
                    </div>
                    <button
                        class="carousel-control-prev "
                        type="button"
                        data-bs-target="#carouselProjet"
                        data-bs-slide="prev"
                    >
                        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselProjet"
                        data-bs-slide="next"
                    >
                        <span class="carousel-control-next-icon " aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>
            </div>
        </section>
        <section class="my-3 my-lg-5">
            <div class="row">
                <div class="">
                    <p>
                        <?php echo $projet[0]['description_projet']; ?>
                    </p>
                    <p>Si vous aussi vous souhaitez une fabrication sur mesure, n'hésitez pas à nous contacter pour l'étude et la réalisation de vos projets</p>
                </div>
                <div class="text-center">
                    <a
                        class="btn btn-gris-souris rounded-pill"
                        href="index.php?page=300"
                        role="button"
                        >Demander un devis</a
                    >
                    
                </div>
            </div>
        </section>
    </div>
</div>