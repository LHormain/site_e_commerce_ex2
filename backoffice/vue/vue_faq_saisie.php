<?php
include_once('controler/traitement_faq_saisie.php');
?>
<h3 class="mt-5"><?php echo $titre;?> de la FAQ</h3>
<form action="#" method="post" class="text-start offset-2 col-8">
    <div class="text-center">
        <?php echo $texte_page;?>
    </div>
    <div class="mb-3">
        <label for="question_faq" class="form-label">Question</label>
        <input
            type="text"
            class="form-control"
            name="question_faq"
            id="question_faq"
            aria-describedby="helpId1"
            placeholder=""
            value="<?php echo $question_faq;?>"
        />
        <small id="helpId1" class="form-text text-muted">Entrer la question</small>
    </div>
    <div class="mb-3">
        <label for="reponse_faq" class="form-label">Réponse</label>
        <textarea class="form-control" name="reponse_faq" id="reponse_faq" rows="10"><?php echo $reponse_faq;?></textarea>
    </div>
    <div class="text-end">
        <input type="submit" value="Enregistrer" class="btn btn-camel text-light  rounded-pill">
    </div>
</form>