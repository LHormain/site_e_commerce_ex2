<?php
include_once('controler/traitement_ateliers_gestion_images.php');
?>

<h3 class="mt-3">Gestion des images de l'atelier : <?php echo $donnees['nom_atelier']; ?></h3>

<div class="my-3 text-start">
    <a class="btn btn-camel text-light " href="index.php?page=300&c=6&id=<?php echo $id_atelier; ?>" role="button">Ajouter une image</a>
</div>
<div class="table-responsive">
    <table class="table table-anticbeige table-striped
    table-hover	
    table-bordered
    align-middle">
        <thead class="table-anticbeige">
            <caption></caption>
            <tr>
                <th>Image</th>
                <th>Ordre d'affichage</th>
                <th>Modifier</th>
                <th>Supprimer</th>
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
<script src="public/assets/js/input_position_img_ateliers.js"></script>