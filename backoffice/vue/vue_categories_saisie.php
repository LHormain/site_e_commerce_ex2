<?php
include_once('controler/traitement_categories_saisie.php');
?>
<div class="offset-2 col-8 mt-5">
    <h3><?php echo $titre; ?></h3>
    <form action="#" method="post" class="mt-3 text-start " enctype="multipart/form-data">
        <h4><?php echo $texte_page_courante; ?> </h4>
        <!-- section -->
        <div class="mb-3">
            <label for="section" class="form-label">Choisir une Section de la boutique</label>
            <select
            class="form-select form-select-lg"
            name="section"
            id="section"
            >
            <?php
                echo $select;
                ?>
            </select>
        </div>
        <!-- nom catégorie -->
        <div class="mb-3">
            <label for="nom_categorie" class="form-label">Nom de la catégorie</label>
            <input
                type="text"
                class="form-control"
                name="nom_categorie"
                id="nom_categorie"
                aria-describedby="helpId1"
                placeholder=""
                value="<?php echo $nom_categorie; ?>"
            />
            <small id="helpId1" class="form-text text-muted">Nom de la catégorie</small>
        </div>
        <!-- descriptif -->
        <div class="mb-3">
            <label for="description_categorie" class="form-label">Texte de présentation de la catégorie</label>
            <textarea class="form-control" name="description_categorie" id="description_categorie" rows="5"><?php echo $description_categorie; ?></textarea>
        </div>

        <!-- nom image -->
        <div class="mb-3 ">
            <label for="nom_img" class="form-label">Nom de l'image</label>
            <input type="text" class="form-control" name="nom_img" id="nom_img" aria-describedby="helpId2" placeholder="" value="<?php echo trim_image_name($nom_img); ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId2" class="form-text text-muted">Entrer le  nom de l'image illustrant la catégorie. Pas d'espace ou de caractères spéciaux.</small>
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
</div>