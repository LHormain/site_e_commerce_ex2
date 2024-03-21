<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

// récupération des données pour un update

if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_projet = intval($_GET['id']);
    $projet = req_projet($bdd,$id_projet);

    
    if (isset($_GET['img']) && $_GET['img'] != NULL) {
        $id_img = intval($_GET['img']);
        $image = req_img_site($bdd,$id_img);
        
        $titre = 'Modification d\'une ';
        $nom_image = trim_image_name($image['nom_img']);
    }
    else {
        $titre = 'Saisie d\'une ';
        $nom_image = '';
    }
}
else {
    $titre = 'Saisie d\'une ';
    $nom_image = '';
}

// traitement
if (isset($_POST['nom_img_atelier'])
&& $_POST['nom_img_atelier'] != NULL
) {
    $nom_image = htmlspecialchars($_POST['nom_img_atelier']).$timestamp;

    // enregistre l'image
    if (isset($_FILES['photo']) && $_FILES['photo'] != NULL) {
        $extensions_valides = array('jpeg','jpg','png', 'gif', 'webp'); 
        $extension_upload = substr(strrchr($_FILES['photo']['name'],'.'),1);
        
        if(in_array($extension_upload, $extensions_valides)) {     
            $nom_image = $nom_image.'.'.$extension_upload;
            $chemin = $dossier."/".$nom_image;       
            $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);  
            // ajoute un watermark 
            GenerateWatermarkedImage($chemin, $chemin);
            if($resultat) {
                echo '<h4 class="mt-5">Transfert reussi</h4>';   
                
                if (isset($_GET['img'])&& $_GET['img'] != NULL) {
                    $id_img = intval($_GET['img']);

                    // supprime l'ancienne image dans le dossier
                    $donnees = req_img_site($bdd,$id_img);
                    $chemin = $dossier.'/'.$donnees['nom_img'];
                    if (file_exists($chemin)) {
                        unlink($chemin);
                    }

                    // UPDATE  nouvelle image
                    req_img_update_site($bdd,$id_img,$nom_image);
                    $image = req_img_site($bdd,$id_img);
                }
                else {
                    // INSERT
                    $id_img = req_img_insert_projet($bdd,$id_projet,$nom_image);
                    $image = req_img_site($bdd,$id_img);
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
}


?>