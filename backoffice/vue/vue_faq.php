<?php
    include_once('controler/traitement_faq.php');
?>
<div class="col-10 p-5 text-center">
    <h2>Foire aux questions</h2>

    <a class="btn <?php if ($c == 1) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=840&c=1" role="button">Gestion</a>
    <a class="btn <?php if ($c == 2) {echo 'btn-outline-camel';} else {echo 'btn-camel text-light';}?> " href="index.php?page=840&c=2" role="button">Saisie</a>

    <div class="row">
        <?php
        include_once('controler/routeur_faq.php');
        ?>
    </div>

</div>