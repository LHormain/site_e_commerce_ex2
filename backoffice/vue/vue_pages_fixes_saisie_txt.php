<?php
include_once('controler/traitement_pages_fixes_saisie_txt.php');
?>
<h3 class="mt-3"><?php echo $titre;?> du texte de la page : <?php echo $titre_page;?></h3>
<div class="my-5 text-start offset-2 col-8">

    <a
        class="btn btn-camel text-light"
        href="index.php?page=<?php echo $page;?>"
        role="button"
        >Retour</a
    >
</div>

<form action="#" method="post" class="text-start offset-2 col-8">
    <div class="text-center">
        <?php echo $texte_page;?>
    </div>
    <div class="mb-3">
        <label for="titre_pf" class="form-label">Titre </label>
        <input
            type="text"
            class="form-control"
            name="titre_pf"
            id="titre_pf"
            aria-describedby="helpId1"
            placeholder=""
            value="<?php echo $titre_pf;?>"
        />
        <small id="helpId1" class="form-text text-muted">Titre du paragraphe appartenant à la page. Pour un paragraphe sans titre entrer un seul espace dans ce champ. <?php echo $titre;?></small>
    </div>
    <div class="mb-3">
        <label for="texte_pf" class="form-label">Texte</label>
        <textarea class="form-control" name="texte_pf" id="texte_pf" rows="10"><?php echo $texte_pf;?></textarea>
    </div>
    <div class="text-end">
        <input type="submit" value="Enregistrer" class="btn btn-camel text-light  rounded-pill">
    </div>
</form>