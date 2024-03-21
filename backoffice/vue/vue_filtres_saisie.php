<?php
include_once('controler/traitement_filtres_saisie.php');
?>
<div class="mb-3 mt-5 text-start col-8 offset-2">
    <?php echo $texte_page_courante; ?>
    <form action="#" method="post" class="mt-3 " enctype="multipart/form-data">
        <!-- table de customisation -->
        <label for="table" class="form-label">Choisir la caractéristique à customiser</label>
        <select
            class="form-select form-select-lg"
            name="table"
            id="table"
        >
            <option value="couleurs" <?php if($table == 'couleurs') {echo 'selected';} ?>>Couleur</option>
            <option value="matieres" <?php if($table == 'matieres') {echo 'selected';} ?>>Matière</option>
            <option value="autres_tailles" <?php if($table == 'autres_tailles') {echo 'selected';} ?>>Dimension modifiable</option>
            <option value="customisations" <?php if($table == 'customisations') {echo 'selected';} ?>>Autre customisation</option>
        </select>
        <!-- nom -->
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input
                type="text"
                class="form-control"
                name="nom"
                id="nom"
                aria-describedby="helpId1"
                placeholder=""
                value="<?php echo $nom; ?>"

            />
            <small id="helpId1" class="form-text text-muted">Nom de la customisation</small>
        </div>
        <div id="image" class="">
            <!-- seulement pour couleur ou matière -->
            <!-- nom image -->
            <div class="mb-3 ">
                <label for="nom_img" class="form-label">Nom de l'image</label>
                <input type="text" class="form-control" name="nom_img" id="nom_img" aria-describedby="helpId2" placeholder="" value="<?php echo trim_image_name($nom_img); ?>" >
                <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image illustrant la catégorie. Pas d'espace ou de caractères spéciaux.</small>
            </div>
            <!-- fichier -->
            <div class="mb-3 ">
                <label for="photo" class="form-label">Choisir un fichier image</label>
                <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text">Image jpeg, jpg, png, gif ou webp. Max 256Mo.</div>
            </div>
        </div>
        <div class="text-end">
            <input type="submit" value="enregistrer" class="btn btn-camel text-light  rounded-pill">
        </div>
    </form>
</div>
<script src="public/assets/js/select_customisations.js"></script>