<?php

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

    
    // prépare le mail et l'envoie avec mail()
    
    $headers = "From : contact@qualisarma.com\r\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    
            //// provisoire en attendant d'envoyer mail: écrit dans un fichier
            // $file = '../../test/test_newsletter.html'; ///
            // $current = file_get_contents($file); ///
            // $current = $sujet.'</br>'; ///
            // $current .= $message.$signature.$unsubscribe; ///
    
    foreach ($subscribers as $s) {
        // $mail = $s['mail_utilisateur'];
        mail($mail, $sujet, $message, $headers);
    
        // $nom = $s['prenom_utilisateur'].' '.$s['nom_utilisateur'];

            // $current .= '<br>To : '.$s['mail_utilisateur'].' '.$nom; ///
            // file_put_contents($file, $current); ///

}
}


?>