<?php
include_once('controler/traitement_ateliers_saisie_image.php');
?>
<h3 class="mt-3"><?php echo $titre; ?> image pour l'atelier : <?php echo $nom_atelier; ?></h3>

<div class="my-5 text-start offset-1 col">
    <a class="btn btn-camel text-light " href="index.php?page=300&c=5&id=<?php echo $id_atelier; ?>" role="button">Retour à la gestion des images</a>
</div>
<div class="row">
    <form action="#" method="post" enctype="multipart/form-data" class="col-4 offset-1 text-start">
        <!-- nom image -->
        <div class="mb-3 ">
            <label for="nom_img_atelier" class="form-label">Nom de l'image</label>
            <input type="text" class="form-control" name="nom_img_atelier" id="nom_img_atelier" aria-describedby="helpId2" placeholder="" value="<?php echo $nom_image; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image pour illustrer l'atelier. Pas d'espace ou de caractères spéciaux.</small>
        </div>
        <!-- fichier -->
        <div class="mb-3 ">
            <label for="photo" class="form-label">Choisir un fichier image</label>
            <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <div id="fileHelpId" class="form-text">Image jpeg, jpg, png, gif ou webp. Max 256Mo.</div>
        </div>
        <!-- enregistrer -->
        <div class="text-end">
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-4 ms-auto rounded-pill">
        </div>

    </form>
    <div class="offset-1 col-3">
        <p><?php echo $texte_page_courante; ?></p>
        <?php if (isset($donnees['nom_img'])) {
            ?>
            <img src="../public/assets/img/site/<?php echo $donnees['nom_img']; ?>" alt="<?php echo $donnees['nom_img']; ?>" class="img-fluid">
            <?php
        } ?>
    </div>
</div>