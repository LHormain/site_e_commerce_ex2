<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

// récupération des section 
$sections = req_sections($bdd);

// récupération des données pour une update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_categorie = intval($_GET['id']);

    $titre = "Modifier une catégorie";
    $categorie = req_categorie($bdd, $id_categorie);
    $nom_categorie = $categorie['nom_categorie'];
    $description_categorie = $categorie['descriptif_categorie'];

    $select = select_sections($sections,$categorie['id_section']);

    $image_cat = req_img_site($bdd,$categorie['id_img']);
    $nom_img = $image_cat['nom_img'];
}
else {
    $titre = "Saisir une nouvelle catégorie";
    $nom_categorie = "";
    $description_categorie = "";

    $select = select_sections($sections,0);

    $nom_img = "";
}

//traitement
if (isset($_POST['nom_categorie'],
$_POST['description_categorie'],
$_POST['section'],
$_POST['nom_img']
)
&& $_POST['nom_categorie'] != NULL
&& $_POST['description_categorie'] != NULL
&& $_POST['section'] != NULL
&& $_POST['nom_img'] != NULL
) {
    $nom_categorie = htmlspecialchars($_POST['nom_categorie']);
    $description_categorie = htmlspecialchars($_POST['description_categorie']);
    $id_section = htmlspecialchars($_POST['section']);
    $nom_image = htmlspecialchars($_POST['nom_img']).$timestamp;

    // enregistrement de l'image
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
                
                if (isset($_GET['id'])&& $_GET['id'] != NULL) {
                    $id_categorie = intval($_GET['id']);

                    // supprime l'ancienne image dans le dossier
                    $donnees = req_categorie($bdd,$id_categorie);
                    $chemin = $dossier.'/'.$donnees['nom_img'];
                    if (file_exists($chemin)) {
                        unlink($chemin);
                    }

                    // UPDATE  nouvelle image
                    req_img_update_site($bdd,$donnees['id_img'],$nom_image);
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
        $id_categorie = intval($_GET['id']);

        req_categorie_update($bdd,$nom_categorie,$description_categorie,$id_section,$id_categorie);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert
        req_categorie_insert($bdd,$nom_categorie,$description_categorie,$id_section,$image['id_img']);

    }
    $select = select_sections($sections,$id_section);

}
?>