<?php
include_once('controler/traitement_img_produits_gestion.php');
?>
<h3 class="mt-5">Gestion des images du produit <?php echo $produit['nom_produit']; ?></h3>
<div class="offset-1 col-10 mt-5">
    <div class="d-flex justify-content-end">
        <?php table_legend();?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <caption>
            </caption>
            <thead class="table-anticbeige">
                <tr>
                    <th>Image</th>
                    <th>Position image</th>
                    <th>Afficher</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                    
                    echo $table_img_produit;
                ?>
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>

</div>
<script src="public/assets/js/input_position_img_produit.js"></script>
<script src="public/assets/js/gestion_affichage_image.js"></script>