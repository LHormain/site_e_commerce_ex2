<?php
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    // use PHPMailer\PHPMailer\Exception;
    // require_once "vendor/autoload.php";


if (isset($_POST['sujet'], 
          $_POST['message']
          )
    && $_POST['sujet'] != NULL
    && $_POST['message'] != NULL
) {
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);

    $signature = '
        <br><br>
        <p>Qualis Arma</p>
        <p><a href="http://qualisarma.com">qualisarma.com</a></p>
        <p>Tel: 06 80 07 32 96</p>
        <p>contact@qualisarma.com</p>
        <p>58 rue Saint-François 57350 Stiring-Wendel France</p>'; 
    $unsubscribe = '<br><br><a href="http://qualisarma.com" style="text-decoration: none;color=black;">Si vous souhaitez ne plus recevoir nos newsletters, il vous suffit de vous rendre sur votre page client et de désélectionner l\'option d\'abonnement dans les paramètres de votre compte. Nous respectons votre choix et vous remercions de l\'opportunité de vous servir.</a>';
    
    // récupérer la liste des clients avec leur mail
    $subscribers = req_user_newsletter($bdd);

    
    // prépare le mail et l'envoie avec phpMailer
    
    // source : https://www.ionos.fr/digitalguide/email/aspects-techniques/phpmailer/
    // try {
        //     $mail = new PHPMailer;
        
        //     // Authentification via SMTP
        //     $mail -> isSMTP();
        //     $mail -> SMTPAuth = true;
        
        //     //Connexion
        //     $mail -> Host = ""; //adresse du serveur messagerie
        //     $mail -> Port = "587"; //port
        //     $mail -> Username = ""; //nom d'utilisateur
        //     $mail -> Password = ""; //mot de passe
        //     $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //     $mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        
        //     // mail
        //     $mail -> setFrom('contact@qualisarma.com','Qualis Arma'); // expéditeur : adresse puis nom

        //// provisoire en attendant d'envoyer mail: écrit dans un fichier
        $file = '../../test/test_newsletter.html'; ///
        $current = file_get_contents($file); ///
        $current = $sujet.'</br>'; ///
        $current .= $message.$signature.$unsubscribe; ///
    
        foreach ($subscribers as $s) {
    
            $nom = $s['prenom_utilisateur'].' '.$s['nom_utilisateur'];
            
            $current .= '<br>To : '.$s['mail_utilisateur'].' '.$nom; ///
            file_put_contents($file, $current); ///
        //     $mail -> addAddress($s['mail_utilisateur'],$nom); // destinataire : adresse puis nom
        }
            
        //     $mail -> CharSet = 'UTF-8';
        //     $mail -> Encoding = 'base64';
        
        //     $mail -> isHTML(true);
        //     $mail -> Subject = $sujet;
        //     $mail -> Body = $message.$signature.$unsubscribe; // le message en HTML
        //     $mail -> AltBody = $message; // le message en texte simple
        
        //     $mail -> send();
        
        // }
    // catch (Exception $e) {
    //     echo "Mailer Error : ".$mail -> ErrorInfo;
    // }

}


?>