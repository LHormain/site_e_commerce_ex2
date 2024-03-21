<?php
include_once('controler/traitement_partenaires.php');
?>
<div class="container ht_page ">
    <div class="row">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item "><a href="index.php?page=201&s=3&f=0">Évènementiel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Partenaires</li>
            </ol>
        </nav>
        <h1 class="text-center mt-3 mt-lg-5">Partenaires</h1>
        <section class="mt-3">
            <div class="row">
                <?php echo $card_partenaires; ?>
            </div>
        </section>
    </div>
</div>

