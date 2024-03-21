<?php
include_once('controler/traitement_contacts_detail.php');
?>
<h4 class="my-5"><?php echo $contact['nom_sujet']; ?></h4>
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
    <div class="d-flex align-items-start">
        <a
    
            class="btn btn-camel text-light  mx-3"
            href="index.php?page=800&c=1"
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

        
    </div>
    
</div>
    
<script src="public/assets/js/gestion_repondu.js"></script>