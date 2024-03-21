<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

// récupération des données pour un update

if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_projet = intval($_GET['id']);
    $projet = req_projet($bdd,$id_projet);

    $titre = 'Modification de la description d\'un ';
    $nom_projet = $projet['nom_projet'];
    $description_projet = $projet['description_projet'];
    $nom_image = 'update';
    $hidden = 1;
}
else {
    $titre = 'Saisie d\'un ';
    $nom_projet = '';
    $description_projet = '';
    $nom_image = '';
    $hidden = 0;
}

// traitement
if (isset($_POST['nom_projet'],
$_POST['nom_img_atelier'],
$_POST['description_projet']
)
&& $_POST['nom_projet'] != NULL
&& $_POST['nom_img_atelier'] != NULL
&& $_POST['description_projet'] != NULL
) {
    $nom_projet = htmlspecialchars($_POST['nom_projet']);
    $description_projet = htmlspecialchars($_POST['description_projet']);
    $nom_image = htmlspecialchars($_POST['nom_img_atelier']).$timestamp;

    // enregistre l'atelier
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ) {
        //update
        $id_atelier = intval($_GET['id']);

        req_projet_update($bdd,$nom_projet,$id_projet,$description_projet);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert
        $donnees = req_projet_insert($bdd,$nom_projet,$description_projet);
        $id_projet = $donnees['id_projet']; 
    }

    // on n'update pas l'image ici
    if (!(isset($_GET['id'])&& $_GET['id'] != NULL)) {
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
                        echo '<h2 class="mt-5">Transfert reussi</h2>';   
                    
                        // INSERT
                        req_img_insert_projet($bdd,$id_projet,$nom_image);
            
                        $texte_page_courante =' <h2>L\'opération à été réalisé avec succès</h2>';
                    
                } 
                else {
                    $texte_page_courante = '<h2>Un problème s\'est produit.</h2>';
                }
            }
            else {
        
                $texte_page_courante =' <h2>votre fichier n\'est pas valide.</h2>';
            }
        }
    }
}

?>