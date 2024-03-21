<section class="container">
    <div class="row ">
        <h2 class="text-center mt-lg-5 mt-3">Mot de passe oublié</h2>
        <?php
        if (isset($_GET['cas']) && $_GET['cas'] == 1) {
            ?>
        <div class=" my-5 text-center">
            <p>Un liens pour réinitialiser votre mot de passe vient d'être envoyé sur votre boite mail. Il sera valide 30 minutes.</p>
            <a href="index.php?page=1" class="btn btn-gris-souris rounded-pill m-5">Retourner à l'accueil</a>
        </div>
            <?php
        }
        elseif (isset($_GET['cas']) && $_GET['cas'] == 2) {
            ?>
        <div class=" my-5 text-center">
            <p>Votre mot de passe à été réinitialisé. Vous pouvez maintenant vous connecter.</p>
            <a href="index.php?page=1" class="btn btn-gris-souris rounded-pill m-5">Retourner à l'accueil</a>
        </div>
        <?php
        }
        ?>
    </div>
</section>