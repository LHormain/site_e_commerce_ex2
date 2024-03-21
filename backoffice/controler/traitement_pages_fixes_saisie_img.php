<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();
// récupération de la page du site sur laquelle on travaille
if (isset($_GET['sc']) && $_GET['sc'] != NULL) {
    $id_pf = intval($_GET['sc']);

    $pages_fixes = req_pages_fixes($bdd,$id_pf);

    if (in_array($id_pf, [1,2,4])){
        $page = '830&c='.$id_pf;
    }
    elseif ($id_pf == 3) {
        $page = '400&c=5';
    }
    elseif ($id_pf == 5) {
        $page = '300&c=7';
    }
}

// récupération des données pour un update
if (isset($_GET['id'])
&& $_GET['id'] != NULL
){
    $id_img = intval($_GET['id']);
    $texte_page_courante = 'Modifier les champs, tous les champs sont obligatoires';

    $donnees = req_img_site($bdd,$id_img);
    $nom_image = substr($donnees['nom_img'], 0, strrpos($donnees['nom_img'], ".")); // inutile
    $id_img = $donnees['id_img'];
}
else {
    $texte_page_courante = 'Remplissez les champs, tous les champs sont obligatoires';
    $nom_image = '';
    $id_img = '';
}

// INSERT et update
if (isset($_FILES['photo']) && $_FILES['photo'] != NULL) {
    if (isset($_POST['nom_image']
        ) 
        && $_POST['nom_image'] != NULL
        ) {
            $nom_image = htmlspecialchars($_POST['nom_image']).$timestamp;

        $extensions_valides = array('jpeg','jpg','png', 'gif', 'webp'); 
     	$extension_upload = substr(strrchr($_FILES['photo']['name'],'.'),1);

         if(in_array($extension_upload, $extensions_valides)) {     
            $nom_image = $nom_image.'.'.$extension_upload;
            $chemin = $dossier."/".$nom_image;       
            $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);  
            // ajoute un watermark 
            GenerateWatermarkedImage($chemin, $chemin);
            if($resultat) {
                echo '<p class="mt-5">Transfert reussi</p>';   
                
                if (isset($_GET['id'])
                && $_GET['id'] != NULL
                ){
                    $id_img = intval($_GET['id']);

                    // supprime l'ancienne image dans le dossier
                    $donnees = req_img_site($bdd,$id_img);
                    $chemin = '../public/assets/img/site/'.$donnees['nom_img'];
                    if (file_exists($chemin)) {
                        unlink($chemin);
                    }

                    // UPDATE  nouvelle image
                    req_img_update_site($bdd,$id_img,$nom_image);
                }
                else {

                    req_insert_img_pf($bdd,$id_pf,$nom_image);
                }
        
                $texte_page_courante =' L\'opération à été réalisé avec succès';
               
			} 
            else {
                $texte_page_courante = 'Un problème s\'est produit.';
            }
		}
        else {
    
            $texte_page_courante =' votre fichier n\'est pas valide.';
        }
    }
}

?>