<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();
// récupération des données pour une update 
if (isset($_GET['id'],$_GET['t'])
&& $_GET['id'] != NULL
&& $_GET['t'] != NULL
) {
    $id_customisation = intval($_GET['id']);
    $table = htmlspecialchars($_GET['t']);
    $image = req_filtre($bdd,$id_customisation,$table);
    if ($table == 'couleurs' || $table == 'matieres') {
        $nom_img = $image[2];
    }
    else {
        $nom_img = '';
    }
    $nom = $image[1];
}
else {
    $nom_img = '';
    $nom = '';
    $table = 'couleurs';
}

// traitement
if (isset($_POST['table'],
$_POST['nom']
)
&& $_POST['table'] != NULL
&& $_POST['nom'] != NULL
) {
    $nom = htmlspecialchars($_POST['nom']);
    $table = htmlspecialchars($_POST['table']);

    // enregistre l'atelier
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ) {
        //update
        $id_customisation = intval($_GET['id']);

        req_filtres_update($bdd,$nom,$table,$id_customisation);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert récupère l'id juste créer pour ajout de l'image si nécessaire
        $id_customisation = req_filtres_insert($bdd,$nom,$table);
        $texte_page_courante =' <h4>L\'opération à été réalisé avec succès</h4>';
    }
    
    // enregistrement de l'image pour couleur et matière
    // toujours un update 
    if (isset($_POST['nom_img']) && $_POST['nom_img'] != NULL) {
        $nom_image = htmlspecialchars($_POST['nom_img']).$timestamp;
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
                    echo '<h4 class="mt-5">Transfert réussi</h4>';   
                    
                        // supprime l'ancienne image dans le dossier si elle existe
                        $donnees = req_filtre($bdd,$id_customisation,$table);
                        if ($table == 'couleurs') {
                            if (isset($donnees['img_couleur']) && $donnees['img_couleur'] != NULL) {
                                $chemin = $dossier.'/'.$donnees['img_couleur'];
                                if (file_exists($chemin)) {
                                    unlink($chemin);
                                }
                            }
                        }
                        elseif ($table == 'matiere') {
                            if (isset($donnees['img_matiere']) && $donnees['img_matiere'] != NULL) {
                                $chemin = $dossier.'/'.$donnees['img_matiere'];
                                if (file_exists($chemin)) {
                                    unlink($chemin);
                                }
                            }
                        }
    
                        // UPDATE  
                        req_img_update_filtres($bdd,$id_customisation,$table,$nom_image);
    
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
}
?>