<?php
include_once('controler/traitement_ateliers_gestion_inscription.php');

?>

<h3 class=" mb-5">Liste des inscriptions pour l'atelier : <?php echo $donnees['nom_atelier']; ?></h3>
<?php echo $recapitulatif; ?>
<div class="table-responsive">
    <table class="table table-striped
    table-hover	
    table-bordered
    align-middle
    text-center
    table-anticbeige
    ">
        <thead class="table-anticbeige">
            <caption></caption>
            <tr>
                <th><a href="index.php?page=310&c=2&id=<?php echo $donnees['id_atelier'];?>&ordre=1">Nom client</th>
                <th><a href="index.php?page=310&c=2&id=<?php echo $donnees['id_atelier'];?>&ordre=2">Horaires</th>
                <th>Nombre de place réservé</th>
                <th>État</th>
                <th>Facture </th>
                <th>Envoyer un message</th>
                <th>Annuler</th>
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