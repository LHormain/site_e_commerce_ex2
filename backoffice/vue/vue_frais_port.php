<?php
include_once('controler/traitement_frais_port.php');
?>

<div  class="col-10 p-5 text-center">
    <h2 class="mb-5">Gestion des frais de port pour les petits colis de moins de 15 kg</h2>
    <p>Cette table de tarif de livraison est utilisée si le poids de la commande est inférieur au poids maximal, si la somme des longueurs, largeurs et hauteurs est inférieur à 150 et si l'objet n'a pas le label "devis livraison obligatoire" sélectionné.</p>
    <p>Pour modifier une valeur entrer la valeur dans le champs et appuyer sur entré. </p>

    <div class="row">
        <div class="col-6">
            <div
                class="table-responsive"
            >
                <table
                    class="table table-anticbeige table-striped"
                >
                    <thead>
                        <tr>
                            <th scope="col">Poids en g</th>
                            <th scope="col">Zone 1</th>
                            <th scope="col">Zone 2</th>
                            <th scope="col">Zone 3</th>
                            <th scope="col">Zone 4</th>
                            <th scope="col">Zone 5</th>
                            <th scope="col">Zone 6</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $table;
                        ?>

                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="col-6 ">
            <h3>Zones</h3>
            <p class="text-start">
                <strong>Zone 1:</strong>
                <?php echo $liste_z1; ?>
            </p>
            <p class="text-start">
                <strong>Zone 2:</strong>
                <?php echo $liste_z2; ?>
            </p>
            <p class="text-start">
                <strong>Zone 3:</strong>
                <?php echo $liste_z3; ?>
            </p>
            <p class="text-start">
                <strong>Zone 4:</strong>
                <?php echo $liste_z4; ?>
            </p>
            <p class="text-start">
                <strong>Zone 5:</strong>
                <?php echo $liste_z5; ?>
            </p>
            <p class="text-start">
                <strong>Zone 6:</strong>
                Tous les autres pays
            </p>
        </div>
    </div>
</div>


<script src="public/assets/js/input_frais_port.js"></script>