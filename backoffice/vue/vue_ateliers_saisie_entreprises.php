<?php
include_once('controler/traitement_ateliers_saisie_entreprises.php');
?>

<div class="col-9 offset-1">
    <h3 class="mb-5">Saisie <?php echo $titre; ?> à afficher sur la page atelier team building</h3>

    <a
        class="btn btn-camel text-light "
        href="index.php?page=320&d=2"
        role="button"
        >Retour à la gestions des images</a
    >
    
    <div class="row">
        <form action="#" method="post" enctype="multipart/form-data" class=" text-start mt-5">
            <div class="mb-3">
                <!-- entreprise -->
                <label for="nom_entreprise" class="form-label">Nom de l'entreprise</label>
                <input
                    type="text"
                    class="form-control"
                    name="nom_entreprise"
                    id="nom_entreprise"
                    aria-describedby="helpId1"
                    placeholder="nom de l'entreprise"
                />
                <small id="helpId1" class="form-text text-muted">Entrer le nom de l'entreprise qui apparaîtra sur le site si l'image a des difficultés à charger</small>
            </div>
            <div class="mb-3">
                <!-- logo -->
                <label for="nom_img" class="form-label">Nom <?php echo $image; ?></label>
                <input
                    type="text"
                    class="form-control"
                    name="nom_img"
                    id="nom_img"
                    aria-describedby="helpId2"
                    placeholder=""
                />
                <small id="helpId2" class="form-text text-muted">entrer un nom</small>
            </div>
            <div class="mb-3">
                <!-- fichier -->
                <label for="photo" class="form-label">Choisir un fichier</label>
                <input
                    type="file"
                    class="form-control"
                    name="photo"
                    id="photo"
                    placeholder=""
                    aria-describedby="fileHelpId"
                />
                <div id="fileHelpId" class="form-text">Image jpeg, jpg, png, gif ou webp. Max 256Mo.</div>
            </div>
            <div class="text-end">
                <input type="submit" value="Enregistrer" class="btn btn-camel text-light  my-3 rounded-pill">    
            </div>
        </form>
    </div>
</div>