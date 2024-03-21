<?php
// -------------------------------------------------------------------
// traitement de l'enregistrement de la commande 
// et envoie à la banque pour payer
// -------------------------------------------------------------------
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

    if (isset($_GET['cas']) && $_GET['cas'] != NULL) {
        $cas = intval($_GET['cas']);
        
        if ($cas == 0) {
            // si paye sans devis 

            // enregistre le token et la commande et le compte associé
            req_save_token($bdd,$id_commande,$jour,$token,$prix_payer,$id_livraison,$id_facturation);
        
            // enregistrement de la commande (déplace de panier à commande)
            req_panier_a_commande($bdd,$id_commande);
            // création de la facture
            req_facture_v($bdd,$id_commande);
            // crée un nouvel id de session
            do {
                $_SESSION['id_commande'] = time();
        
                $test = test_id_commande($bdd,$_SESSION['id_commande']);
            } while ($test != 0);
        }
        elseif ($cas == 1) {
            // si paye apres avoir accepter devis

            // met a jour la ligne correspondante dans la table factures
            req_update_token($bdd,$id_commande,$jour,$token,$prix_payer,$id_livraison,$id_facturation);

            //update le devis au statut accepter
            req_update_devis_livraison($bdd,$id_commande);
            
            req_facture_v($bdd,$id_commande);
        }
    }


    // envoie à la banque pour payer
    ?>
    
    <?php
}
?>