<?php
include_once('controler/traitement_produits_gestion.php');
?>
<h3 class="mt-5">Gestion des produits de la section <?php echo $section['nom_section']; ?></h3>
<div class="offset-1 col-10 mt-5">
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
                    <th>Images</th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=1">Nom Produit</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=2">Catégorie</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=3">Sous catégorie</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=4">Prix</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=5">Stock</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=6">Unique</a></th>
                    <th><a href="index.php?page=520&c=1&s=<?php echo $id_section;?>&ordre=7">Promo</a></th>
                    <th>Afficher</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php echo $table; ?>
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
</div>
<script src="public/assets/js/gestion_affichage_produit.js"></script>
<script src="public/assets/js/input_stock.js"></script>
<script src="public/assets/js/gestion_affichage_promo.js"></script>
<script src="public/assets/js/gestion_affichage_pu.js"></script>