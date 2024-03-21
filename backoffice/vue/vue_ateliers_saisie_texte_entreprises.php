<?php
include_once('controler/traitement_ateliers_saisie_texte_entreprises.php');
?>
<h3 class="mt-3 text-center"><?php echo $titre; ?> paragraphe </h3>
<p><?php echo $texte_page_courante; ?></p>
<div class="offset-1">
    <a
        class="btn btn-camel text-light "
        href="index.php?page=320&d=1"
        role="button"
        >Retour à la gestions du texte</a
    >

</div>
<div class="row">
    <form action="#" method="post" class="col-10 offset-1 text-start mt-5">
        <!-- titre -->
        <div class="mb-3">
            <label for="titre_tb_txt" class="form-label">Titre du paragraphe</label>
            <input
                type="text"
                class="form-control"
                name="titre_tb_txt"
                id="titre_tb_txt"
                aria-describedby="helpId"
                placeholder="Titre du paragraphe"
                value="<?php echo $titre_tb_txt; ?>"
            />
            <small id="helpId" class="form-text text-muted">Entrer un titre pour le paragraphe. Pour un paragraphe sans titre entrer un seul espace dans ce champ.</small>
        </div>
        <!-- texte -->
        <div class="mb-3">
            <label for="descriptif_tb_txt" class="form-label">Paragraphe</label>
            <textarea class="form-control" name="descriptif_tb_txt" id="descriptif_tb_txt" rows="10"><?php echo $texte_tb_txt; ?></textarea>
        </div>
        
        <!-- enregistrer -->
        <div class="text-end">
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  px-5 ms-auto rounded-pill">
        </div>

    </form>
</div>