<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

// récupération des données pour une update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_partenaire = intval($_GET['id']);

    $partenaire = req_partenaire($bdd, $id_partenaire);
    $nom_partenaire = $partenaire['nom_partenaire'];
    $mail_partenaire = $partenaire['mail_partenaire'];
    $adresse_site_partenaire = $partenaire['adresse_site_partenaire'];
    $description_partenaire = $partenaire['description_partenaire'];
    $tel_partenaire = $partenaire['tel_partenaire'];

    $logo = req_img_site($bdd,$partenaire['id_img']);
    $nom_img = $logo['nom_img'];
}
else {
    $nom_partenaire = "";
    $mail_partenaire = "";
    $adresse_site_partenaire = "";
    $description_partenaire = "";
    $tel_partenaire = "";
    $nom_img = "";
}

//traitement
if (isset($_POST['nom_partenaire'],
$_POST['mail_partenaire'],
$_POST['adresse_site_partenaire'],
$_POST['description_partenaire'],
$_POST['tel_partenaire'],
$_POST['nom_img']
)
&& $_POST['nom_partenaire'] != NULL
&& $_POST['mail_partenaire'] != NULL
&& $_POST['adresse_site_partenaire'] != NULL
&& $_POST['description_partenaire'] != NULL
&& $_POST['tel_partenaire'] != NULL
&& $_POST['nom_img'] != NULL
) {
    $nom_partenaire = htmlspecialchars($_POST['nom_partenaire']);
    $mail_partenaire = htmlspecialchars($_POST['mail_partenaire']);
    $adresse_site_partenaire = htmlspecialchars($_POST['adresse_site_partenaire']);
    $description_partenaire = htmlspecialchars($_POST['description_partenaire']);
    $tel_partenaire = htmlspecialchars($_POST['tel_partenaire']);
    $nom_image = htmlspecialchars($_POST['nom_img']).$timestamp;

    // enregistrement du logo
    if (isset($_FILES['photo']) && $_FILES['photo'] != NULL) {
        $extensions_valides = array('jpeg','jpg','png', 'gif', 'webp'); 
        $extension_upload = substr(strrchr($_FILES['photo']['name'],'.'),1);
        
        if(in_array($extension_upload, $extensions_valides)) {     
            $nom_image = $nom_image.'.'.$extension_upload;
            $chemin = $dossier."/".$nom_image;       
            $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);  
            if($resultat) {
                echo '<h4 class="mt-5">Transfert réussi</h4>';   
                
                if (isset($_GET['id'])&& $_GET['id'] != NULL) {
                    $id_partenaire = intval($_GET['id']);

                    // supprime l'ancienne image dans le dossier
                    $partenaire = req_partenaire($bdd, $id_partenaire);
                    $donnees = req_img_site($bdd,$partenaire['id_img']);
                    $chemin = $dossier.'/'.$donnees['nom_img'];
                    if (file_exists($chemin)) {
                        unlink($chemin);
                    }

                    // UPDATE  nouvelle image
                    req_img_update_site($bdd,$partenaire['id_img'],$nom_image);
                }
                else {
                    // INSERT
                    $id_img = req_img_site_insert($bdd,$nom_image);
                    $image = req_img_site($bdd,$id_img['id_img']);
                }

                $texte_page_courante =' <h4>L\'opération à été réalisé avec succès</h4>';
                    
            } 
            else {
                $texte_page_courante = '<h4>Un problème s\'est produit.</h4>';
            }
        }
        else {
    
            $texte_page_courante =' <h4>votre fichier n\'est pas valide.</h4>';
        }
    }
    // enregistre l'atelier
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ) {
        //update
        $id_partenaire = intval($_GET['id']);

        req_partenaire_update($bdd,$nom_partenaire,$mail_partenaire,$adresse_site_partenaire,$description_partenaire,$tel_partenaire,$id_partenaire);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert
        req_partenaire_insert($bdd,$nom_partenaire,$mail_partenaire,$adresse_site_partenaire,$description_partenaire,$tel_partenaire,$image['id_img']);

    }


}
?>