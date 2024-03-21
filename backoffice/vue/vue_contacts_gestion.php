<?php
include_once('controler/traitement_contacts_gestion.php');
?>
<h4 class="my-5">Liste des Messages</h4>
<div class="d-flex justify-content-end">
    <?php table_legend();?>
</div>
<div
    class="table-responsive"
>
    <table
        class="table table-striped table-hover table-bordered table-anticbeige align-middle"
    >
        <thead class="table-light">
            <caption>
                
            </caption>
            <tr>
                <th scope="col"><a href="index.php?page=800&ordre=1">Message n°</a></th>
                <th scope="col"><a href="index.php?page=800&ordre=3">Date</a></th>
                <th scope="col"><a href="index.php?page=800&ordre=2">Expéditeur</a></th>
                <th scope="col">Mail</th>
                <th scope="col">Téléphone</th>
                <th scope="col"><a href="index.php?page=800&ordre=4">Sujet</a></th>
                <th scope="col">Lire</th>
                <th scope="col">Répondre</th>
                <th scope="col">Lue</th>
                <th scope="col">Répondu</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php  echo $table; ?>
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</div>
<script src="public/assets/js/gestion_repondu.js"></script>