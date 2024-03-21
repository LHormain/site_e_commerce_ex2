<?php
include_once('controler/traitement_sous_categories_saisie.php');
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
        <!-- nom sous catégorie -->
        <div class="mb-3">
            <label for="nom_filtre" class="form-label">Nom de la catégorie</label>
            <input
                type="text"
                class="form-control"
                name="nom_filtre"
                id="nom_filtre"
                aria-describedby="helpId1"
                placeholder=""
                value="<?php echo $nom_filtre; ?>"
            />
            <small id="helpId1" class="form-text text-muted">Nom de la catégorie</small>
        </div>
        
        <!-- enregistrer -->
        <div class="text-end">
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-2 ms-auto rounded-pill">
        </div>
    </form>
</div>