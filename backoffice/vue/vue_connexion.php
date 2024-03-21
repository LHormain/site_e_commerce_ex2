<?php
    if (isset($_POST['pwd'], $_POST['usermail']) && $_POST['pwd'] != NULL && $_POST['usermail']) {
        // action de connection
        include_once('controler/traitement_connexion.php');
    }
    else {
        // action pas de connection
?>
    <div class="offset-5 col-2 mt-5">
        <img src="../public/assets/img/logo/qualisarmalogo2.png" alt="" class="img-fluid">
    </div>
    <h1 class="text-center pt-5">Connexion</h1>
    <form action="#" method="post" class="py-3 mb-5 text-center" autocomplete="off">
        <div class="mb-3">
            <input type="text" name="usermail" placeholder="votre adresse e-mail">
        </div>
        <div class="mb-3">
            <input type="password" name="pwd" placeholder="Mot de passe">
        </div>
        <div class="mb-3">
            <input type="submit" value="Connexion" class="btn btn-primary">
        </div>
    </form>
<?php 
    }
?>