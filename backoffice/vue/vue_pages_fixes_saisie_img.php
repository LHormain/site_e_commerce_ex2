<?php
include_once('controler/traitement_pages_fixes_saisie_img.php');
?>
<h3 class="mt-3">Saisie d'une image</h3>

<div class="my-5 text-start offset-2 col-8">

    <a
        class="btn btn-camel text-light"
        href="index.php?page=<?php echo $page;?>"
        role="button"
        >Retour</a
    >
</div>
<div class="row">
    <form action="#" method="post" class="col-8 offset-2 text-start" enctype="multipart/form-data">
        <div class="row  ">
            <div class='text-center'>
                <?php echo $texte_page_courante;?>
            </div>
            <!-- nom image -->
            <div class="mb-3  ">
                <label for="nom_image" class="form-label">Nom de l'image</label>
                <input type="text"
                  class="form-control" name="nom_image" id="nom_image" aria-describedby="helpId1" placeholder="" >
                <small id="helpId1" class="form-text text-muted">Entrer le  nom de l'image.Pas de caractères spéciaux ou d'espace.</small>
            </div>
           <!-- fichier image -->
            <div class="mb-3">
              <label for="photo" class="form-label">Choisir un fichier image</label>
              <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId">
              <div id="fileHelpId" class="form-text">jpeg, jpg, png ou  gif. Max 256Mo.</div>
            </div>
            <!-- enregistrer -->
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-3 mb-3 ms-auto align-self-end rounded-pill">
        </div>
    </form>
</div>