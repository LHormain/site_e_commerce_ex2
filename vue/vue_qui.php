<?php
include_once('controler/traitement_qui.php');
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Qui sommes-nous</li>
            </ol>
        </nav>
        <h1 class="text-center mt-3 mt-lg-5">Qui sommes nous?</h1>
        <section>
            <div class="row my-3 my-lg-5 px-5">
                <?php echo $simulation;?>
            </div>
        </section>
    </div>
</div>