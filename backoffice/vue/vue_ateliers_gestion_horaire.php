<?php
include_once('controler/traitement_ateliers_gestion_horaire.php');
?>

<h3 class="mt-5">Gestion des horaires de l'atelier : <?php echo $donnees['nom_atelier']; ?></h3>
<div class="my-3 text-start">
    <a class="btn btn-camel text-light " href="index.php?page=300&c=4&id=<?php echo $id_atelier; ?>" role="button">Ajouter une horaires</a>
</div>

<div class="table-responsive">
    <table class="table table-anticbeige table-striped
    table-hover	
    table-bordered
    align-middle">
        <thead class="table-anticbeige">
            <caption></caption>
            <tr>
                <th>Horaires</th>
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