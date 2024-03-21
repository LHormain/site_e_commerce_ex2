<?php
include_once ('controler/traitement_ateliers_saisie.php');
?>

<h3 class="my-5"><?php echo $titre; ?> atelier</h3>
<p><?php echo $texte_page_courante; ?></p>

<div class="row">
    <form action="#" method="post" enctype="multipart/form-data" class="col-8 offset-2 text-start">
        <!-- nom atelier -->
        <div class="mb-3  ">
            <label for="nom_atelier" class="form-label">Nom de l'atelier</label>
            <input type="text" class="form-control" name="nom_atelier" id="nom_atelier" aria-describedby="helpId1" placeholder="" value="<?php echo $nom_atelier; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId1" class="form-text text-muted">Entrer le  nom de l'atelier</small>
        </div>
        <!-- texte -->
        <div class="mb-3">
          <label for="texte_descriptif" class="form-label">Paragraphe du descriptif de l'atelier</label>
          <textarea class="form-control" name="texte_descriptif" id="texte_descriptif" rows="10" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>><?php echo $texte_descriptif; ?></textarea>
        </div>
        <!-- nbr de persone max -->
        <div class="mb-3">
            <label for="nombre_participant_max" class="form-label">Nombre maximum de participant</label>
            <input type="text"
                class="form-control" name="nombre_participant_max" id="nombre_participant_max" aria-describedby="helpId3" placeholder="" value="<?php echo $nombre_participant_max; ?>">
            <small id="helpId3" class="form-text text-muted">nombre max</small>
        </div>
        <!-- prix inscription -->
        <div class="mb-3">
          <label for="prix_atelier" class="form-label">Prix unitaire de l'inscription</label>
          <input type="number"
            class="form-control" name="prix_atelier" id="prix_atelier" aria-describedby="helpId4" placeholder="" min=0 value="<?php echo $prix_atelier; ?>">
          <small id="helpId4" class="form-text text-muted">Prix HT pour une personne en euro</small>
        </div>
        <!-- durée de l'atelier -->
        <div class="mb-3">
            <label for="duree_atelier" class="form-label">Durée de l'atelier</label>
            <input type="number"
                class="form-control" name="duree_atelier" id="duree_atelier" aria-describedby="helpId5" placeholder="" min=0 value="<?php echo $duree_atelier; ?>">
            <small id="helpId5" class="form-text text-muted">Durée de l'atelier en minute</small>
        </div>
        <!-- nom image -->
        <div class="mb-3 <?php if ($hidden == 1) {echo 'visually-hidden';} ?> ">
            <label for="nom_img_atelier" class="form-label">Nom de l'image</label>
            <input type="text" class="form-control" name="nom_img_atelier" id="nom_img_atelier" aria-describedby="helpId2" placeholder="" value="<?php echo $nom_image; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image pour illustrer l'atelier. Pas d'espace ou de caractères spéciaux.</small>
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