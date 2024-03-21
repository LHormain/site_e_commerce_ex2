<?php
include_once('controler/traitement_faq.php');
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
            </ol>
        </nav>
        <section class="mb-3 mb-lg-5">
            <h1 class="text-center my-3 my-lg-5">Foire aux questions</h1>
            <div class="accordion accordion-flush" id="accordionFAQ">
                
                <?php echo $sortie;?>

            </div>
            
        </section>
    </div>
</div>