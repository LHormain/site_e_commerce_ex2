<?php
include_once('controler/traitement_faq_gestion.php');
?>
<h3 class="mt-5">Gestion de la FAQ</h3>
<div class="offset-1 col-10 d-flex justify-content-end">
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
                <th scope="col">Question</th>
                <th scope="col">Position</th>
                <th scope="col">Afficher</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php echo $table;?>
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</div>
<script src="public/assets/js/gestion_affichage_faq.js"></script>
<script src="public/assets/js/input_position_faq.js"></script>