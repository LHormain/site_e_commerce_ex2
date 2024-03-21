<?php
include_once('controler/traitement_plan.php');
?>
<div class="container ht_page ">
    <div class="row my-3 my-lg-5">
        <h1 class="text-center">Plan du site</h1>
        <ul>
            <li><a href="index.php?page=1" class="fs-5">Accueil</a></li>
            
            <h2 class="mt-3 mt-lg-5">Boutique </h2>
            <?php echo $liens_boutiques; ?>
            <li><a href="index.php?page=211" class="fs-5">Évènementiel : décorations sur mesure</a></li>
            <li><a href="index.php?page=210" class="fs-5">Nos partenaires</a></li>

            <h2 class="mt-3 mt-lg-5">Clients</h2>
            <li><a href="index.php?page=204&c=1" class="fs-5">Mon panier - boutique</a></li>
            <li><a href="index.php?page=204&c=2" class="fs-5">Mon panier - location</a></li>
            <?php  
                if (isset($_SESSION['id_client'])) {
                    ?>
                <li><a href="index.php?page=400" class="fs-5">Ma page client</a></li>
                    <?php
                }
            ?>


            <h2 class="mt-3 mt-lg-5">Ateliers </h2>
            <li><a href="index.php?page=230&c=1" class="fs-5">Particuliers</a></li>
            <li><a href="index.php?page=230&c=2" class="fs-5">Entreprises</a></li>
            
            <h2 class="mt-3 mt-lg-5">Sur mesure</h2>
            <li><a href="index.php?page=220" class="fs-5">Nos réalisations</a></li>
            <li><a href="index.php?page=300" class="fs-5">Demande de devis</a></li>

            <h2 class="mt-3 mt-lg-5"></h2>
            <li><a href="index.php?page=300" class="fs-5">Contact</a></li>
            <li><a href="index.php?page=5" class="fs-5">Qui sommes-nous?</a></li>
            <li><a href="index.php?page=6" class="fs-5">FAQ</a></li>
            <li><a href="index.php?page=7" class="fs-5">Mentions légales, CGV, CGU et politique de confidentialité</a></li>
        </ul>
    </div>
</div>