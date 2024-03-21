<?php
include_once('controler/traitement_mdp_reinitialise.php');
?>
<div class="row ">
    <?php 
        if ($id_user != '' && !(isset($_POST['mdp'], $_POST['mdp_confirmation']))) {
            echo $id_user;
    ?>
    <form action="#" method="post" class="my-5 offset-4 col-4 text-center">
        <h2>Réinitialisation du mot de passe</h2>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="mb-3 text-start">
            <label class="form-label" for="mdp">Nouveau mot de passe</label>
            <input class="form-control" type="password"  id="mdp" name="mdp">
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="mdp_confirmation">Confirmation du mot de passe</label>
            <input class="form-control" type="password"  id="mdp_confirmation" name="mdp_confirmation">
        </div>
        <input type="submit" value="Envoyer" class="btn btn-gris-souris rounded-pill ">
    </form>
    <?php
        }
        else {
            // echo $message;
            ?>
            <script>window.location.assign("index.php?page=315&cas=2");</script>
            <?php
        }
    ?>
</div>