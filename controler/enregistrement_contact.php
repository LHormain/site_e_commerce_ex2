<?php
//-----------------------------------------------------
// traitement de l'envoie d'un message de contact 
// et redirection
//-----------------------------------------------------
$date_message = time();

if (isset($_POST['nom_contact'],
          $_POST['mail_contact'],
          $_POST['tel_contact'],
          $_POST['sujet'],
          $_POST['message_contact']
)
&& $_POST['nom_contact'] != NULL
&& $_POST['mail_contact'] != NULL
&& $_POST['tel_contact'] != NULL
&& $_POST['sujet'] != NULL
&& $_POST['message_contact'] != NULL
) {
    $nom_contact = htmlspecialchars($_POST['nom_contact']);
    $mail_contact = htmlspecialchars($_POST['mail_contact']);
    $sujet = intval($_POST['sujet']);
    $message_contact = htmlspecialchars($_POST['message_contact']);
    $tel_contact = htmlspecialchars($_POST['tel_contact']); 

    // enregistre en base de donnée
    $id_contact = req_save_contact($bdd,$date_message,$nom_contact,$mail_contact,$tel_contact,$sujet,$message_contact);
    if ($sujet == 1) {
        req_save_devis_sm($bdd,$id_contact);
    }

    // envoie par mail à l'admin
    $mail = $mail_site;

    $sujet_txt = req_sujet_contact($bdd,$sujet);
    
    $sujet_mail = $nom_entreprise.': '.$sujet_txt['nom_sujet']; // récupérer la version texte du sujet
    $message = 'Vous avez reçus un nouveau message de '.$nom_contact.'. <br> Le '.date('d-m-Y à H:i', $date_message).' : <br><br>'.$message_contact;

    $headers = "From : ".$mail_contact."\r\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

    // mail basique
    // mail($mail, $sujet_mail, $message, $headers);

                //// provisoire en attendant d'envoyer mail: écrit dans un fichier
                // $file = '../test/test_contact.html';
                // $current = file_get_contents($file);
                // $current = $sujet_mail.'</br>';
                // $current .= $message;
                // file_put_contents($file, $current);

    ?>
    <script>window.location.assign("index.php?page=300&m=1")</script>
    <?php
}
else {
    ?>
    <script>window.location.assign("index.php?page=300&m=0")</script>
    <?php
}
?>