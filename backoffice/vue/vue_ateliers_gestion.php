<?php
include_once('controler/traitement_ateliers_gestion.php');
?>
<!-- <h3 class="my-5">Gestion des ateliers</h3> -->
<div class="d-flex justify-content-end">
    <?php table_legend();?>
</div>
<div class="table-responsive mt-5">
    <table class="table table-anticbeige table-striped
    table-hover	
    table-bordered
    align-middle">
        <thead class="table-anticbeige">
            <caption></caption>
            <tr>
                <th>Titre</th>
                <th>Nombre de participant maximum</th>
                <th>Inscriptions</th>
                <th>Prix unitaire</th>
                <th>Images</th>
                <th>Dates</th>
                <th>Afficher</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                    echo $table;
                ?>
            </tbody>
            <tfoot>
                
            </tfoot>
    </table>
</div>

<script src="public/assets/js/gestion_affichage_ateliers.js"></script>