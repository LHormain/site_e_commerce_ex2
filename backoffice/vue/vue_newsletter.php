<?php
include_once('controler/traitement_newsletter.php');
?>

<div class="col-10 p-5 text-center">
    <h2 class="mb-5">Newsletter</h2>
    <p>Création d'une nouvelle newsletter. En cliquant sur envoyer le message sera envoyer par mail à tous les abonnés. </p>
    <form action="#" method="post" class="text-start row">
        <div class="mb-3 offset-1 col-10">
            <label for="sujet" class="form-label">En tête</label>
            <input
                type="text"
                class="form-control"
                name="sujet"
                id="sujet"
                aria-describedby="helpId"
                placeholder=""
            />
            <small id="helpId" class="form-text text-muted">Sujet de la newsletter</small>
        </div>
        <div class="mb-3 offset-1 col-10">
            <label for="message" class="form-label">Corps du message</label>
            <textarea class="form-control" name="message" id="message" rows="10"></textarea>
        </div>
        <div class="mb-3 offset-1 col-10">
            <p>La signature contenant les informations de contact sera automatiquement ajouté à la fin du mail.</p>
        </div>
        <div class="text-end offset-1 col-10">
            <input type="submit" value="Envoyer" class="btn btn-camel text-light rounded-pill">
        </div>
    </form>
</div>