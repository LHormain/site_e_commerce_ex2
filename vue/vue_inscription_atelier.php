<?php
include_once('controler/traitement_inscription_atelier.php');
?>
<section class="container ht_page ateliers">
    <div class="row">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php?page=230">Ateliers - Pour les particuliers</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inscription</li>
        </ol>
        </nav>
        <h1 class="text-center my-3">Inscription à l'atelier <?php echo $atelier['nom_atelier']; ?></h1>
        <p class="px-5 px-md-0"><?php echo nl2br($atelier['descriptif_atelier']); ?></p>
        <p class="mb-md-3 px-5 px-md-0">
            Bonjour <strong><?php echo $client['prenom_utilisateur'].' '.$client['nom_utilisateur'] ?></strong>.<br>
            Veuillez renseigner ces quelques information pour que nous puissions procéder à votre inscription à l'atelier <?php echo $atelier['nom_atelier']; ?>.
            <br>
            Nous vous rappelons que cet atelier est d'une durée de <strong><?php echo $atelier['duree_atelier']; ?> minutes</strong>.
        </p>
        <form class="row my-md-5 px-5 px-md-0" action="index.php?page=321" method="post">
            <div class="offset-md-1 col-md-4">
                <!-- id_client -->
                <div class=" visually-hidden">
                    <input type="text" class="form-control" name="id_client" id="id_client" aria-describedby="helpId" placeholder="" value="<?php echo $client['id_user']; ?>">
                    <small id="helpId" class="form-text text-muted">identifiant du client</small>
                </div>
                <!-- n° atelier -->
                <div class=" visually-hidden">
                    <input type="text" class="form-control" name="id_atelier" id="id_atelier" aria-describedby="helpId2" placeholder="" value="<?php echo $id_atelier; ?>">
                    <small id="helpId2" class="form-text text-muted">numéro de l'atelier</small>
                </div>
                <div class="mb-3" id="horaireBox">
                    <p class="form-label " >
                        Choisissez un horaire :
                    </p>
                    <?php echo $crenaux; ?>     
                </div>
                <!-- nbr de participant -->
                <div class="mb-3 ">
                    <label for="nbr_inscrit" class="form-label">Nombre de place à réserver :</label>
                    <input type="number" class="form-control text-center" name="nbr_inscrit" id="nbr_inscrit" aria-describedby="helpId3" placeholder="" min="1" max="5" value="1">
                    <small id="helpId3" class="form-text text-muted">Nombre de personne participant à l'atelier</small>
                </div>          
            </div>
            <div class=" offset-md-1 col-md-6 bg-taupe text-center p-3 mb-3">
                <!-- estimation du prix -->
                <div class="mb-3 col-6 text-md-end align-self-end">
                    Prix de la séance :
                </div>
                <div class="visually-hidden" id="prix_unitaire"><?php echo $atelier['tarif_atelier']; ?></div>
                <div class="mb-3"><span id="prix"><?php echo $atelier['tarif_atelier']; ?></span> <span>€</span></div>
                <!-- captcha -->
                <div class="mb-3" >
                    <p for="">Écrivez dans la case ci dessous uniquement les chiffres apparaissant dans le code suivant : <br> <strong id="code"></strong></p>
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <input type="text" name="captcha" id="captcha" class="py-2 form-control w-50" required>
                </div>
                <!-- envoyer -->
                <input type="submit" value="Finaliser l'inscription" class="btn btn-gris-souris rounded-pill" disabled>
            </div>
        </form>
    </div>
</section>

<script src="public/assets/js/captcha.js"></script>
<script src="public/assets/js/formulaire_atelier.js"></script>
<script>
getPrixTotal();
</script>