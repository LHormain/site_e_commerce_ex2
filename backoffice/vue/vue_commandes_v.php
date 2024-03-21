<?php
include_once('controler/traitement_commandes_v.php');
?>
<div class="col-10 p-5 text-center">
    <h2 class="mb-5">Gestion des commandes de la boutique</h2>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-borderless table-anticbeige align-start"
        >
            <thead class="table-light">
                <caption>
                </caption>
                <tr>
                    <th><a href="index.php?page=610&ordre=1<?php if (isset($id_user)) {echo '&id='.$id_user;} ?>">N° commande</a></th>
                    <th>Date</th>
                    <th>Nombre de produits </th>
                    <th>Montant total TTC</th>
                    <th><a href="index.php?page=610&ordre=2<?php if (isset($id_user)) {echo '&id='.$id_user;} ?>">Client</a></th>
                    <th>Adresse de livraison</th>
                    <th>Adresse de facturation</th>
                    <th>État commande</th>
                    <th>État livraison</th>
                    <th>Demande de devis</th>
                    <th>Récapitulatif de la commande</th>
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
<script src="public/assets/js/select_livraison.js"></script>