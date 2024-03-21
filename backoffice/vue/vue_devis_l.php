<?php
include_once('controler/traitement_devis_l.php');
?>
<div class="col-10 p-5 text-center">
    <h2 class="mb-5">Gestion des devis événementiels</h2>
    <div class="text-end">

    <?php
        echo table_legend();
    ?>
    </div>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-borderless table-anticbeige align-middle"
        >
            <thead class="table-light">
                <caption>
                </caption>
                <tr>
                    <th>N° de demande de devis</th>
                    <th><a href="index.php?page=720&ordre=1<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">Date de création</a></th>
                    <th><a href="index.php?page=720&ordre=3<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">Date de l'événement</a></th>
                    <th>N° du panier location associé</th>
                    <th>Adresse de l'événement</th>
                    <th><a href="index.php?page=720&ordre=2<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">Client</a></th>
                    <th>Voir</th>
                    <th>Répondre</th>
                    <th><a href="index.php?page=720&ordre=4<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">État</a></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php echo $table;?>

            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
    
</div>
<script src="public/assets/js/gestion_btn_repondre.js"></script>