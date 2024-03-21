<?php
include_once('controler/traitement_paniers_v_detail.php');
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
                    <td>Total sans frais de port</td>
                    <td><?php echo number_format($prix,2,'.', ' '); ?></td>
                    <td><?php echo number_format($prix*(1+20/100),2,'.', ' '); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="no-print row">
        <div class="col-1">
            <a
                class="btn btn-camel text-light rounded-pill "
                href="index.php?page=<?php echo $page;?>"
                role="button"
                >Retour</a
            >
        </div>
        <div class="col-2">
            <button 
                type="button"
                class="btn btn-camel text-light rounded-pill "
                id="imprimer"
            >
                Imprimer le récapitulatif
            </button>
        </div>
        <?php
            // if ($c != 1) {
                ?>
            <!-- <form action="#" method="post" enctype="multipart/form-data" class="col-6"> -->
                <!-- <div class="row"> -->
                <!-- fichier -->
                    <!-- <div  class="col-6 pe-0"> -->
                        <!-- <input type="file" class="form-control" name="file" id="file" placeholder="" aria-describedby="fileHelpId"> -->
                        <!-- <div id="fileHelpId" class="form-text">Fichier pdf. Max 256Mo.</div> -->
                    <!-- </div> -->
                    <!-- <div class="col-5"> -->
                        <!-- <input type="submit" value="Joindre une copie de la facture" class="btn btn-camel text-light "> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </form> -->
                <?php
            // }
        ?>
                <?php
            if (isset($facture) && $facture['fichier_facture'] != NULL) {
                ?>
            <div class="col-4">
                <strong>Facture jointe pour le client :</strong>
                <!--  bouton bootstrap modal qui affiche le fichier -->
                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#devisModal">
                    Voir la facture
                </button>
                <div class="modal fade" id="devisModal" tabindex="-1" aria-labelledby="devisModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="devisModalLabel">Facture</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $facture['fichier_facture']; ?>" type="application/pdf" width="1100" height="600">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
        ?>
    </div>
    
</div>
<script src="public/assets/js/print.js"></script>