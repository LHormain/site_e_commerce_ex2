<?php
include_once('controler/traitement_partenaires_saisie.php');
?>
<h3 class="mt-5">Saisie d'un nouveau partenaire</h3>
<form action="#" method="post" class="mt-3 text-start col-8 offset-2" enctype="multipart/form-data">
    <h4><?php echo $texte_page_courante; ?> </h4>
    <!-- nom entreprise -->
    <div class="mb-3">
        <label for="nom_partenaire" class="form-label">Nom de l’entreprise</label>
        <input
            type="text"
            class="form-control"
            name="nom_partenaire"
            id="nom_partenaire"
            aria-describedby="helpId1"
            placeholder=""
            value="<?php echo $nom_partenaire; ?>"
        />
        <small id="helpId1" class="form-text text-muted">Nom de l'entreprise partenaire</small>
    </div>
    <!-- descriptif -->
    <div class="mb-3">
        <label for="description_partenaire" class="form-label">Texte de présentation</label>
        <textarea class="form-control" name="description_partenaire" id="description_partenaire" rows="3"><?php echo $description_partenaire; ?></textarea>
    </div>
    <!-- mail -->
    <div class="mb-3">
        <label for="mail_partenaire" class="form-label">Adresse mail</label>
        <input
            type="text"
            class="form-control"
            name="mail_partenaire"
            id="mail_partenaire"
            aria-describedby="helpId3"
            placeholder=""
            value="<?php echo $mail_partenaire; ?>"
        />
        <small id="helpId3" class="form-text text-muted">Adresse e-mail de contact du partenaire</small>
    </div>
    <!-- téléphone -->
    <div class="mb-3">
        <label for="tel_partenaire" class="form-label">Téléphone</label>
        <input
            type="text"
            class="form-control"
            name="tel_partenaire"
            id="tel_partenaire"
            aria-describedby="helpId4"
            placeholder=""
            value="<?php echo $tel_partenaire; ?>"
        />
        <small id="helpId4" class="form-text text-muted">Numéro de téléphone du partenaire</small>
    </div>
    <!-- site internet -->
    <div class="mb-3">
        <label for="adresse_site_partenaire" class="form-label">Site internet</label>
        <input
            type="text"
            class="form-control"
            name="adresse_site_partenaire"
            id="adresse_site_partenaire"
            aria-describedby="helpId5"
            placeholder=""
            value="<?php echo $adresse_site_partenaire; ?>"
        />
        <small id="helpId5" class="form-text text-muted">Adresse du site internet du partenaire (site personnel, facebook, instagram, ...)</small>
    </div>
    <!-- nom logo -->
    <div class="mb-3 ">
        <label for="nom_img" class="form-label">Nom de l'image</label>
        <input type="text" class="form-control" name="nom_img" id="nom_img" aria-describedby="helpId2" placeholder="" value="<?php echo trim_image_name($nom_img); ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
        <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image du logo du partenaire. Pas d'espace ou de caractères spéciaux.</small>
    </div>
    <!-- fichier -->
    <div class="mb-3 ">
        <label for="photo" class="form-label">Choisir un fichier image</label>
        <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required ';} ?>>
        <div id="fileHelpId" class="form-text">Image jpeg, jpg, png, gif ou webp. Max 256Mo.</div>
    </div>
    <!-- enregistrer -->
    <div class="text-end">
        <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-2 ms-auto rounded-pill">
    </div>
</form>