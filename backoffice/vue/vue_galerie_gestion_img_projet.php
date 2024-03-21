<?php
include_once('controler/traitement_galerie_gestion_img_projet.php');
?>
<h3 class="mt-5">Gestion des images du projet : <?php echo $projet['nom_projet']; ?></h3>
<div class="my-3 text-start offset-1 col-10">
    <a class="btn btn-camel text-light " href="index.php?page=400&c=4&id=<?php echo $projet['id_projet'] ?>" role="button" >Ajouter une image</a>
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
                <th scope="col">Image</th>
                <th scope="col">Ordre d'affichage</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php echo $table; ?>
        </tbody>
        <tfoot>
            
        </tfoot>
    </table>
</div>

<script src="public/assets/js/input_position_img_projet.js"></script>