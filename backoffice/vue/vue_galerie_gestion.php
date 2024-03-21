<?php
include_once('controler/traitement_galerie_gestion.php');
?>
<h3 class="mt-5">Gestion des projets finis exposés en exemple de réalisation pour les futurs clients</h3>
<div class="d-flex justify-content-end offset-1 col-10">
    <?php table_legend();?>
</div>
<div
    class="table-responsive offset-1 col-10"
>
    <table
        class="table table-striped table-hover table-bordered table-anticbeige align-middle"
    >
        <thead class="table-light">
            <caption>
                
            </caption>
            <tr>
                <th scope="col">Nom du projet</th>
                <th scope="col">Galerie d'images</th>
                <th scope="col">Afficher</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php echo $table; ?>
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</div>
<script src="public/assets/js/gestion_affichage_projet.js"></script>