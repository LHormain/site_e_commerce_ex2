<?php
include_once('controler/traitement_ateliers_saisie_horaire.php');
?>
<h3 class="mt-3"><?php echo $titre; ?> date pour l'atelier : <?php echo $nom_atelier; ?></h3>
<p><?php echo $texte_page_courante; ?></p>
<div class="row">
    <div class="mt-5 mb-3 text-start offset-1 col-10">
        <a class="btn btn-camel text-light " href="index.php?page=300&c=3&id=<?php echo $id_atelier; ?>" role="button">Retour à la gestion des horaires</a>
    </div>
    <form action="#" method="post" class="offset-1 col-10 text-start">
        <!-- date -->
        <div class="mb-3 ">
            <label for="date_atelier" class="form-label">Date de l'atelier</label>
            <input type="datetime-local" class="form-control" name="date_atelier" id="date_atelier" aria-describedby="helpId2" placeholder="" value="<?php echo $date_atelier; ?>" <?php if (!(isset($_GET['id']) && $_GET['id'] != NULL)) {echo 'required';} ?>>
            <small id="helpId2" class="form-text text-muted">Choisissez une date</small>
        </div>
        <!-- enregistrer -->
        <div class="text-end">
            <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-3 ms-auto rounded-pill">
        </div>

    </form>
</div>