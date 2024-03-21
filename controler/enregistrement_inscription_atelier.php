<?php
//----------------------------------------------------------------------
// traitement de l'inscription à un atelier 
// puis envoie à la banque pour payer
//----------------------------------------------------------------------
if (isset($_POST['id_client'],
$_POST['id_atelier'],
$_POST['date_atelier'],
$_POST['nbr_inscrit']
)
&& $_POST['id_client'] != NULL
&& $_POST['id_atelier'] != NULL
&& $_POST['date_atelier'] != NULL
&& $_POST['nbr_inscrit'] != NULL
) {
    $id_user = intval($_POST['id_client']);
    $id_atelier = intval($_POST['id_atelier']);
    $id_date = intval($_POST['date_atelier']);
    $nbr_inscrit = intval($_POST['nbr_inscrit']);

    // création d'un identifiant à 6 characters. 
    $token = bin2hex(random_bytes(3));

    do {
        // test si token unique
        $table = 'inscriptions';
        $test = req_token_unique($bdd,$token,$table);

    } while ($test != 0);
 
    // enregistre l'inscription
    req_inscription_atelier($bdd,$id_user,$id_atelier,$id_date,$nbr_inscrit,$token);

    // crée la facture
    req_facture_a($bdd,$id_user,$id_atelier,$id_date);

    // envoie d'un mail à l'admin pour lui signaler une inscription (peut être à déplacer, retour de la banque)
    $mail = $mail_site;

    $sujet_txt = 'Inscription à un atelier';
    $nom_contact = req_id_client($bdd);
    
    $sujet_mail = $nom_entreprise.': '.$sujet_txt; // récupérer la version texte du sujet
    $message = 'Nouvelle inscription à un atelier de '.$nom_contact['prenom_utilisateur'].' '.$nom_contact['nom_utilisateur'].' <br> le '.date('d-m-Y à H:i', time()).'. Veuillez consulter la liste des inscris';

    $headers = "From : ".$nom_contact['mail_utilisateur']."\r\n";
    $headers .= "X-Mailer: PHP/".phpversion()."\r\n" ;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

    // mail basique
    mail($mail, $sujet_mail, $message, $headers);

                //// provisoire en attendant d'envoyer mail: écrit dans un fichier
                // $file = '../test/test_inscription.html';
                // $current = file_get_contents($file);
                // $current = $sujet_mail.'</br>';
                // $current .= $message;
                // file_put_contents($file, $current);

    // payement avec la banque
    $client = req_id_client($bdd);
    $atelier = req_atelier($bdd,$id_atelier);
    $prix = $nbr_inscrit*$atelier['tarif_atelier'];
    ?>
        <!-- <script>window.location.assign("?token=<?php echo $token; ?>&mail=<?php echo $client['mail_utilisateur']; ?>&prix=<?php echo $prix; ?>");</script> -->
    <?php
}

?>