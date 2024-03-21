<?php
include_once('controler/traitement_sections.php');
?>
<h3 class="mt-5">Gestion des sections de la boutique</h3>
<div class="col-6 mt-3">
    <h4>Table de gestion</h4>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-borderless table-anticbeige align-middle"
        >
            <thead class="table-light">
                <caption>
                </caption>
                <tr>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php echo $table; ?>
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
    <h4>Modifications</h4>
    <?php
        if (isset($_GET['id']) && $_GET['id'] != NULL) {
            ?>
            <form action="#" method="post" enctype="multipart/form-data" class="mt-3 text-start">
                <!-- nom section -->
                <div class="mb-3">
                    <label for="nom_section" class="form-label">Nom de la section</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nom_section"
                        id="nom_section"
                        aria-describedby="helpId1"
                        placeholder=""
                        value="<?php echo $nom_section; ?>"
                    />
                    <small id="helpId1" class="form-text text-muted">Nom de la section</small>
                </div>
                <!-- descriptif -->
                <div class="mb-3">
                    <label for="descriptif_section" class="form-label">Texte de présentation de la section</label>
                    <textarea class="form-control" name="descriptif_section" id="descriptif_section" rows="10"><?php echo $descriptif_section; ?></textarea>
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
                    <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-2 ms-auto">
                </div>
            </form>
            <?php
        }
    ?>
    
</div>
<div class="col-6 mt-3">
    <h4>Aperçu en page d'accueil</h4>
    <?php
    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        ?>
        <div class="card position-relative  border-0 card_cat">
            <a>
                <img class="card-img-top " src="../public/assets/img/site/<?php echo $nom_img; ?>" alt="nom section" title="nom section">
                <div class="card-body position-absolute  bottom-0  start-50 translate-middle  text-center">
                    <h4 class="card-title text-white mb-3 px-5 px-lg-3"><?php echo $nom_section; ?></h4>
                    <a  class="btn btn-gris-souris rounded-pill mb-lg-3 mt-5 mt-lg-0 ">Découvrir</a>
                </div>
            </a>
        </div>
        <?php
    }
    ?>
</div>