<?php
$dossier = '../public/assets/img/produits';
$texte_page_courante = '';
$timestamp = time();

// récupération des données pour un update
if (isset($_GET['id'])
&& $_GET['id'] != NULL
){
    $id_img = intval($_GET['id']);
    $texte_page_courante = 'Modifier les champs, tous les champs sont obligatoires';

    $donnees = req_select_img_produit($bdd,$id_img);
    $nom_image = substr($donnees['nom_img_produit'], 0, strrpos($donnees['nom_img_produit'], ".")); // inutile
    $id_produit = $donnees['id_produit'];
}
else {
    $texte_page_courante = 'Remplissez les champs, tous les champs sont obligatoires';
    $nom_image = '';
    $id_produit = '';
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
                    $donnees = req_select_img_produit($bdd,$id_img);
                    $chemin = '../public/assets/img/produits/'.$donnees['nom_img_produit'];
                    if (file_exists($chemin)) {
                        unlink($chemin);
                    }

                    // UPDATE  nouvelle image
                    req_img_update_produit($bdd,$id_img,$nom_image);
                }
                elseif (isset($_GET['id_produit'])
                && $_GET['id_produit'] != NULL
                )  {
                    $id_produit = intval($_GET['id_produit']);

                    req_img_insert_produit($bdd,$id_produit,$nom_image);
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