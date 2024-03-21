<?php
include_once('controler/traitement_deco_sm.php');
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item "><a href="index.php?page=201&s=3&f=0">Évènementiel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Décoration sur mesure</li>
            </ol>
        </nav>
        <h1 class="text-center mt-3 mt-lg-5 px-3">Décorations sur mesure</h1>
        <section>
            <div class="mt-mb-5 mt-3 text-center row mx-3">
                <?php echo $simulation;?>
            </div>
            <div class="mt-lg-5 mt-md-3 text-center">
            <?php
                        if (isset($_SESSION['id_client'])) {
                            ?>
                        <a
                            class="btn btn-gris-souris rounded-pill mb-md-5 mb-3"
                            href="index.php?page=212"
                            role="button"
                            >Demander un devis</a
                        >
                            <?php
                        }
                        else {
                            ?>
                                                    <a
                            class="btn btn-gris-souris rounded-pill mb-md-5 mb-3"
                            href="index.php?page=310&dl=1"
                            role="button"
                            >Se connecter pour demander un devis</a
                        >
                            <?php
                        }
                    ?>
            </div>
            
        </section>
    </div>
</div>