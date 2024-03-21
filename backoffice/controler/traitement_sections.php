<?php
$dossier = '../public/assets/img/site';
$texte_page_courante = '';
$timestamp = time();

//---------------------------------------------------------------------
// récupération des données pour update
//---------------------------------------------------------------------
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_section = intval($_GET['id']);
    
    $section = req_section($bdd,$id_section);
    $nom_section = $section['nom_section'];
    $descriptif_section = $section['descriptif_section'];
    $nom_img = $section['nom_img'];
}
else {
    $nom_section = '';
    $descriptif_section = '';
    $nom_img = '';
}

//---------------------------------------------------------------------
// traitement de la modification du texte et de l'image de la section
//---------------------------------------------------------------------

if (isset($_POST['nom_section'], $_POST['descriptif_section'])
&& $_POST['nom_section'] != NULL
&& $_POST['descriptif_section'] != NULL
) {
    $nom_section = htmlspecialchars($_POST['nom_section']);
    $descriptif_section = htmlspecialchars($_POST['descriptif_section']);

    req_update_section($bdd,$nom_section,$descriptif_section,$id_section);

    if (isset($_POST['nom_img']) && $_POST['nom_img'] != NULL) {
        $nom_image = htmlspecialchars($_POST['nom_img']).$timestamp;
            // enregistrement de l'image
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
                        $id_section = intval($_GET['id']);

                        // supprime l'ancienne image dans le dossier
                        $donnees = req_section($bdd,$id_section);
                        $chemin = $dossier.'/'.$donnees['nom_img'];
                        if (file_exists($chemin)) {
                            unlink($chemin);
                        }

                        // UPDATE  nouvelle image
                        req_img_update_site($bdd,$donnees['id_img'],$nom_image);
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
}

//----------------------------------------------------
// tableau de gestion 
//----------------------------------------------------
$sections = req_sections($bdd);

$table = "";
foreach ($sections as $lignes) {
    $table .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row">'.$lignes['nom_section'].'</td>
        <td><a href="index.php?page=500&c=5&id='.$lignes['id_section'].'" ><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></a></td>
        <td><a href="index.php?page=500&c=5&id='.$lignes['id_section'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
    </tr>
    ';
}
?>