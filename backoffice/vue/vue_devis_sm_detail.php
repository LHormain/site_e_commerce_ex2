<?php
include_once('controler/traitement_devis_sm_detail.php');
?>
<h4 class="my-5">Demande de devis</h4>
<p><?php echo $texte_page_courante; ?></p>
<div class="text-start ">
    <h5 class="mb-3">Message n° <?php echo $contact['id_contact']; ?></h5>
    <p>
        <strong>Expéditeur : </strong> <?php echo $contact['nom_contact']; ?>
    </p>
    <p>
        <strong>Téléphone : </strong><?php echo $contact['tel_contact']; ?>
    </p>
    <p class="mb-5">
        <strong>Message : </strong><br>
        <?php echo $contact['message_contact']; ?>
    </p>
    <p class="">
        <?php
            if ($devis['fichier_devis_sm'] != NULL) {
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
                            <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $devis['fichier_devis_sm']; ?>" type="application/pdf" width="1100" height="600">
                            
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
            if ($devis['fichier_facture_sm'] != NULL) {
                ?>
            <strong>Facture jointe pour le client :</strong>
            <!--  bouton bootstrap modal qui affiche le fichier -->
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#factureModal">
                Voir la facture
            </button>
            <div class="modal fade" id="factureModal" tabindex="-1" aria-labelledby="factureModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="factureModalLabel">Facture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $devis['fichier_facture_sm']; ?>" type="application/pdf" width="1100" height="600">
                            
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
        <a
    
            class="btn btn-camel text-light  mx-3"
            href="index.php?page=410&c=1"
            role="button"
            >Retour à la liste des messages</a
        >
        <a
            class="btn btn-camel text-light  mx-3"
            href="mailto:<?php echo $contact['mail_contact']; ?>"
            role="button"
            onclick="gestionAfficher(<?php echo $contact['id_contact']; ?>,<?php echo $contact['repondu_contact']; ?>)"
            >Répondre</a
        >
        <div class="mb-3 mx-3">
            <select
                class="form-select form-select-md "
                name="<?php echo $devis['id_devis_sm']; ?>"
                id="select_etat"
                >
                <?php echo $select; ?>
            </select>
            <span id="message"></span>
        </div>
        <!-- a voir n'a de sens que si client connecté lors de envoie du message -->
    </div>
    <div class="d-flex">
    <?php 
        if ($devis['id_etat'] >= 3 ) {
            ?>
            <form action="#" method="post" enctype="multipart/form-data" class="text-end mb-3 mx-3">
                <h5 class="text-start">Ajouter un devis</h5>
                        <!-- fichier -->
                <div class="mb-3 ">
                    <input type="file" class="form-control" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                    <div id="fileHelpId" class="form-text">Fichier pdf. Max 256Mo.</div>
                </div>
                <input type="submit" value="Joindre un devis" class="btn btn-camel text-light  ms-auto">
            </form>
            <form action="#" method="post" enctype="multipart/form-data" class="text-end mx-3">
                <h5 class="text-start">Ajouter une facture</h5>
                        <!-- fichier -->
                <div class="mb-3 ">
                    <input type="file" class="form-control" name="file2" id="file2" placeholder="" aria-describedby="fileHelpId2">
                    <div id="fileHelpId2" class="form-text">Fichier pdf. Max 256Mo.</div>
                </div>
                <input type="submit" value="Joindre une facture" class="btn btn-camel text-light  ms-auto">
            </form>
            <?php
        }
    ?>
    </div>
    
</div>
    
<script src="public/assets/js/gestion_repondu.js"></script>
<script src="public/assets/js/update_etat_devis.js"></script>