<?php
//--------------------------------------------------------------
// traitement de la demande de réinitialisation du mot de passe
//--------------------------------------------------------------
$message = '<div class="text-center my-5">Une erreur est survenue.</div>';

if (isset($_GET['token']) && $_GET['token'] != NULL) {
    $token = $_GET['token'];
    $liste_token = req_cherche_token($bdd);
    // comparer le token avec ceux de la bdd pour trouver l'utilisateur correspondant

    $id_user = '';
    foreach ($liste_token as $key) {
        
        if (password_verify($token, $key['token'])) {
            if ($key['date_expiration'] <= time()) {
                $message = '<div class="text-center my-5">La session de réinitialisation a expirer.</div>';
            }
            else {
                $id_user = $key['id_user'];
            }
        }
    }
}

// traitement du nouveau mdp
if (isset($_POST['mdp'], $_POST['mdp_confirmation'], $_POST['token'])
&& $_POST['mdp'] != NULL
&& $_POST['mdp_confirmation'] != NULL
&& $_POST['token'] != NULL
) {
    $mdp_taille_mini = 5;
    $mdp_utilisateur = $_POST['mdp']; 
    $mdp_check = $_POST['mdp_confirmation'];
    $mdp_hash = password_hash($mdp_utilisateur, PASSWORD_DEFAULT );
    $token = $_POST ['token'];
    $liste_token = req_cherche_token($bdd);

    foreach ($liste_token as $key ) {
        if (password_verify($token, $key['token'])
            && $mdp_utilisateur == $mdp_check 
            && $mdp_utilisateur >= $mdp_taille_mini
            && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $mdp_utilisateur) 
        ) {
            req_update_mdp($bdd,$id_user,$mdp_hash);
    
            $message = '<div class="text-center my-5">Votre mot de passe à été réinitialisé. Vous pouvez maintenant vous connecter.</div>';
        }
    }
}
?>