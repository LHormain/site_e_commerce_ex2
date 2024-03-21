<?php
//------------------------------------------------------------
// traitement du devis livraison pour les commandes vente 
// remplissant les critère d'une demande de devis
//------------------------------------------------------------
if (isset($_POST['id_commande'],
$_POST['id_livraison'],
$_POST['id_facturation'],
$_POST['jour'],
$_POST['token'],
$_POST['mail_client'],
$_POST['prix_payer'],
)
&& $_POST['id_commande'] != NULL
&& $_POST['id_livraison'] != NULL
&& $_POST['id_facturation'] != NULL
&& $_POST['jour'] != NULL
&& $_POST['token'] != NULL
&& $_POST['mail_client'] != NULL
&& $_POST['prix_payer'] != NULL
) {
    $id_commande = htmlspecialchars($_POST['id_commande']) ;
    $id_livraison = htmlspecialchars($_POST['id_livraison']) ;
    $id_facturation = htmlspecialchars($_POST['id_facturation']) ;
    $jour = htmlspecialchars($_POST['jour']) ;
    $token = htmlspecialchars($_POST['token']) ;
    $mail_client = htmlspecialchars($_POST['mail_client']) ;
    $prix_payer = htmlspecialchars($_POST['prix_payer']) ;

    // enregistre le token et la commande et le compte associé
    req_save_token($bdd,$id_commande,$jour,$token,$prix_payer,$id_livraison,$id_facturation);

    // enregistrement de la commande (déplace de panier à commande)
    req_panier_a_commande($bdd,$id_commande);

    // enregistre une demande de devis et envoie  mail au gérant pour signaler la demande
    req_save_devis_livraison($bdd,$id_commande);


    $mail = $mail_site;

    $sujet_txt = 'Demande d\'un devis livraison';
    $nom_contact = req_id_client($bdd);

    $sujet_mail = $nom_entreprise.': '.$sujet_txt; // récupérer la version texte du sujet
    $message = 'Vous avez reçus une nouvelle demande de devis de '.$nom_contact['prenom_utilisateur'].' '.$nom_contact['nom_utilisateur'].'. <br> Le '.date('d-m-Y à H:i', time()).' : <br><br>';

    $headers = "From : ".$nom_contact['mail_utilisateur']."\r\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

    // mail basique
    // mail($mail, $sujet_mail, $message, $headers);

            //// provisoire en attendant d'envoyer mail: écrit dans un fichier
            $file = '../test/test_devis_livraison.html';
            $current = file_get_contents($file);
            $current = $sujet_mail.'</br>';
            $current .= $message;
            file_put_contents($file, $current);

    // 
    $texte_page_courante = "<p>Cher client,<br><br>

    Nous vous confirmons la réception de votre demande de devis pour les frais de livraison de votre commande. Notre équipe s'engage à vous fournir une estimation précise et transparente des coûts associés à la livraison de vos produits.
    <br>
    Soyez assuré que nous mettons tout en œuvre pour vous offrir un service de qualité, avec des détails complets sur les frais de livraison. Restez à l'écoute, car les informations détaillées vous parviendront prochainement.
    <br>
    Nous apprécions votre confiance et votre compréhension. Merci de choisir Qualis Arma pour vos besoins en mobilier et décoration.
    <br><br>
    Bien cordialement,<br>
    [L'Équipe de Qualis Arma]</p>";

    // crée un nouvel id de session
    do {
        $_SESSION['id_commande'] = time();

        $test = test_id_commande($bdd,$_SESSION['id_commande']);
    } while ($test != 0);

}


?>