<?php
$texte_page_courante = '';
// -----------------------------------------------------------
//                traitement de la connexion
// -----------------------------------------------------------
if (isset($_POST['pwd'], $_POST['mail_utilisateur']) && $_POST['pwd'] != NULL && $_POST['mail_utilisateur']) {
    // action de connection

    $pwd = $_POST['pwd'];
    $mail_utilisateur = htmlspecialchars($_POST['mail_utilisateur']);
    
   $donnees = req_mail($bdd,$mail_utilisateur);
   $user = $donnees[0];
   $compte = $donnees[1];

    if ($compte != 0) {
        if (password_verify($pwd, $user['mdp_utilisateur'])) {
            
            $_SESSION['id_client'] = $user['identifiant_client'];
            // teste si un panier a été créer. Si oui update l'id_client 
            update_panier_si_existe($bdd,$user['id_user']);
            
            if (isset($_GET['ins']) && $_GET['ins'] != NULL)  {
                ?>
                <script>
                    // renvois sur la page atelier
                    window.location.assign("index.php?page=230&ins=1");
                </script>
                <?php
            }
            elseif (isset($_GET['btq']) && $_GET['btq'] != NULL) {
                $btq = intval($_GET['btq']);
                if ($btq == 1) {
                ?>
                <script>
                    // renvoie à la page panier
                    window.location.assign("index.php?page=204&c=1");
                </script>
                <?php

                }
                else {
                ?>
                <script>
                    // renvoie à la page panier location
                    window.location.assign("index.php?page=204&c=2");
                </script>
                <?php
                }
            }
            elseif (isset($_GET['dl']) && $_GET['dl'] != NULL) {
                ?>
                <script>
                    // renvoie à la page panier location
                    window.location.assign("index.php?page=211");
                </script>
                <?php
            }
            else {
            ?>
            <script>
                // force le rechargement de la page
                window.location.assign("index.php?page=310");
            </script>
            <?php
            }

        }
        else {
            $texte_page_courante = '<p style="color: red;">Identifiant ou mot de passe incorrecte</p>';
        }
    }
    else {
        $texte_page_courante = '<p style="color: red;">Utilisateur inconnu</p>';
    }

} 
else {
    // action pas de connection
}


?>