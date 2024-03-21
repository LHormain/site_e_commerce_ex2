<?php
include_once('controler/traitement_clients.php');
?>
<div class="col-10 p-5 text-center">

    <h2>Liste des clients</h2>
    <div class="my-3 me-5 text-end">
        <a
            class="btn btn-camel text-light rounded-pill"
            href="index.php?page=811"
            role="button"
            >Envoyer une newsletter a tous les clients abonnés</a
        >
        
    </div>
    <div
        class="table-responsive mt-5"
    >
        <table
            class="table table-striped table-hover table-bordered table-anticbeige align-middle"
        >
            <thead class="table-light">
                <caption>
                    
                </caption>
                <tr>
                    <th scope='col'><a href="index.php?page=810&ordre=1">Identifiant client</a></th>
                    <th scope='col'>Date d'inscription</th>
                    <th scope='col'><a href="index.php?page=810&ordre=2">Nom</a></th>
                    <th scope='col'><a href="index.php?page=810&ordre=3">Prénom</a></th>
                    <th scope='col'>Mail</th>
                    <th scope='col'>Téléphone</th>
                    <th scope='col'>Adresse de livraison</th>
                    <th scope='col'>Adresse de facturation</th>
                    <th scope='col'>Paniers</th>
                    <th scope='col'>Commande</th>
                    <th scope='col'>Devis</th>
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
</div>
