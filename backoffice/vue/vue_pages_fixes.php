<?php
    require_once('controler/traitement_pages_fixes.php');
?>
<div class="col-10 mt-5 text-center">
    <?php
        if ($c == 1 || $c == 2 || $c == 4) {
            ?>
<h2>Gestion des pages Fixes</h2>

<a class="btn <?php if ($c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=830&c=1" role="button">Qui sommes-nous</a>
<a class="btn <?php if ($c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=830&c=2" role="button">Décoration sur mesure</a>
<!-- <a class="btn btn-camel text-light " href="index.php?page=830&c=3" role="button">Sur mesure : nos réalisations</a> -->
<a class="btn <?php if ($c == 4) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=830&c=4" role="button">Slider page d'accueil</a>

            <?php
        }
    ?>

<?php
    require_once('controler/routeur_pages_fixes.php');
?>
</div>