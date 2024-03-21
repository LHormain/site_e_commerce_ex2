<?php
include_once('controler/traitement_devis_v.php');
?>
<div class="col-10 p-5 text-center">
    <h2 class="mb-5">Gestion des devis livraisons</h2>
    <div
        class="table-responsive"
    >
    <div class="text-end">

    <?php
        echo table_legend();
    ?>
    </div>
        <table
            class="table table-striped table-hover table-borderless table-anticbeige align-middle"
        >
            <thead class="table-light">
                <caption>
                </caption>
                <tr>
                    <th>N° de devis</th>
                    <th><a href="index.php?page=620&ordre=1<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">Date de création</a></th>
                    <th>N° du panier associé</th>
                    <th>N° de la facture associée</th>
                    <th>Adresse de livraison</th>
                    <th><a href="index.php?page=620&ordre=2<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">Client</a></th>
                    <th>Voir et traiter</th>
                    <th>Envoyer un message</th>
                    <th><a href="index.php?page=620&ordre=3<?php if (isset($id_user)) {echo '&id='.$id_user;}?>">État</a></th>
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
<script src="public/assets/js/gestion_btn_repondre_dl.js"></script>