<?php
include_once('controler/traitement_devis_l_detail.php');
?>
<div class="col-10 p-5 ">
    <h2 class="mb-5 text-center">Devis n° <?php echo $devis['id_devis'] ?></h2>
    <div class="row">
        <!-- détails client -->
        <h3>Client :</h3>
        <p class="col-3"><strong>Nom : </strong><?php echo $devis['nom_utilisateur']; ?></p>
        <p class="col-9"><strong>Prénom :</strong> <?php echo $devis['prenom_utilisateur']; ?></p>
        <p class="col-3"><strong>Tel : </strong><?php echo $devis['tel_utilisateur']; ?></p>
        <p class="col-9"><strong>E-mail :</strong> <?php echo $devis['mail_utilisateur']; ?></p>
        <!-- détails devis -->
        <h3>Devis : </h3>
        <p><strong>Date de création du devis :</strong> <?php echo date('d/m/Y',$devis['date_devis']); ?></p>
        <p><strong>Date de l'événement : </strong><?php echo date('d/m/Y',$devis['date_evenement_devis']); ?></p>
        <p><strong>Adresse de l'événement : </strong><?php echo $devis['adresse_evenement']; ?></p>
        <p><strong>Type d'événement : </strong><?php echo $devis['type_evenement']; ?></p>
        <p><strong>Informations complémentaire et demande de pièces uniques : </strong><br><?php echo $devis['message_devis']; ?></p>
        <p><strong>Panier location associé:</strong> <a href="index.php?page=710&id=<?php echo $devis['id_location'] ?>&c=3" class="btn btn-link">Voir détail</a></p>
        <p>
        <?php
            if ($devis['fichier_devis_location'] != NULL) {
                ?>
            <strong>Devis joint pour le client :</strong>
            <!--  bouton bootstrap modal qui affiche le fichier -->
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#devisModal">
                Voir le devis
            </button>
            <div class="modal fade" id="devisModal" tabindex="-1" aria-labelledby="devisModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="devisModalLabel">Devis</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $devis['fichier_devis_location']; ?>" type="application/pdf" width="1100" height="600">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
            ?>
            </p>
            <p class="mb-5">
            <?php
            if ($devis['fichier_facture_location'] != NULL) {
                ?>
            <strong>Facture jointe pour le client :</strong>
            <!--  bouton bootstrap modal qui affiche le fichier -->
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#factureModal">
                Voir la facture
            </button>
            <div class="modal fade" id="factureModal" tabindex="-1" aria-labelledby="factureModalTarget" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="factureModalTarget">Facture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $devis['fichier_facture_location']; ?>" type="application/pdf" width="1100" height="600">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
        ?>
    </p>
        <div class="d-flex align-items-start">

            <!-- état devis -->
            <div class="">
                <?php echo $select_devis;?>
            </div>
            <!-- répondre au devis -->
            <div class=" ms-5 me-5">
                <a
                    id="<?php echo $devis['id_devis']; ?>"
                    class="btn btn-camel rounded-pill btn_repondre text-light"
                    href="mailto:<?php echo $devis['mail_utilisateur']; ?>?subject=Qualis%20Arma%20votre%20devis"
                    role="button"
                    >Répondre au devis</a
                >
            </div>
        </div>
        <div class="d-flex">
        <?php 
            if ($devis['id_etat'] >= 3) {
                ?>
                <form action="#" method="post" enctype="multipart/form-data" class="text-end mb-3 me-3">
                    <h5 class="text-start">Ajouter un devis</h5>
                            <!-- fichier -->
                    <div class="mb-3 ">
                        <input type="file" class="form-control" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                        <div id="fileHelpId" class="form-text">Fichier pdf. Max 256Mo.</div>
                    </div>
                    <div>

                        <input type="submit" value="Joindre un devis" class="btn btn-camel text-light ">
                    </div>
                </form>
                <form action="#" method="post" enctype="multipart/form-data" class="text-end mb-3 mx-3">
                    <h5 class="text-start">Ajouter une facture</h5>
                            <!-- fichier -->
                    <div class="mb-3 ">
                        <input type="file" class="form-control" name="file2" id="file2" placeholder="" aria-describedby="fileHelpId2">
                        <div id="fileHelpId2" class="form-text">Fichier pdf. Max 256Mo.</div>
                    </div>
                    <div>

                        <input type="submit" value="Joindre une facture" class="btn btn-camel text-light ">
                    </div>
                </form>
                <?php
            }
        ?>
        </div>
    </div>
</div>
<script src="public/assets/js/gestion_btn_repondre_detail.js"></script>