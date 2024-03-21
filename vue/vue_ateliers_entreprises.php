<?php
include_once('controler/traitement_ateliers_entreprises.php');
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ateliers - Pour les entreprises</li>
    </ol>
</nav>
<h1 class="text-center my-3">Nos ateliers Team Building</h1>
<p class="text-center text-md-start px-5"> Réservez dès maintenant votre séance chez <strong><?php echo $nom_entreprise; ?></strong> et découvrez comment l'ébénisterie peut devenir le catalyseur d'une équipe plus unie et inspirée.
Transformez votre équipe en créateurs, sculptez vos liens, et faites de chaque atelier une étape vers le succès collectif. Laissez-nous vous accompagner dans la construction d'une équipe plus forte, plus connectée et prête à relever tous les défis ensemble.</p>

<?php echo $sortie; ?>
<div class="text-center offset-lg-2 col-lg-8 fs-5 my-lg-5 my-3 px-5">
    Cela vous intéresse? <br>
    Pour convenir d'une date et des activités pour vos employés 
    contactez-nous directement au <strong><?php echo $tel_site; ?></strong>. <br>
    Nous établirons une <strong>offre personnalisé</strong> pour vous et votre entreprise. 
</div>
<section>
    <h2 class="text-center ">Ils nous ont fait confiance</h2>
    <div class="d-flex justify-content-evenly align-items-center my-lg-5 my-3">
        <?php echo $partenaires; ?>
    </div>
</section>