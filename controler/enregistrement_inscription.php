<?php
//--------------------------------------------------------------
// traitement de l'inscription puis renvoie sur la bonne page
//--------------------------------------------------------------
$mdp_taille_mini = 5;

if (isset(
          $_POST['nom_utilisateur'],
          $_POST['prenom_utilisateur'],
          $_POST['mail_utilisateur'],
          $_POST['tel_utilisateur'],
          $_POST['mdp_utilisateur'],
          $_POST['mdp_check'],
          $_POST['numero_adresse_f'],
          $_POST['rue_adresse_f'],
          $_POST['code_postal_adresse_f'],
          $_POST['ville_adresse_f'],
          $_POST['id_pays_f']
          
) 
&& $_POST['nom_utilisateur'] != NULL 
&& $_POST['prenom_utilisateur'] != NULL 
&& $_POST['mail_utilisateur'] != NULL 
&& $_POST['tel_utilisateur'] != NULL 
&& $_POST['mdp_utilisateur'] != NULL 
&& $_POST['mdp_check'] != NULL 
&& $_POST['numero_adresse_f'] != NULL 
&& $_POST['rue_adresse_f'] != NULL 
&& $_POST['code_postal_adresse_f'] != NULL 
&& $_POST['ville_adresse_f'] != NULL 
&& $_POST['id_pays_f'] != NULL 

) {
    $identifiant_client = time(); 

    $nom_utilisateur = htmlspecialchars($_POST['nom_utilisateur']);
    $prenom_utilisateur = htmlspecialchars($_POST['prenom_utilisateur']);
    $mail_utilisateur = htmlspecialchars($_POST['mail_utilisateur']);
    $tel_utilisateur = htmlspecialchars($_POST['tel_utilisateur']);
    $mdp_utilisateur = $_POST['mdp_utilisateur']; 
    $mdp_check = $_POST['mdp_check'];

    // newsletter
    if (isset($_POST['newsletter']) && $_POST['newsletter'] != NULL ){
        $newsletter = intval($_POST['newsletter']);
    }
    else {
        $newsletter = 0;
    }
    
    // complement d'adresse facultatif
    if (isset($_POST['complement_adresse_f']) && $_POST['complement_adresse_f'] != NULL) {
        $adresse_facturation = [
            'numero_adresse' => htmlspecialchars($_POST['numero_adresse_f']),
            'rue_adresse' => htmlspecialchars($_POST['rue_adresse_f']),
            'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_f']),
            'ville_adresse' => htmlspecialchars($_POST['ville_adresse_f']),
            'id_pays' => htmlspecialchars($_POST['id_pays_f']),
            'complement_adresse' => htmlspecialchars($_POST['complement_adresse_f'])
        ];
    }
    else {
        $adresse_facturation = [
            'numero_adresse' => htmlspecialchars($_POST['numero_adresse_f']),
            'rue_adresse' => htmlspecialchars($_POST['rue_adresse_f']),
            'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_f']),
            'ville_adresse' => htmlspecialchars($_POST['ville_adresse_f']),
            'id_pays' => htmlspecialchars($_POST['id_pays_f']),
            'complement_adresse' => ''
        ];
    }
    // adresse de livraison facultative
    if (isset(
        $_POST['numero_adresse_l'],
        $_POST['rue_adresse_l'],
        $_POST['code_postal_adresse_l'],
        $_POST['ville_adresse_l'],
        $_POST['id_pays_l'],
    ) 
    && $_POST['numero_adresse_l'] != NULL
    && $_POST['rue_adresse_l'] != NULL
    && $_POST['code_postal_adresse_l'] != NULL
    && $_POST['ville_adresse_l'] != NULL
    && $_POST['id_pays_l'] != NULL
    ) {
        if (isset($_POST['complement_adresse_l']) && $_POST['complement_adresse_l'] != NULL) {
            $adresse_livraison = [
                'numero_adresse' => htmlspecialchars($_POST['numero_adresse_l']),
                'rue_adresse' => htmlspecialchars($_POST['rue_adresse_l']),
                'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_l']),
                'ville_adresse' => htmlspecialchars($_POST['ville_adresse_l']),
                'id_pays' => htmlspecialchars($_POST['id_pays_l']),
                'complement_adresse' => htmlspecialchars($_POST['complement_adresse_l'])
            ];
        }
        else {
            $adresse_livraison = [
                'numero_adresse' => htmlspecialchars($_POST['numero_adresse_l']),
                'rue_adresse' => htmlspecialchars($_POST['rue_adresse_l']),
                'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_l']),
                'ville_adresse' => htmlspecialchars($_POST['ville_adresse_l']),
                'id_pays' => htmlspecialchars($_POST['id_pays_l']),
                'complement_adresse' => ''
            ];
        }
    }
    else {
        if (isset($_POST['complement_adresse_f']) && $_POST['complement_adresse_f'] != NULL) {
            $adresse_livraison = [
                'numero_adresse' => htmlspecialchars($_POST['numero_adresse_f']),
                'rue_adresse' => htmlspecialchars($_POST['rue_adresse_f']),
                'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_f']),
                'ville_adresse' => htmlspecialchars($_POST['ville_adresse_f']),
                'id_pays' => htmlspecialchars($_POST['id_pays_f']),
                'complement_adresse' => htmlspecialchars($_POST['complement_adresse_f'])
            ];
        }
        else {
            $adresse_livraison = [
                'numero_adresse' => htmlspecialchars($_POST['numero_adresse_f']),
                'rue_adresse' => htmlspecialchars($_POST['rue_adresse_f']),
                'code_postal_adresse' => htmlspecialchars($_POST['code_postal_adresse_f']),
                'ville_adresse' => htmlspecialchars($_POST['ville_adresse_f']),
                'id_pays' => htmlspecialchars($_POST['id_pays_f']),
                'complement_adresse' => ''
            ];
        }
    }

    // pour l'update
    if (isset($_POST['id_facturation']) && $_POST['id_facturation'] != NULL) {
        $id_facturation = intval($_POST['id_facturation']);
    }
    if (isset($_POST['id_livraison']) && $_POST['id_livraison'] != NULL) {
        $id_livraison = intval($_POST['id_livraison']);
    }
    //-----------------------
    //        update
    //-----------------------
    if (isset($_GET['id']) && $_GET['id'] != NULL) {
        $id_user = intval($_GET['id']);
        // test mdp
        $utilisateur = req_mail($bdd,$mail_utilisateur);

        if (password_verify($mdp_utilisateur, $utilisateur[0]['mdp_utilisateur']) ) {

            $sortie = req_maj_utilisateur($bdd,$nom_utilisateur,
                                    $prenom_utilisateur,
                                    $mail_utilisateur,
                                    $tel_utilisateur,
                                    $adresse_facturation,
                                    $adresse_livraison,
                                    $id_user,
                                    $id_facturation,
                                    $id_livraison,
                                    $newsletter);
            ?>
            <script>window.location.assign("index.php?page=311&id=<?php echo $sortie[0];?>&fac=<?php echo $sortie[1];?>&liv=<?php echo $sortie[2]; ?>&m=4")</script>
            <?php

        }
        else {
            ?>
            <script>window.location.assign("index.php?page=311&id=<?php echo $sortie[0];?>&fac=<?php echo $sortie[1];?>&liv=<?php echo $sortie[2]; ?>&m=5")</script>
            <?php
        }
    }
    else {
        //-----------------------
        //        insert
        //-----------------------
        // tester si username_utilisateur est unique. peut faire la même chose avec adresse mail
        $test_username = req_mail($bdd,$mail_utilisateur);
    
        if (!isset($test_username[0]['mail_utilisateur'])) {
    
            // tester le mdp et le traiter si ok passe à la suite
            $mdp_hash = password_hash($mdp_utilisateur, PASSWORD_DEFAULT );
    
            if ($mdp_utilisateur == $mdp_check 
             && $mdp_utilisateur >= $mdp_taille_mini
             && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $mdp_utilisateur) 
             ) {
                $sortie = req_inscription_utilisateur($bdd,$identifiant_client,
                                                            $nom_utilisateur,
                                                            $prenom_utilisateur,
                                                            $mail_utilisateur,
                                                            $tel_utilisateur,
                                                            $mdp_hash,
                                                            $adresse_facturation,
                                                            $adresse_livraison,
                                                            $newsletter);
    
                // connecté si viens de s'inscrire
                $_SESSION['id_client'] = $identifiant_client;
                // teste si un panier a été créer. Si oui update l'id_utilisateur 
                update_panier_si_existe($bdd,$sortie[0]);
                ?>
                <script>window.location.assign("index.php?page=311&id=<?php echo $sortie[0];?>&fac=<?php echo $sortie[1];?>&liv=<?php echo $sortie[2]; ?>&m=1")</script>
                <?php
            }
            else {
                ?>
                <script>window.location.assign("index.php?page=311&m=2")</script>
                <?php
            }
        }
        else {
            ?>
            <script>window.location.assign("index.php?page=311&m=3")</script>
            <?php
        }
    }

}
?>