<?php
//-----------------------------------------------------------
// traitement d'une demande de devis puis envoie mail
// au gérant du site pour lui signaler une nouvelle
// demande de devis puis renvoie sur la bonne page
//-----------------------------------------------------------
if (isset(
$_POST['date_evenement_devis'],
$_POST['nbr_invite'],
$_POST['type_evenement'],
$_POST['adresse_evenement'],
$_POST['panier_location'],
$_POST['message_devis']
)
&& $_POST['date_evenement_devis'] != NULL
&& $_POST['nbr_invite'] != NULL
&& $_POST['type_evenement'] != NULL
&& $_POST['adresse_evenement'] != NULL
&& $_POST['panier_location'] != NULL
&& $_POST['message_devis'] != NULL
) {
    $date_evenement_devis = strtotime(htmlspecialchars($_POST['date_evenement_devis']));
    $nbr_invite = htmlspecialchars($_POST['nbr_invite']);
    $type_evenement = htmlspecialchars($_POST['type_evenement']);
    $adresse_evenement = htmlspecialchars($_POST['adresse_evenement']);
    $panier_location = intval($_POST['panier_location']);
    $message_devis = htmlspecialchars($_POST['message_devis']);

    // récupération de l'id utilisateur, obligé d'être connecté pour être sur cette page
    if (isset($_POST['id_user']) && $_POST['id_user'] != NULL) {
        $id_user = intval($_POST['id_user']);
    }

    if (isset($_GET['mod']) && $_GET['mod'] != NULL) {
        $id_devis = intval($_GET['mod']);
        // modifie le devis
        req_update_devis_location($bdd,$id_devis,$date_evenement_devis,$nbr_invite,$type_evenement,$adresse_evenement,$panier_location,$message_devis);

    }
    else {

        // enregistrement en base de données
        req_insert_devis_location($bdd,$id_user,$date_evenement_devis,$nbr_invite,$type_evenement,$adresse_evenement,$panier_location,$message_devis);
    }

    // envoie d'un mail à l'admin pour lui signaler une demande de devis
    $mail = $mail_site;

    $sujet_txt = 'Demande d\'un devis événementiel';
    $nom_contact = req_id_client($bdd);
    
    $sujet_mail = $nom_entreprise.': '.$sujet_txt; // récupérer la version texte du sujet
    $message = 'Vous avez reçus un nouveau message de '.$nom_contact['prenom_utilisateur'].' '.$nom_contact['nom_utilisateur'].'. <br> Le '.date('d-m-Y à H:i', time()).' : <br><br>'.$message_devis;

    $headers = "From : ".$nom_contact['mail_utilisateur']."\r\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

    // mail basique
    mail($mail, $sujet_mail, $message, $headers);

                //// provisoire en attendant d'envoyer mail: écrit dans un fichier
                // $file = '../test/test_devis_location.html';
                // $current = file_get_contents($file);
                // $current = $sujet_mail.'</br>';
                // $current .= $message;
                // file_put_contents($file, $current);


    ?>
    <script>window.location.assign("index.php?page=212&m=1")</script>
    <?php

}
else {
    ?>
    <script>window.location.assign("index.php?page=212&m=0")</script>
    <?php
}
?>