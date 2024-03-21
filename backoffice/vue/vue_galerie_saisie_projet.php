<?php
include_once('controler/traitement_galerie_saisie_projet.php');
?>
<h3 class="mt-5"><?php echo $titre; ?> projet</h3>
<p><?php echo $texte_page_courante; ?></p>

<div class="row">
    <form action="#" method="post" enctype="multipart/form-data" class="col-8 offset-2 text-start">
        <!-- nom atelier -->
        <div class="mb-3  ">
            <label for="nom_projet" class="form-label">Nom du projet</label>
            <input type="text" class="form-control" name="nom_projet" id="nom_projet" aria-describedby="helpId1" placeholder="" value="<?php echo $nom_projet; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId1" class="form-text text-muted">Entrer le  nom du projet</small>
        </div>
        <!-- texte -->
        <div class="mb-3">
          <label for="description_projet" class="form-label">Un bref descriptif du projet</label>
          <textarea class="form-control" name="description_projet" id="description_projet" rows="10" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>><?php echo $description_projet; ?></textarea>
        </div>
        <!-- nom image -->
        <div class="mb-3 <?php if ($hidden == 1) {echo 'visually-hidden';} ?> ">
            <label for="nom_img_atelier" class="form-label">Nom de l'image</label>
            <input type="text" class="form-control" name="nom_img_atelier" id="nom_img_atelier" aria-describedby="helpId2" placeholder="" value="<?php echo $nom_image; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image principale pour illustrer. Pas d'espace ou de caractères spéciaux.</small>
        </div>
        <!-- fichier -->
        <div class="mb-3 <?php if ($hidden == 1) {echo 'visually-hidden';} ?>">
            <label for="photo" class="form-label">Choisir un fichier image</label>
            <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <div id="fileHelpId" class="form-text">Image jpeg, jpg, png, gif ou webp. Max 256Mo.</div>
        </div>
        <!-- enregistrer -->
        <div class="text-end">
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-3 ms-auto rounded-pill">
        </div>
    </form>

</div>