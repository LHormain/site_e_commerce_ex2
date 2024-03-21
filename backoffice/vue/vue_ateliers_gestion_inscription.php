<?php
include('controler/traitement_ateliers_gestion_inscription.php');
?>
<h3>Liste des inscriptions pour l'atelier : <?php echo $donnees['nom_atelier']; ?></h3>
<?php echo $recapitulatif; ?>
<div class="table-responsive">
    <table class="table table-striped
    table-hover	
    table-bordered
    align-middle">
        <thead class="table-primary">
            <!-- <caption>Table Name</caption> -->
            <tr>
                <th>Nom client</th>
                <th>Horaires</th>
                <th>Nombre de place réservé</th>
                <th>Envoyer un message</th>
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