<?php
//---------------------------------------------------------
// traitement de la page de demande de nouveau mdp
//---------------------------------------------------------
$message = '';

if (isset($_POST['mail']) && $_POST['mail'] != NULL) {
    $mail = htmlspecialchars($_POST['mail']);

    // génération d'une clé aléatoire et d'une date d'expiration de 30 minutes à conté du moment de création
    $token = bin2hex(random_bytes(16));
    $token_hash = password_hash($token, PASSWORD_DEFAULT);
    $expiration_date = time() + 60*30;

    // update l'utilisateur avec le token et la date
    $nbr = req_token($bdd, $expiration_date, $token_hash,$mail);

    // conte le nombre de ligne affecté par la requête si = 1 envoie le message
    if ($nbr == 1) {
        $message_content = 'Cliquez <a href="http://localhost/projet/qualis_arma/mvc/index.php?page=314&token='.$token.'">ici</a> pour r&eacute;initialiser votre mot de passe.';
        $subject = 'r&eacute;initialisation de votre mot de passe';

        $headers = "From : ".$mail_site."\r\n";
        $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

        //// provisoire en attendant d'envoyer mail: écrit dans un fichier
        $file = '../test/test_mdp_change.html';
        $current = file_get_contents($file);
        $current = $subject;
        $current .= $message_content;
        file_put_contents($file, $current);
        //// fin provisoire

        // mail basique
        // mail($mail, $subject, $message_content, $headers);
    }
    $message = '<div class="text-center my-5">Un liens pour réinitialiser votre mot de passe vient d\'être envoyé sur votre boite mail. Il sera valide 30 minutes.</div>';

}
else {
    $message = '<div class="text-center my-5">Une erreur est survenue. Veuillez contacter un administrateur.</div>';
}

?>