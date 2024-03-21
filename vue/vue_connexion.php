
<?php
    include_once('controler/traitement_connexion.php');

    // si utilisateur non connecté
    if (!isset($_SESSION['id_client'])) { 
?>
<section class="container ht_page ">
    <div class="row justify-content-evenly">
        <h1 class="text-center my-lg-5">Connection et inscription</h1>
        <form action="#" method="post" class="py-3 mb-5 text-center col-lg-4 offset-lg-1 col-md-5 col-10 border border-gris-souris" autocomplete="off">
            <h2 class=" pt-5">Connexion</h2>
            <?php echo $texte_page_courante; ?>
            <div class="mb-3 form-floating">
                <input type="text" name="mail_utilisateur" placeholder="" id="floatingInput" class="form-control ">
                <label for="floatingInput">Adresse e-mail</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="password" name="pwd" placeholder="" id="floatingPassword" class="form-control ">
                <label for="floatingPassword">Mot de passe</label>
                <small class="form-text text-muted"><a class="btn btn-link" href="index.php?page=313" role="button" >Mot de passe oublier?</a></small>
            </div>
            <div class="mb-3">
                <input type="submit" value="Connexion" class="btn btn-gris-souris rounded-pill">
            </div>
        </form>
        <div class="text-center col-lg-4 offset-lg-1 py-3 mb-5 col-md-5 col-10 border border-gris-souris">
            <h2 class=" pt-5">Pas encore membre? Inscrivez-vous.</h2>
            <div class="text-center">
                <img
                    src="public/assets/img/logo/qualisarmalogo2.png"
                    class="img-fluid rounded rounded-3 w-30 m-3"
                    alt=""
                />
            </div>
            <a class="btn btn-gris-souris rounded-pill" href="index.php?page=311" role="button">Inscription</a>
        </div>
    </div>
</section>
<?php 
    }
    // si utilisateur connecté
    else {
            ?>
            <script>window.location.assign("index.php?page=1");</script>
            <?php
    }
?>