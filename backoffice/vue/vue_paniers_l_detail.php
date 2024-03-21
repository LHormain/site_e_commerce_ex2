<?php
include_once('controler/traitement_paniers_l_detail.php');
?>

<div class="col-10 p-5 text-center">
    <h2 class="mb-5"><?php echo $titre;?> n° <?php echo $id_commande;?></h2>
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
                    <th>Produit n° </th>
                    <th>Nom produit</th>
                    <th>Nombre de produits</th>
                    <th>Prix unitaire HT</th>
                    <th>Montant HT</th>
                    <th>Montant TTC</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php echo $table;?>

            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo number_format($prix,2,'.', ' '); ?></td>
                    <td><?php echo number_format($prix*(1+20/100),2,'.', ' '); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="no-print row ">
        <div class="col-1">
            <a
                class="btn btn-camel rounded-pill text-light"
                href="index.php?page=<?php echo $page;?>"
                role="button"
                >Retour</a
            >
        </div>
        <div class="col-1">
            <button 
                type="button"
                class="btn btn-camel text-light rounded-pill "
                id="imprimer"
            >
                Imprimer
            </button>
        </div>
        
    </div>
</div>
<script src="public/assets/js/print.js"></script>