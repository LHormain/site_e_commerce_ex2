<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

// ---------------------------------------------
//    récupération des données pour un update
// ---------------------------------------------
if (isset($_GET['id'])
&& $_GET['id'] != NULL
){
    $id_atelier = intval($_GET['id']);
    $donnees = req_ateliers($bdd,$id_atelier);

    $nom_atelier = $donnees['nom_atelier'];
    $nombre_participant_max = $donnees['nbr_participant_max'];
    $prix_atelier = $donnees['tarif_atelier'];
    $duree_atelier = $donnees['duree_atelier'];
    $texte_descriptif = $donnees['descriptif_atelier'];

    $titre = 'Modification d\'un';

    $nom_image = 'update';
    $hidden = 1;
}
else {
    $titre = 'Saisie d\'un nouvel';
    $nom_atelier = '';
    $nombre_participant_max = 5;
    $prix_atelier = '';
    $duree_atelier = '';
    $nom_image = '';
    $texte_descriptif = '';
    $hidden = 0;
}
// ----------------------------------------------
//            enregistrement de l'atelier
// ----------------------------------------------
if (isset($_POST['nom_atelier'],
$_POST['nombre_participant_max'],
$_POST['prix_atelier'],
$_POST['duree_atelier'],
$_POST['nom_img_atelier'],
$_POST['texte_descriptif']
)
&& $_POST['nom_atelier'] != NULL
&& $_POST['nombre_participant_max'] != NULL
&& $_POST['prix_atelier'] != NULL
&& $_POST['duree_atelier'] != NULL
&& $_POST['nom_img_atelier'] != NULL
&& $_POST['texte_descriptif'] != NULL
) {
    $nom_atelier = htmlspecialchars($_POST['nom_atelier']);
    $nombre_participant_max = htmlspecialchars($_POST['nombre_participant_max']);
    $prix_atelier = htmlspecialchars($_POST['prix_atelier']);
    $duree_atelier = htmlspecialchars($_POST['duree_atelier']);
    $texte_descriptif = htmlspecialchars($_POST['texte_descriptif']);
    $nom_image = htmlspecialchars($_POST['nom_img_atelier']).$timestamp;

    // enregistre l'atelier
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ) {
        //update
        $id_atelier = intval($_GET['id']);

        req_atelier_update($bdd,$nom_atelier,$nombre_participant_max,$prix_atelier,$duree_atelier,$id_atelier,$texte_descriptif);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert
        $donnees = req_atelier_insert($bdd,$nom_atelier,$nombre_participant_max,$prix_atelier,$duree_atelier,$texte_descriptif);
        $id_atelier = $donnees['id_atelier']; 
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
                        req_img_insert_atelier($bdd,$id_atelier,$nom_image);
            
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