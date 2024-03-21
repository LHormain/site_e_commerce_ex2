<?php
include_once('controler/traitement_paniers_v.php');
?>
<div class="col-10 p-5 text-center">
    <h2 class="mb-5">Gestion des paniers</h2>
    
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
                    <th>n° panier</th>
                    <th><a href="index.php?page=600&ordre=1">Date</a></th>
                    <th>Nombre de produits</th>
                    <th>Montant TTC</th>
                    <th>Client</th>
                    <th>Récapitulatif</th>
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