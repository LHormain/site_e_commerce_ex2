<?php
include_once('controler/traitement_galerie.php');
?>
<div class="container ht_page ">
    <div class="row">
        <!-- fils d’Ariane -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sur mesure</li>
            </ol>
        </nav>
        <h1 class="text-center my-3">Sur mesure : Nos réalisations</h1>
        <p class="px-5 text-justify"><?php echo nl2br($texte);?></p>
    </div>
    <section class="my-5  ">
        <div class="row g-0 masonry_layout position-relative  ">
            <?php echo $sortie; ?>
        </div>
        <!-- pagination -->
        <nav aria-label="Page navigation " class="d-flex justify-content-center my-5">
            <ul class="pagination ">
                <?php
                    echo $pagination;
                ?>
            </ul>
        </nav>
        <div class="text-end fixed-bottom mb-3 mb-lg-5 me-lg-5">
            <a
                class="btn btn-gris-souris rounded-pill mb-lg-5"
                href="index.php?page=300&c=1"
                role="button"
                >Demander un devis</a
            >
            
        </div>
    </section>
</div>
