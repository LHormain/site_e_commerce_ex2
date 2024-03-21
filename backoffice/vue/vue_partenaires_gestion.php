<?php
include_once('controler/traitement_partenaires_gestion.php');
?>
<h3 class="mt-5">Gestion des partenaires</h3>
<div class="d-flex justify-content-end">
    <?php table_legend();?>
</div>
<div
    class="table-responsive mt-3"
>
    <table
        class="table table-striped table-hover table-borderless table-anticbeige align-middle"
    >
        <thead class="table-light">
            <caption>
            </caption>
            <tr>
                <th scope="col">Logo</th>
                <th scope="col">Nom</th>
                <th scope="col">Site internet</th>
                <th scope="col">Mail</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Afficher</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
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

<script src="public/assets/js/gestion_affichage_partenaires.js"></script>