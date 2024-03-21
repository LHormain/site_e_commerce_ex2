<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

if (isset($_GET['l']) && $_GET['l'] != NULL) {
    $l = intval($_GET['l']);

    if ($l == 1) {
        $cas = 1; //logo
        $titre = 'd\'un logo';
        $image = 'du logo';
    }
    else {
        $cas = 2; // photos
        $titre = 'd\'une photo';
        $image = 'de l\'image';
    }
}


if (isset($_POST['nom_img'],$_POST['nom_entreprise']) 
&& $_POST['nom_img'] != NULL
&& $_POST['nom_entreprise'] != NULL
) { 
    $nom_image = htmlspecialchars($_POST['nom_img']).$timestamp;
    $nom_entreprise = htmlspecialchars($_POST['nom_entreprise']);
    if (isset($_FILES['photo']) && $_FILES['photo'] != NULL) {
        $extensions_valides = array('jpeg','jpg','png', 'gif', 'webp'); 
        $extension_upload = substr(strrchr($_FILES['photo']['name'],'.'),1);

        if(in_array($extension_upload, $extensions_valides)) {     
        $nom_image = $nom_image.'.'.$extension_upload;
        $chemin = $dossier."/".$nom_image;       
        $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);  
        if ($cas == 2) {
            // ajoute un watermark 
            GenerateWatermarkedImage($chemin, $chemin);
        }
            if($resultat) {
                echo '<h2 class="mt-5">Transfert reussi</h2>';   
                
                // INSERT
                req_img_insert_tb($bdd,$nom_entreprise,$nom_image,$cas);
        
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

?>