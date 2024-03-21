<?php

//-------------------
// utilitaires
//-------------------
// nettoie le nom d'une image pour le formulaire pour une update
function trim_image_name($nom_image) {
    $liste = array("0", "1", "2", "3","4","5","6","7","8","9");
    $nouveau = str_replace($liste, "", substr($nom_image,0,strpos($nom_image,".")));

    return $nouveau;
}
// génère un watermark sur une image (utilisation de la bibliothèque php GD)
// source : https://azuliadesigns.com/php-tutorials/overlay-png-jpeg-watermark-php-gd/
function GenerateWatermarkedImage($srcFilename, $destFilename)
{
    list($width, $height, $type, $attr) = getimagesize($srcFilename);
    $ext =  strtolower(pathinfo($srcFilename, PATHINFO_EXTENSION));

    // load the image based on the extension
    if ($ext == 'png') {
        $image = imagecreatefrompng($srcFilename);
    } elseif ($ext == 'jpg' || $ext == 'jpeg') {
        $image = imagecreatefromjpeg($srcFilename);
    } elseif ($ext == 'gif') {
        $image = imagecreatefromgif($srcFilename);
    }
    elseif ($ext == 'webp') {
        $image = imagecreatefromwebp($srcFilename);
    }

    // set transparencey and alpha
    imageinterlace($image, true);
    imagealphablending($image, true);

    // load the watermark
    $watermarkfile = '../public/assets/img/logo/qualisarmalogo5.png';
    list($watermarkWidth, $watermarkHeight, $watermarkType, $watermarkAttr) = getimagesize($watermarkfile);
    $watermark = imagecreatefrompng($watermarkfile);

    // add the watermark in the bottom right corner
    imagecopy($image, $watermark, $width-$watermarkWidth, $height-$watermarkHeight, 0, 0, $watermarkWidth, $watermarkHeight);

    // save the watermarked image
    if ($ext == 'png') {
        imagepng($image, $destFilename, 9);
    } elseif ($ext == 'jpg' || $ext == 'jpeg') {
        imagejpeg($image, $destFilename, 80);
    } elseif ($ext == 'gif') {
        imagegif($image, $destFilename);
    } 
    elseif ($ext == 'webp') {
        imagewebp($image, $destFilename);
    } 

    // free up resources
    if (is_resource($image)) {
        imagedestroy($image);
    }
    if (is_resource($watermark)) {
        imagedestroy($watermark);
    }
}
//  remplace image par logo si image n'existe pas
function image_par_default($chemin, $nom_img) {
    if ($nom_img == '' ) {
        $chemin_img = '../public/assets/img/logo/qualisarmalogo2.png';
    }
    else {
        $chemin_img = $chemin.$nom_img;
    }
    
    return $chemin_img;
}
// crée une légende pour les tableaux
function table_legend() {
    $sortie = '
    <div class="d-inline gap-2 ">
        <button
            type="button"
            class="btn btn-link btn_aff""
        >
            <img src="public/assets/img/verifier.png" class="icones_table afficher" alt="">
        </button>
        oui
    </div>
    <div class="d-inline gap-2 ">
        <button
            type="button"
            class="btn btn-link btn_aff""
        >
            <img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt="">
        </button>
        non
    </div>
    ';
    echo $sortie;
}
//---------------------------------------------------------------
//                         ateliers
//---------------------------------------------------------------

//-------------------
// ateliers clients
//-------------------
// supprime un atelier avec toutes les données attachées inscriptions inclues
function req_sup_ateliers($bdd, $id_atelier) {
    // supprime les inscriptions
    $requete = "SELECT * FROM inscriptions 
                INNER JOIN calendrier_ateliers ON inscriptions.id_atelier = calendrier_ateliers.id_atelier
                WHERE calendrier_ateliers.id_atelier = :id_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT); 
    $req -> execute();
    $dates_ateliers = $req -> fetchAll();
    foreach ($dates_ateliers as $date) {
        $requete = "DELETE FROM inscriptions 
                    WHERE id_date = :id_date";
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_date', $date['id_date'], PDO::PARAM_INT); 
        $req -> execute();
    }
    // supprime les dates
    $requete = "DELETE FROM calendrier_ateliers WHERE id_atelier = :id_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT); 
    $req -> execute();
    // supprime les images
    $requete = "SELECT * FROM illustrations_ateliers
                INNER JOIN images_sites ON illustrations_ateliers.id_img = images_sites.id_img
                WHERE illustrations_ateliers.id_atelier = :id_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT); 
    $req -> execute();
    $images = $req ->fetchAll();

    $requete = "DELETE FROM illustrations_ateliers WHERE id_atelier = :id_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT); 
    $req -> execute();

    foreach ($images as $donnees) {
        $chemin = '../public/assets/img/site/'.$donnees['nom_img'];
        if (file_exists($chemin)) {
            unlink($chemin);
        }
        req_sup_image_site($bdd,$donnees['id_img']);
    }
 
    // supprime l'atelier
    $requete = "DELETE FROM ateliers WHERE id_atelier = :id_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT); 
    $req -> execute();
}
// récupère tous les ateliers
function req_tous_ateliers($bdd) {
    $requete = "SELECT * FROM ateliers";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère un atelier précis
function req_ateliers($bdd,$id_atelier) {
    $requete = "SELECT * FROM ateliers 
                WHERE id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère une image pour un atelier pour l'affichage dans le tableau
function req_ateliers_img($bdd,$lignes) {
    $requete = "SELECT * FROM images_sites
                INNER JOIN illustrations_ateliers ON  images_sites.id_img = illustrations_ateliers.id_img
                WHERE illustrations_ateliers.id_atelier = :id_atelier 
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $lignes['id_atelier'], PDO::PARAM_INT);
    $req -> execute();

    $image = $req -> fetch();
    return $image;
}
// tableau d'affichage de la gestion des ateliers 
function table_ateliers_gestion($bdd,$donnees) {
    $table = '';
    foreach ($donnees as $lignes) {
        $image = req_ateliers_img($bdd,$lignes);

        if (isset($image['nom_img'])) {
            $nom_image = '<img src="../public/assets/img/site/'.$image['nom_img'].'" class="mignature_table" data-bs-toggle="tooltip" data-bs-placement="top" title="Gestion des images">';
        }
        else {
            $nom_image = 'Gestion des images';
        }

        if ($lignes['afficher_atelier'] == 1) {
            $affichage = '<td><button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_atelier'].'" value="'.$lignes['afficher_atelier'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button></td>';
        }
        else {
            $affichage = '<td><button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_atelier'].'" value="'.$lignes['afficher_atelier'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button></td>';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['nom_atelier'].'</td>
            <td>'.$lignes['nbr_participant_max'].'</td>
            <td><a href="index.php?page=310&c=2&id='.$lignes['id_atelier'].'">Voir</a></td>
            <td>'.$lignes['tarif_atelier'].'</td>
            <td><a href="index.php?page=300&c=5&id='.$lignes['id_atelier'].'">'.$nom_image.'</a></td>
            <td><a href="index.php?page=300&c=3&id='.$lignes['id_atelier'].'">Gérer</a></td>
            '.$affichage.'
            <td><a href="index.php?page=300&c=2&id='.$lignes['id_atelier'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=300&c=1&sup='.$lignes['id_atelier'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ? Attention cette suppression effacera aussi les inscriptions.\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// mise à jour d'un atelier
function req_atelier_update($bdd,$nom_atelier,$nombre_participant_max,$prix_atelier,$duree_atelier,$id_atelier,$texte_descriptif) {
    $requete = "UPDATE `ateliers` SET `nom_atelier`=:nom_atelier,
                                      `nbr_participant_max`=:nombre_participant_max,
                                      `tarif_atelier`=:prix_atelier,
                                      `duree_atelier`=:duree_atelier,
                                      descriptif_atelier=:descriptif_atelier
                WHERE id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_atelier', $nom_atelier, PDO::PARAM_STR);
    $req -> bindValue(':descriptif_atelier', $texte_descriptif, PDO::PARAM_STR);
    $req -> bindValue(':nombre_participant_max', $nombre_participant_max, PDO::PARAM_INT);
    $req -> bindValue(':prix_atelier', $prix_atelier, PDO::PARAM_STR);
    $req -> bindValue(':duree_atelier', $duree_atelier, PDO::PARAM_INT);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();
}
// ajout d'un atelier
function req_atelier_insert($bdd,$nom_atelier,$nombre_participant_max,$prix_atelier,$duree_atelier,$texte_descriptif) {
    $requete = "INSERT INTO `ateliers`(`id_atelier`, 
                                    `nom_atelier`, 
                                    `nbr_participant_max`, 
                                    `tarif_atelier`, 
                                    `duree_atelier`, 
                                    `afficher_atelier`, 
                                    `descriptif_atelier`) 
                VALUES (0,
                        :nom_atelier,
                        :nombre_participant_max,
                        :prix_atelier,
                        :duree_atelier,
                        0,
                        :descriptif_atelier)
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_atelier', $nom_atelier, PDO::PARAM_STR);
    $req -> bindValue(':descriptif_atelier', $texte_descriptif, PDO::PARAM_STR);
    $req -> bindValue(':nombre_participant_max', $nombre_participant_max, PDO::PARAM_INT);
    $req -> bindValue(':prix_atelier', $prix_atelier, PDO::PARAM_STR);
    $req -> bindValue(':duree_atelier', $duree_atelier, PDO::PARAM_INT);
    $req -> execute();

    $requete = "SELECT id_atelier FROM ateliers 
                ORDER BY id_atelier DESC 
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
//-------------------
// images
//-------------------
// récupère une image de la table image site avec son id
function req_img_site($bdd,$id_img_atelier) {
    $requete = "SELECT * FROM images_sites
                WHERE id_img = :id_img_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_img_atelier', $id_img_atelier, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// suppression d'une image appartenant à un atelier
function req_sup_image_atelier($bdd,$id_img_atelier) {
    // récupère l'id de l'atelier
    $requete = "SELECT * FROM illustrations_ateliers
                WHERE id_img = :id_img_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img_atelier', $id_img_atelier, PDO::PARAM_INT); 
    $req -> execute();
    $image = $req -> fetch();

    // supprime l'image
    $requete = "DELETE FROM illustrations_ateliers WHERE id_img = :id_img_atelier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img_atelier', $id_img_atelier, PDO::PARAM_INT); 
    $req -> execute();

    req_sup_image_site($bdd,$id_img_atelier);

    // réorganise les positions dans la base illustration
    $images = req_images_atelier($bdd, $image['id_atelier']);
    $i = 1;
    foreach ($images as $ligne) {
        $requete = "UPDATE `illustrations_ateliers` 
                    SET `position_image`= $i 
                    WHERE id_img = :id_img
        ";
            $req = $bdd->prepare($requete);
            $req->bindValue(':id_img', $ligne['id_img'], PDO::PARAM_INT); 
            $req -> execute();
        $i++;
    }
}
// supprime une image de la table image site
function req_sup_image_site($bdd,$id_img) {
    $requete = "DELETE FROM images_sites WHERE id_img = :id_img";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $id_img, PDO::PARAM_INT); 
    $req -> execute();
}
// récupère toutes les images pour un atelier
function req_images_atelier($bdd,$id_atelier) {
    $requete = "SELECT * FROM images_sites
                INNER JOIN  illustrations_ateliers ON images_sites.id_img = illustrations_ateliers.id_img
                WHERE illustrations_ateliers.id_atelier = :id_atelier
                ORDER BY illustrations_ateliers.position_image";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $images = $req -> fetchAll();
    return $images;
}
// table pour la gestion des images d'un atelier
function table_ateliers_gestion_img($images) {
    $table = '';
    foreach ($images as $lignes) {
        $table .= '
        <tr class="table-anticbeige">
            <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></td>
            <td id="'.$lignes['id_img'].'"><input type="text" id="position'.$lignes['id_img'].'" value="'.$lignes['position_image'].'" class="input_dispo"></td>
            <td><a href="index.php?page=300&c=6&id='.$lignes['id_atelier'].'&img='.$lignes['id_img'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=300&c=5&id='.$lignes['id_atelier'].'&sup='.$lignes['id_img'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// mise à jour d'une image de la table images sites
function req_img_update_site($bdd,$id_img,$nom_image) {
    $requete = "UPDATE `images_sites` SET nom_img = :nom_image 
                WHERE id_img = :id_img"; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $id_img, PDO::PARAM_INT); 
    $req->bindValue(':nom_image', $nom_image, PDO::PARAM_STR);  
    $req -> execute();     
    
}
// ajout d'une image dans la table images sites 
function req_img_site_insert($bdd,$nom_image) {
    // enregistre l'image et donne son id
    $requete = "INSERT INTO `images_sites`(`id_img`, 
                                            `nom_img`) 
                VALUES (0,
                        :nom_image)
                "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':nom_image', $nom_image, PDO::PARAM_STR);  
    $req -> execute();

    $requete = "SELECT id_img FROM images_sites
                ORDER BY id_img DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// ajout d'une image à un atelier
function req_img_insert_atelier($bdd,$id_atelier,$nom_image) {
    $donnees = req_img_site_insert($bdd,$nom_image);

    // recherche position de la dernière image 
    $requete = "SELECT * FROM illustrations_ateliers 
                WHERE id_atelier = :id_atelier
                ORDER BY position_image DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();      
    
    $last_position = $req -> fetch();
    if (isset($last_position['position_image'])) {
        $position = $last_position['position_image'] + 1;
    }
    else {
        $position = 1;
    }

    $requete = "INSERT INTO `illustrations_ateliers`(`id_img`, 
                                                    `id_atelier`,
                                                    `position_image`) 
                VALUES (:id_img,
                        :id_atelier,
                        $position)
                "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $donnees['id_img'], PDO::PARAM_INT);  
    $req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    return $donnees['id_img'];
}
//-------------------
// horaires/dates
//-------------------
// suppression d'un créneaux horaire/dates pour un atelier
function req_sup_horaire($bdd,$id_horaire) {
    $requete = "DELETE FROM calendrier_ateliers WHERE id_date = :id_horaire";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_horaire', $id_horaire, PDO::PARAM_INT); 
    $req -> execute();
}
// récupération des créneaux horaires/dates d'un ateliers précis
function req_horaires_atelier($bdd,$id_atelier) {
    $requete = "SELECT * FROM calendrier_ateliers 
                WHERE id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $horaire = $req -> fetchAll();
    return $horaire;
}
// table de gestion des horaires pour un atelier
function table_ateliers_gestion_horaire($bdd,$horaire) {
    $table = '';
    foreach ($horaire as $lignes) {
        $test = req_si_reservation($bdd,$lignes['id_date']);
        if ($test == 1) {
            // si il existe des inscriptions ne peut pas supprimer
            $liens = '';
            $message = 'alert(\'Cette horaire ne peut être supprimée. Des clients se sont inscrit à cette date.\')';
        }
        else {
            $liens = 'href="index.php?page=300&c=3&id='.$lignes['id_atelier'].'&sup='.$lignes['id_date'].'"';
            $message = 'return(confirm(\'Voulez vous supprimer cette entrée ?\'))';
        }
        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.date('d-m-Y à H:i',$lignes['date_atelier']).'</td>
            <td><a href="index.php?page=300&c=4&id='.$lignes['id_atelier'].'&h='.$lignes['id_date'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a  '.$liens.' onclick="'.$message.'" ><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// récupération d'un créneaux horaire/date précis
function req_horaire($bdd,$id_horaire) {
    $requete = "SELECT * FROM calendrier_ateliers 
                WHERE id_date = :id_horaire";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_horaire', $id_horaire, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// mise à jour d'un horaire/date
function req_update_horaire($bdd,$id_horaire,$date_atelier) {
    $requete = "UPDATE `calendrier_ateliers` SET `date_atelier`=:date_atelier 
                WHERE id_date = :id_horaire";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_horaire', $id_horaire, PDO::PARAM_INT);
    $req -> bindValue(':date_atelier', $date_atelier, PDO::PARAM_INT);
    $req -> execute();
}
// ajout d'un horaire/date
function req_insert_horaire($bdd,$id_atelier,$date_atelier) {
    $requete = "INSERT INTO `calendrier_ateliers`(`id_date`, 
                                                `date_atelier`, 
                                                `id_atelier`) 
                VALUES (0,
                        :date_atelier,
                        :id_atelier) 
                ";
        $req = $bdd -> prepare($requete);
        $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
        $req -> bindValue(':date_atelier', $date_atelier, PDO::PARAM_INT);
        $req -> execute();
}
//-------------------
// inscriptions
//-------------------
// détermine si il existe des réservations pour un horaire précis
function req_si_reservation($bdd,$id_horaire) {
    $requete = "SELECT * FROM inscriptions 
                WHERE id_date = :id_horaire";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_horaire', $id_horaire, PDO::PARAM_INT); 
    $req -> execute();

    $donnees = $req -> rowCount();
    if ($donnees != 0) {
        $test = 1;
    }
    else {
        $test = 0;
    }
    return $test;
}
// récupère toutes les inscriptions pour un atelier précis
function req_inscriptions($bdd,$id_atelier,$ordre_req) {
    $requete = "SELECT * FROM inscriptions 
                INNER JOIN utilisateurs ON inscriptions.id_user = utilisateurs.id_user
                INNER JOIN calendrier_ateliers ON inscriptions.id_date = calendrier_ateliers.id_date
                INNER JOIN etats_commandes ON etats_commandes.id_etat_commande = inscriptions.id_etat_commande
                INNER JOIN numeros_factures ON numeros_factures.id_facture = inscriptions.id_facture
                WHERE calendrier_ateliers.id_atelier = :id_atelier
                ".$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $inscriptions = $req -> fetchAll();
    return $inscriptions;
}
// table de gestion des inscriptions à un atelier précis
function table_ateliers_gestion_inscriptions($inscriptions) {
    $table = '';
    foreach ($inscriptions as $lignes) {
        $facture = '
        <a href="public/assets/devis/'.$lignes['fichier_facture'].'" download="'.$lignes['fichier_facture'].'">Télécharger</a>
        ';
        $annulation = 'inscription annulée';
        if ($lignes['annuler'] == 0) {
            $annulation = '<a href="index.php?page=310&c=2&suph='.$lignes['id_date'].'&supc='.$lignes['id_user'].'&supa='.$lignes['id_atelier'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a>';
        }
        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['prenom_utilisateur'].' '.$lignes['nom_utilisateur'].'</td>
            <td>'.date('d-m-Y à H:i',$lignes['date_atelier']).'</td>
            <td>'.$lignes['nbr_inscrit'].'</td>
            <td>'.$lignes['nom_etat_commande'].'</td>
            <td>'.$facture.'</td>
            <td><a href="mailto:'.$lignes['mail_utilisateur'].'"><img src="public/assets/img/feather-pen.png" alt="" class="icones_table modifier"></a></td>
            <td>'.$annulation.'</td>
        </tr>
        ';
    }
    return $table;
}
// annulation d'une inscription 
function req_annule_atelier($bdd,$id_user,$id_date,$id_atelier) {
    $requete = "UPDATE inscriptions
                SET id_etat_commande = 4,
                    annuler = 1
                WHERE id_user = :id_user AND id_date = :id_date";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> execute();

    $requete = "SELECT * FROM inscriptions
                WHERE id_user = :id_user AND id_date = :id_date";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> execute();
    $nbr_inscrit = $req -> fetch();

    $requete = "SELECT * FROM calendrier_ateliers
                WHERE id_atelier = :id_atelier AND id_date = :id_date";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> execute();
    $nbr_inscrit_tot = $req -> fetch();

    $nbr = $nbr_inscrit_tot['nbr_participant'] - $nbr_inscrit['nbr_inscrit'];

    $requete = "UPDATE calendrier_ateliers
                SET nbr_participant = :nbr
                WHERE id_atelier = :id_atelier AND id_date = :id_date ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> bindValue(':nbr', $nbr, PDO::PARAM_INT);
    $req -> execute();
}
// récupération d'un atelier avec toutes les dates correspondantes
function req_stat_inscriptions($bdd,$id_atelier) {
    $requete = "SELECT * FROM calendrier_ateliers 
                INNER JOIN ateliers ON calendrier_ateliers.id_atelier = ateliers.id_atelier
                WHERE calendrier_ateliers.id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $horaires = $req -> fetchAll();
    return $horaires;
}
//-------------------
// team building
//-------------------
// ajout d'une image à la partie team building du site
function req_img_insert_tb($bdd,$nom_entreprise,$nom_image, $cas) {
    $donnees = req_img_site_insert($bdd, $nom_image);

    if ($cas == 1) {
        // cas logo d'entreprise
        $logo = 1;
        $illustration = 0;
    }
    else {
        // cas photos
        $logo = 0;
        $illustration = 1;
    }

    $requete = "INSERT INTO team_building (`id_tb`, 
                                            `logo`, 
                                            `illustration`, 
                                            `nom_entreprise`, 
                                            `id_img`)
                VALUES (0, 
                        $logo, 
                        $illustration, 
                        :nom_entreprise, 
                        :id_img)
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_entreprise', $nom_entreprise, PDO::PARAM_STR);
    $req -> bindValue(':id_img', $donnees['id_img'], PDO::PARAM_INT);
    $req -> execute();
}
// récupération des images pour la partie team building
function req_tb($bdd,$cas) {
    if ($cas == 1) {
        $where = ' WHERE team_building.logo = 1';
    }
    else {
        $where = ' WHERE team_building.illustration = 1';
    }

    $requete = 'SELECT * FROM team_building
                INNER JOIN images_sites ON team_building.id_img = images_sites.id_img
                '.$where;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération du texte pour la partie team building
function req_tb_txt($bdd) {
    $requete = "SELECT * FROM `team_building_textes` 
                ORDER BY position_tb_txt";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération d'un paragraphe précis pour la partie team building
function req_tb_txt2($bdd,$id_tb_txt) {
    $requete = "SELECT * FROM `team_building_textes` 
                WHERE id_tb_txt = :id_tb_txt";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// table de gestion images pour la partie team building
function table_tb($datas,$cas) {
    $table = "";

    foreach ($datas as $lignes) {
        $table .= '
        <tr class="">
            <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></td>';
        if ($lignes['afficher_tb'] == 1) {
            $table .= '<td><button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_tb'].'" value="'.$lignes['afficher_tb'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button></td>';
        }
        else {
            $table .= '<td><button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_tb'].'" value="'.$lignes['afficher_tb'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button></td>';
        }
        $table .= '
            <td><a href="index.php?page=320&d=2&sup='.$lignes['id_img'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// table de gestion du texte pour la partie team building
function table_tb_txt($datas) {
    $table = "";

    foreach ($datas as $lignes) {
        $table .= '
        <tr class="">
            <td scope="row">'.$lignes['titre_tb_txt'].'</td>
            <td  id="'.$lignes['id_tb_txt'].'"><input type="text" id="position'.$lignes['id_tb_txt'].'" value="'.$lignes['position_tb_txt'].'" class="input_dispo"></td>
            <td><a href="index.php?page=320&c=3&id='.$lignes['id_tb_txt'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        ';
        if ($lignes['afficher_tb_txt'] == 1) {
            $table .= '<td><button type="button" class="btn btn-link btn_aff_txt" id="txt'.$lignes['id_tb_txt'].'" value="'.$lignes['afficher_tb_txt'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button></td>';
        }
        else {
            $table .= '<td><button type="button" class="btn btn-link btn_aff_txt" id="txt'.$lignes['id_tb_txt'].'" value="'.$lignes['afficher_tb_txt'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button></td>';
        }
        $table .= '
            <td><a href="index.php?page=320&c=1&supt='.$lignes['id_tb_txt'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// création de l'aperçus du texte total de la partie team building
function appecu_tb_txt($datas) {
    $sortie = "";

    foreach ($datas as $lignes) {
        $sortie .= '
        <h5 class="mt-3">'.$lignes['titre_tb_txt'].'</h5>
        <p class="text-start mx-5">'.nl2br($lignes['descriptif_tb_txt']).'</p>
        ';
    }
    return $sortie;
}
// supprimer une image de la partie team building
function req_sup_image_tb($bdd,$id_img) {
    $requete = "DELETE FROM team_building 
                WHERE id_img = :id_img";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_img', $id_img, PDO::PARAM_INT);
    $req -> execute();

    req_sup_image_site($bdd,$id_img);
}
// suppression d'un paragraphe de la partie team building
function req_sup_tb_txt($bdd,$id_tb_txt) {

    // suppression
    $requete = "DELETE FROM team_building_textes 
                WHERE id_tb_txt = :id_tb_txt";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
    $req -> execute();

    //réorganise les paragraphes
    $paragraphes = req_tb_txt($bdd);
    $i = 1;
    foreach ($paragraphes as $ligne) {
        $requete = "UPDATE `team_building_textes` 
                    SET `position_tb_txt`= $i 
                    WHERE id_tb_txt = :id_tb_txt
        ";
            $req = $bdd->prepare($requete);
            $req->bindValue(':id_tb_txt', $ligne['id_tb_txt'], PDO::PARAM_INT); 
            $req -> execute();
        $i++;
    }
}
// mise à jour du texte de la partie team building
function req_update_tb_txt($bdd,$id_tb_txt,$titre_tb_txt,$descriptif_tb_txt) {
    $requete = "UPDATE `team_building_textes` 
                SET `titre_tb_txt`= :titre_tb_txt,
                    `descriptif_tb_txt`= :descriptif_tb_txt 
                WHERE `id_tb_txt`=:id_tb_txt
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':titre_tb_txt', $titre_tb_txt, PDO::PARAM_STR);
    $req -> bindValue(':descriptif_tb_txt', $descriptif_tb_txt, PDO::PARAM_STR);
    $req -> bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
    $req -> execute();

}
// ajout d'un paragraphe au texte team building
function req_insert_tb_txt($bdd,$titre_tb_txt,$descriptif_tb_txt) {
    // recherche position de la dernière image 
    $requete = "SELECT * FROM team_building_textes 
                ORDER BY position_tb_txt DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req -> execute();      

    $last_position = $req -> fetch();
    if (isset($last_position['position_tb_txt'])) {
    $position = $last_position['position_tb_txt'] + 1;
    }
    else {
    $position = 1;
    }

    // insert
    $requete = "INSERT INTO `team_building_textes`(`id_tb_txt`, 
                                                    `titre_tb_txt`, 
                                                    `descriptif_tb_txt`, 
                                                    `afficher_tb_txt`, 
                                                    `position_tb_txt`) 
                VALUES (0, 
                        :titre_tb_txt, 
                        :descriptif_tb_txt, 
                        0, 
                        $position)
                ";
        $req = $bdd -> prepare($requete);
        $req -> bindValue(':titre_tb_txt', $titre_tb_txt, PDO::PARAM_STR);
        $req -> bindValue(':descriptif_tb_txt', $descriptif_tb_txt, PDO::PARAM_STR);
        $req -> execute();
}

//---------------------------------------------------------------
//                        Sur mesure
//---------------------------------------------------------------

//-------------------
// Gestions projets
//-------------------
// récupération des projets pour la galerie sur mesure
function req_galerie_projet($bdd) {
    $requete = "SELECT * FROM `projets_sur_mesure`";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération d'un projet précis
function req_projet($bdd,$id_projet) {
    $requete = "SELECT * FROM `projets_sur_mesure`
                WHERE id_projet = :id_projet";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// table de gestion des projets
function table_galerie_projet($bdd,$datas) {
    $table = "";
    
    foreach ($datas as $lignes) {
        $image = req_galerie_img_projet($bdd,$lignes['id_projet']);
        if (isset($image[0]['nom_img'])) {
            $nom_image = '<img src="../public/assets/img/site/'.$image[0]['nom_img'].'" class="mignature_table" data-bs-toggle="tooltip" data-bs-placement="top" title="Gestion des images">';
        }
        else {
            $nom_image = 'Gestion des images';
        }

        if ($lignes['afficher_projet'] == 1) {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_projet'].'" value="'.$lignes['afficher_projet'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button>';
        }
        else {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_projet'].'" value="'.$lignes['afficher_projet'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button>';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['nom_projet'].'</td>
            <td><a href="index.php?page=400&c=3&id='.$lignes['id_projet'].'">'.$nom_image.'</a></td>
            <td>'.$affichage.'</td>
            <td><a href="index.php?page=400&c=2&id='.$lignes['id_projet'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=400&c=1&sup='.$lignes['id_projet'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ? Attention cette suppression effacera aussi les inscriptions.\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// supprimer un projet
function req_sup_projet($bdd, $id_projet) {
    // supprime les images
    $images = req_galerie_img_projet($bdd,$id_projet);

    $requete = "DELETE FROM galerie 
                WHERE id_projet = :id_projet";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();

    foreach ($images as $image) {
        $chemin = '../public/assets/img/site/'.$image['nom_img'];
        if (file_exists($chemin)) {
            unlink($chemin);
        }
        req_sup_image_site($bdd,$image['id_img']);
    }
    // supprime la description du projet
    $requete = "DELETE FROM projets_sur_mesure
                WHERE id_projet = :id_projet";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();
}
// mettre à jour un projet
function req_projet_update($bdd,$nom_projet,$id_projet,$description_projet) {
    $requete = "UPDATE `projets_sur_mesure` 
                SET `nom_projet`= :nom_projet,
                    `description_projet`= :description_projet
                WHERE id_projet = :id_projet
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_projet', $nom_projet, PDO::PARAM_STR);
    $req -> bindValue(':description_projet', $description_projet, PDO::PARAM_STR);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();
}
// ajouter un projet
function req_projet_insert($bdd,$nom_projet,$description_projet) {
    $requete = "INSERT INTO `projets_sur_mesure`(`id_projet`, 
                                                `nom_projet`, 
                                                `description_projet`, 
                                                `afficher_projet`) 
                VALUES (0, 
                        :nom_projet, 
                        :description_projet, 
                        0)
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_projet', $nom_projet, PDO::PARAM_STR);
    $req -> bindValue(':description_projet', $description_projet, PDO::PARAM_STR);
    $req -> execute();

    $requete = "SELECT * FROM projets_sur_mesure
                ORDER BY id_projet DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $last = $req -> fetch();
    return $last;
}
//-------------------
// Gestions images 
// projets
//-------------------
// récupère les images d'un projet
function req_galerie_img_projet($bdd,$id_projet) {
    $requete = "SELECT * FROM images_sites
                INNER JOIN galerie ON images_sites.id_img = galerie.id_img
                WHERE galerie.id_projet = :id_projet
                ORDER BY galerie.position_image";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// ajoute une image à un projet
function req_img_insert_projet($bdd,$id_projet,$nom_image) {
    $donnees = req_img_site_insert($bdd,$nom_image);

    // recherche position de la dernière image 
    $requete = "SELECT * FROM galerie 
                WHERE id_projet = :id_projet
                ORDER BY position_image DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();      
    
    $last_position = $req -> fetch();
    if (isset($last_position['position_image'])) {
        $position = $last_position['position_image'] + 1;
    }
    else {
        $position = 1;
    }

    $requete = "INSERT INTO `galerie`(`id_img`, 
                                    `id_projet`,
                                    `position_image`) 
                VALUES (:id_img,
                        :id_projet,
                        $position)
                "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $donnees['id_img'], PDO::PARAM_INT);  
    $req->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();

    return $donnees['id_img'];
}
// table de gestion des images d'un projet
function table_galerie_img_projet($bdd,$datas) {
    $table = '';
    foreach ($datas as $lignes) {
        $table .= '
        <tr class="table-anticbeige">
            <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></td>
            <td id="'.$lignes['id_img'].'"><input type="text" id="position'.$lignes['id_img'].'" value="'.$lignes['position_image'].'" class="input_dispo"></td>
            <td><a href="index.php?page=400&c=4&id='.$lignes['id_projet'].'&img='.$lignes['id_img'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=400&c=3&id='.$lignes['id_projet'].'&sup='.$lignes['id_img'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
        </tr>
        ';
    }
    return $table;
}
// supprime une image d'un projet
function req_sup_image_projet($bdd,$id_img) {
    // récupère l'id du projet
    $requete = "SELECT * FROM galerie 
                WHERE id_img = :id_img";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $id_img, PDO::PARAM_INT); 
    $req -> execute();
    $image = $req -> fetch();

    // supprime l'image
    $requete = "DELETE FROM galerie WHERE id_img = :id_img";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $id_img, PDO::PARAM_INT); 
    $req -> execute();

    req_sup_image_site($bdd,$id_img);

    // réorganise les positions dans la base galerie
    $images = req_galerie_img_projet($bdd, $image['id_projet']);
    $i = 1;
    foreach ($images as $ligne) {
        $requete = "UPDATE `galerie` 
                    SET `position_image`= $i 
                    WHERE id_img = :id_img
        ";
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_img', $ligne['id_img'], PDO::PARAM_INT); 
        $req -> execute();
        $i++;
    }
}
//-------------------
// Gestions devis 
// demande de
// nouveau projet
//-------------------
// récupère toutes les demandes de devis
function req_devis_sur_mesure($bdd,$ordre_req) {
    $requete = "SELECT * FROM contacts
                WHERE id_sujet = 1 ".$ordre_req;
    $req = $bdd->prepare($requete);
    $req -> execute();
    $devis = $req -> fetchAll();

    return $devis;
}
// récupère toutes les demandes de devis pour un client précis
function req_devis_sur_mesure_client($bdd,$ordre_req,$mail) {
    $requete = "SELECT * FROM contacts
                WHERE id_sujet = 1 AND mail_contact = :mail
                ".$ordre_req;
    $req = $bdd->prepare($requete);
    $req -> bindValue(':mail',$mail,PDO::PARAM_STR);
    $req -> execute();
    $devis = $req -> fetchAll();

    return $devis;
}
// récupère l'état d'un devis sm
function req_etat_d_sm($bdd,$id_contact) {
    $requete = "SELECT * FROM devis_sur_mesure
                INNER JOIN etat_devis ON devis_sur_mesure.id_etat = etat_devis.id_etat
                WHERE devis_sur_mesure.id_contact = :id_contact";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact',$id_contact,PDO::PARAM_INT);
    $req -> execute();
    $devis = $req -> fetch();

    return $devis;
}
// table de gestion des demandes de devis
function table_devis_sm($bdd,$devis) {
    $table = "";
    
    foreach ($devis as $lignes) {
        if ($lignes['lu_contact'] == 0) {
            $badge = '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-camel">
            Nouveau
            <span class="visually-hidden">unread messages</span>
          </span>';
        }
        else {
            $badge ='';
        }

        $etat = req_etat_d_sm($bdd,$lignes['id_contact']);

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row" class="position-relative">'.date('d/m/Y à H:i',$lignes['date_contact']).$badge.'</td>
            <td>'.$lignes['nom_contact'].'</td>
            <td>'.$etat['nom_etat'].'</td>
            <td>'.$lignes['tel_contact'].'</td>
            <td><a href="index.php?page=410&c=2&id='.$lignes['id_contact'].'"><img src="public/assets/img/letter.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="mailto:'.$lignes['mail_contact'].'" name="'.$lignes['id_contact'].'" value="'.$lignes['repondu_contact'].'" class="btn_aff"><img src="public/assets/img/feather-pen.png" alt="" class="icones_table modifier"></a></td>';
        if ($lignes['lu_contact'] == 1) {
            $table .= '<td><img src="public/assets/img/verifier.png" alt="" class="icones_table afficher"></td>';
        }
        else {
            $table .= '<td><img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher"></td>';
        }
        if ($lignes['repondu_contact'] == 1) {
            $table .= '<td id='.$lignes['id_contact'].'><img src="public/assets/img/verifier.png" alt="" class="icones_table afficher"></td>';
        }
        else {
            $table .= '<td id='.$lignes['id_contact'].'><img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher"></td>';
        }
        $table .= '<td><a href="index.php?page=410&c=1&sup='.$lignes['id_contact'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }
    return $table;
}
// récupère les états des devis
function req_etat_devis($bdd) {
    $requete = "SELECT * FROM etat_devis";
    $req = $bdd->prepare($requete);
    $req -> execute();
    $etats = $req -> fetchAll();

    return $etats;
}
// récupère une demande de devis précise
function req_devis($bdd,$id_contact) {
    $requete = "SELECT * FROM devis_sur_mesure
                WHERE id_contact = :id_contact";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
    $contact = $req -> fetch();

    return $contact;
}
// update devis sur mesure avec un fichier devis
function req_insert_devis_sur_mesure($bdd,$fichier_devis_sm,$id_contact) {
    $requete = "UPDATE `devis_sur_mesure` 
                SET `fichier_devis_sm`= :fichier_devis_sm
                WHERE `id_contact`=:id_contact
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> bindValue(':fichier_devis_sm', $fichier_devis_sm, PDO::PARAM_STR);
    $req -> execute();
}
// update devis sur mesure avec un fichier facture
function req_insert_facture_sur_mesure($bdd,$fichier_facture_sm,$id_contact) {
    $requete = "UPDATE `devis_sur_mesure` 
                SET `fichier_facture_sm`= :fichier_facture_sm
                WHERE `id_contact`=:id_contact
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> bindValue(':fichier_facture_sm', $fichier_facture_sm, PDO::PARAM_STR);
    $req -> execute();
}
// écrit les option du select etat devis
function options_select($etats,$etat_selected) {
    $options = "";

    foreach ($etats as $lignes) {
        if ($lignes['id_etat'] == $etat_selected) {
            $options .= '<option value="'.$lignes['id_etat'].'" selected>'.$lignes['nom_etat'].'</option>';
        }
        else {
            $options .= '<option value="'.$lignes['id_etat'].'">'.$lignes['nom_etat'].'</option>';
        }
    }
    return $options;
}
// supprime/annule un devis 
function req_sup_devis($bdd, $id_contact) {
    $requete = "UPDATE devis_sur_mesure
                SET id_etat = 4
                WHERE id_contact = :id_contact";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
} 
//---------------------------------------------------------------
//                         Boutiques
//---------------------------------------------------------------
//-------------------
// sections
//-------------------
// récupère les sections de la boutique
function req_sections($bdd) {
    $requete = "SELECT * FROM sections
                INNER JOIN images_sites ON sections.id_img = images_sites.id_img";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère une section précise
function req_section($bdd,$id_section) {
    $requete = "SELECT * FROM sections
                INNER JOIN images_sites ON sections.id_img = images_sites.id_img
                WHERE id_section = :id_section";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// crée les options pour le select section
function select_sections($sections,$id_section) {
    $select = "";

    foreach ($sections as $lignes) {
        if ($id_section == $lignes['id_section']) {
            $select .= '<option value="'.$lignes['id_section'].'" selected>'.$lignes['nom_section'].'</option>';
        }
        else {
            $select .= '<option value="'.$lignes['id_section'].'">'.$lignes['nom_section'].'</option>';
        }
    }
    return $select;
}
function req_update_section($bdd,$nom_section,$descriptif_section,$id_section) {
    $requete = "UPDATE `sections` 
                SET `nom_section`=:nom_section,
                    `descriptif_section`=:descriptif_section 
                WHERE `id_section`=:id_section
            ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> bindValue(':nom_section', $nom_section, PDO::PARAM_STR);
    $req -> bindValue(':descriptif_section', $descriptif_section, PDO::PARAM_STR);
    $req -> execute();
}
//-------------------
// Catégories
//-------------------
// récupère les catégories d'une section
function req_categories($bdd,$section) {
    $requete = "SELECT * FROM categories
                INNER JOIN images_sites ON categories.id_img = images_sites.id_img
                WHERE categories.id_section = :section
                ORDER BY categories.nom_categorie
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':section', $section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère une catégorie précise
function req_categorie($bdd,$id_categorie) {
    $requete = "SELECT * FROM categories
                INNER JOIN images_sites ON categories.id_img = images_sites.id_img
                WHERE categories.id_cat = :id_categorie
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// crée la table de gestion des catégories
function table_categories($categories) {
    $table = "";

    foreach ($categories as $lignes) {
        if ($lignes['afficher_categorie'] == 1) {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_cat'].'" value="'.$lignes['afficher_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button>';
        }
        else {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_cat'].'" value="'.$lignes['afficher_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button>';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['nom_categorie'].'</td>
            <td><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></td>
            <td>'.$affichage.'</td>
            <td><a href="index.php?page=500&c=2&id='.$lignes['id_cat'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=500&c=1&sup='.$lignes['id_cat'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }
    return $table;
}
// met à jour une catégorie
function req_categorie_update($bdd,$nom_categorie,$description_categorie,$id_section,$id_categorie) {
    $requete = "UPDATE `categories` 
                SET `nom_categorie`=:nom_categorie,
                    `descriptif_categorie`=:description_categorie,
                    `id_section`=:id_section
                WHERE id_cat = :id_categorie
                ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> bindValue(':nom_categorie', $nom_categorie, PDO::PARAM_STR);
    $req -> bindValue(':description_categorie', $description_categorie, PDO::PARAM_STR);
    $req -> execute();
}
// ajoute une catégorie
function req_categorie_insert($bdd,$nom_categorie,$description_categorie,$id_section,$id_img) {
    $requete = "INSERT INTO `categories`(`id_cat`, 
                                         `nom_categorie`, 
                                         `afficher_categorie`, 
                                         `descriptif_categorie`, 
                                         `id_section`, 
                                         `id_img`) 
                VALUES (0,
                        :nom_categorie,
                        0,
                        :description_categorie,
                        :id_section,
                        :id_img)
                ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_img', $id_img, PDO::PARAM_INT);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> bindValue(':nom_categorie', $nom_categorie, PDO::PARAM_STR);
    $req -> bindValue(':description_categorie', $description_categorie, PDO::PARAM_STR);
    $req -> execute();
}
// supprime une catégorie
function req_sup_categorie($bdd, $id_categorie) {
    $categorie = req_categorie($bdd,$id_categorie);

    $requete = "DELETE FROM categories
                WHERE id_cat = :id_categorie
                ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    $req -> execute();

    $chemin = '../public/assets/img/site/'.$categorie['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    req_sup_image_site($bdd,$categorie['id_img']);
    ?><script>window.location.assign('index.php?page=500&c=1');</script><?php
}
//-------------------
// Sous catégorie
//-------------------
// catégorie et sous catégorie (filtre) sont des sous catégories de section. chaque produit a deux sous catégorie simultanément
// récupère une sous catégorie précise
function req_sous_categorie($bdd, $id_filtre) {
    $requete = "SELECT * FROM filtres
                WHERE id_filtre = :id_filtre";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_filtre', $id_filtre, PDO::PARAM_INT);
    $req -> execute();
    
    $donnees = $req -> fetch();
    return $donnees;
}
// récupère les sous catégories
function req_sous_categories($bdd,$section) {
    $requete = "SELECT * FROM filtres
                WHERE id_section = :section";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':section', $section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// mise à jour d'une sous catégorie
function req_sous_categorie_update($bdd,$nom_filtre,$id_section,$id_filtre) {
    $requete = "UPDATE `filtres` 
                SET `nom_filtre`= :nom_filtre,
                    `id_section`= :id_section 
                WHERE `id_filtre`= :id_filtre
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_filtre', $id_filtre, PDO::PARAM_INT);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> bindValue(':nom_filtre', $nom_filtre, PDO::PARAM_STR);
    $req -> execute();
}
// ajoute une sous catégorie
function req_sous_categorie_insert($bdd,$nom_filtre,$id_section) {
    $requete = "INSERT INTO `filtres`(`id_filtre`, `nom_filtre`, `id_section`) 
                VALUES (0,:nom_filtre,:id_section)
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> bindValue(':nom_filtre', $nom_filtre, PDO::PARAM_STR);
    $req -> execute();
}
// supprime une sous catégorie
function req_sup_sous_categorie($bdd, $id_filtre) {
    $requete = "DELETE FROM `filtres` 
                WHERE id_filtre = :id_filtre
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_filtre', $id_filtre, PDO::PARAM_INT);
    $req -> execute();
}
// affiche la table de gestion des sous catégories
function table_sous_categories($sous_categories) {
    $table = "";

    foreach ($sous_categories as $lignes) {
        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['nom_filtre'].'</td>
            <td><a href="index.php?page=500&c=4&id='.$lignes['id_filtre'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=500&c=3&sup='.$lignes['id_filtre'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }
    return $table;
}
//------------------
// customisations 
//------------------
// ajout de caractéristique pour les produits personnalisable
// routeur pour l'update des customisation
function req_filtres_update($bdd,$nom,$table,$id_customisation) {
    if ($table == 'couleurs') {
        req_couleurs_update($bdd,$nom,$id_customisation);
    }
    elseif ($table == 'matieres') {
        req_matiere_update($bdd,$nom,$id_customisation);
    }
    elseif ($table == 'autres_tailles') {
        req_tailles_update($bdd,$nom,$id_customisation);
    }
    elseif ($table == 'customisations') {
        req_customisation_update($bdd,$nom,$id_customisation);
    }

}
// update d'une couleur
function req_couleurs_update($bdd,$nom,$id_couleur) {
    $requete = "UPDATE `couleurs` 
                SET `nom_couleur`= :nom
                WHERE `id_couleur`= :id_couleur";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':id_couleur', $id_couleur, PDO::PARAM_INT);
    $req -> execute();
}
// update d'une matiere
function req_matiere_update($bdd,$nom,$id_matiere) {
    $requete = "UPDATE `matieres` 
                SET `nom_matiere`= :nom
                WHERE `id_matiere`= :id_matiere";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':id_matiere', $id_matiere, PDO::PARAM_INT);
    $req -> execute();
}
// update d'une dimension
function req_tailles_update($bdd,$nom,$id_taille) {
    $requete = "UPDATE `autres_tailles` 
                SET `nom_taille`= :nom
                WHERE `id_autre_taille`= :id_taille";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> execute();
}
// update d'une autre customisation 
function req_customisation_update($bdd,$nom,$id_custom) {
    $requete = "UPDATE `customisations` 
                SET `nom_custom`= :nom
                WHERE `id_custom`= :id_custom";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
    $req -> execute();
}
// routeur pour l'insert d'une customisation 
function req_filtres_insert($bdd,$nom,$table) {
    // insert
    if ($table == 'couleurs') {
        $donnees = req_couleurs_insert($bdd,$nom);
    }
    elseif ($table == 'matieres') {
        $donnees = req_matieres_insert($bdd,$nom);
    }
    elseif ($table == 'autres_tailles') {
        $donnees = req_tailles_insert($bdd,$nom);
    }
    elseif ($table == 'customisations') {
        $donnees = req_customisations_insert($bdd,$nom);
    }
    // récupération de l'id de l'élément créer

    return $donnees;
}
// ajout d' une couleur
function req_couleurs_insert($bdd,$nom) {
    // cherche position
    $requete = "SELECT * FROM couleurs";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $nbr = $req -> rowCount();
    // insert
    $requete = "INSERT INTO `couleurs`(`id_couleur`,
                                       `nom_couleur`,
                                       `ordre_affichage`) 
                VALUES (0,
                        :nom,
                        :ordre_affichage)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':ordre_affichage', $nbr+1, PDO::PARAM_INT);
    $req -> execute();
    // recupère l'id
    $requete = "SELECT * FROM couleurs
                ORDER BY id_couleur DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['id_couleur'];
}
// ajout d' une matiere
function req_matieres_insert($bdd,$nom) {
    // cherche position
    $requete = "SELECT * FROM matieres";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $nbr = $req -> rowCount();
    //insert
    $requete = "INSERT INTO `matieres`(`id_matiere`,
                                       `nom_matiere`,
                                       ordre_affichage) 
                VALUES (0,
                        :nom,
                        :ordre_affichage)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':ordre_affichage', $nbr+1, PDO::PARAM_INT);
    $req -> execute();

    $requete = "SELECT * FROM matieres
                ORDER BY id_matiere DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['id_matiere'];
}
// ajout d'une dimension
function req_tailles_insert($bdd,$nom) {
        // cherche position
    $requete = "SELECT * FROM autres_tailles";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $nbr = $req -> rowCount();

    $requete = "INSERT INTO `autres_tailles`(`id_autre_taille`,
                                       `nom_taille`,
                                       ordre_affichage) 
                VALUES (0,
                        :nom,
                        :ordre_affichage)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':ordre_affichage', $nbr+1, PDO::PARAM_INT);
    $req -> execute();

    $requete = "SELECT * FROM autres_tailles
                ORDER BY id_autre_taille DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['id_autre_taille'];
}
// ajour d'une autre customisation
function req_customisations_insert($bdd,$nom) {
    // cherche position
    $requete = "SELECT * FROM customisations";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $nbr = $req -> rowCount();

    $requete = "INSERT INTO `customisations`(`id_custom`,
                                       `nom_custom`,
                                       ordre_affichage) 
                VALUES (0,
                        :nom,
                        :ordre_affichage)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom', $nom, PDO::PARAM_STR);
    $req -> bindValue(':ordre_affichage', $nbr+1, PDO::PARAM_INT);
    $req -> execute();

    $requete = "SELECT * FROM customisations
            ORDER BY id_custom DESC
            LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['id_custom'];
}
// récupération d'une customisation précise d'une table précise
function req_filtre($bdd,$id_customisation,$table) {
    if ($table == 'couleurs') {
        $donnees = req_couleur($bdd,$id_customisation);
    }
    elseif ($table == 'matieres') {
        $donnees = req_matiere($bdd,$id_customisation);
    }
    elseif ($table == 'autres_tailles') {
        $donnees = req_taille($bdd,$id_customisation);
    }
    elseif ($table == 'customisations') {
        $donnees = req_customisation($bdd,$id_customisation);
    }
    return $donnees;
}
// récupération de toutes les customisations d'une table précise
function req_filtres($bdd,$table,$ordre_req) {
    if ($table == 'couleurs') {
        $donnees = req_couleurs($bdd,$ordre_req);
    }
    elseif ($table == 'matieres') {
        $donnees = req_matieres($bdd,$ordre_req);
    }
    elseif ($table == 'autres_tailles') {
        $donnees = req_tailles($bdd,$ordre_req);
    }
    elseif ($table == 'customisations') {
        $donnees = req_customisations($bdd,$ordre_req);
    }
    return $donnees;
}
// récupération d'une couleur
function req_couleur($bdd,$id) {
    $requete = "SELECT * FROM couleurs
                WHERE id_couleur = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}   
// récupération d'une matière
function req_matiere($bdd,$id) {
    $requete = "SELECT * FROM matieres
                WHERE id_matiere = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupération d'une dimension
function req_taille($bdd,$id) {
    $requete = "SELECT * FROM autres_tailles
                WHERE id_autre_taille = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
function req_dimensions_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM tailles
                WHERE id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// récupération d'une autre customisation
function req_customisation($bdd,$id) {
    $requete = "SELECT * FROM customisations
                WHERE id_custom = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupération des couleurs
function req_couleurs($bdd,$ordre_req) {
    $requete = 'SELECT * FROM couleurs '
                .$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}   
// récupération des matières
function req_matieres($bdd,$ordre_req) {
    $requete = 'SELECT * FROM matieres '
                .$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération des dimensions
function req_tailles($bdd,$ordre_req) {
    $requete = 'SELECT * FROM autres_tailles '
                .$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}

// récupération des autres customisations
function req_customisations($bdd,$ordre_req) {
    $requete = 'SELECT * FROM customisations '
                .$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// mise à jour d'une image pour une customisation (uniquement couleur et matière)
function req_img_update_filtres($bdd,$id_customisation,$table,$nom_image) {
    if ($table == 'couleurs') {
        req_couleurs_img_update($bdd,$id_customisation,$nom_image);
    }
    elseif ($table == 'matieres') {
        req_matieres_img_update($bdd,$id_customisation,$nom_image);
    }
}
// update de l'image pour la table couleurs
function req_couleurs_img_update($bdd,$id_customisation,$nom_image) {
    $requete = "UPDATE `couleurs` 
                SET `img_couleur`= :nom_image
                WHERE `id_couleur`= :id
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id_customisation, PDO::PARAM_INT);
    $req -> bindValue(':nom_image', $nom_image, PDO::PARAM_STR);
    $req -> execute();
}
// update de l'image pour la table matières
function req_matieres_img_update($bdd,$id_customisation,$nom_image) {
    $requete = "UPDATE `matieres` 
                SET `img_matiere`= :nom_image
                WHERE `id_matiere`= :id
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id', $id_customisation, PDO::PARAM_INT);
    $req -> bindValue(':nom_image', $nom_image, PDO::PARAM_STR);
    $req -> execute();
}
// supprime une couleur précise
function req_couleur_sup($bdd,$id_couleur) {
    $requete = "DELETE FROM couleurs
                WHERE id_couleur = :id_couleur";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_couleur', $id_couleur, PDO::PARAM_INT);
    $req -> execute();
}
// réordonne les couleurs apres une suppression
function req_couleurs_update_ordre($bdd,$donnees) {
    $i = 1;
    foreach ($donnees as $lignes) {
        $requete = "UPDATE couleurs
                    SET ordre_affichage = $i
                    WHERE id_couleur = :id_couleur";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_couleur', $lignes['id_couleur'], PDO::PARAM_INT);
    $req -> execute();
    $i++;
    }
}
// supprime une matiere précise
function req_matiere_sup($bdd,$id_matiere) {
    $requete = "DELETE FROM matieres
                WHERE id_matiere = :id_matiere";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_matiere', $id_matiere, PDO::PARAM_INT);
    $req -> execute();
}
// réordonne les matieres apres une suppression
function req_matieres_update_ordre($bdd,$donnees) {
    $i = 1;
    foreach ($donnees as $lignes) {
        $requete = "UPDATE matieres
                    SET ordre_affichage = $i
                    WHERE id_matiere = :id_matiere";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_matiere', $lignes['id_matiere'], PDO::PARAM_INT);
    $req -> execute();
    $i++;
    }
}
// supprime une taille précise
function req_taille_sup($bdd,$id_taille) {
    $requete = "DELETE FROM autres_tailles
                WHERE id_autre_taille = :id_taille";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> execute();
}
// réordonne les tailles apres une suppression
function req_tailles_update_ordre($bdd,$donnees) {
    $i = 1;
    foreach ($donnees as $lignes) {
        $requete = "UPDATE autres_tailles
                    SET ordre_affichage = $i
                    WHERE id_autre_taille = :id_taille";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_taille', $lignes['id_autre_taille'], PDO::PARAM_INT);
    $req -> execute();
    $i++;
    }
}
// supprime une autres customisation précise
function req_customisation_sup($bdd,$id_custom) {
    $requete = "DELETE FROM customisations
                WHERE id_custom = :id_custom";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
    $req -> execute();
}
// réordonne les autres customisations apres une suppression
function req_customisations_update_ordre($bdd,$donnees) {
    $i = 1;
    foreach ($donnees as $lignes) {
        $requete = "UPDATE customisations
                    SET ordre_affichage = $i
                    WHERE id_custom = :id_custom";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_custom', $lignes['id_custom'], PDO::PARAM_INT);
    $req -> execute();
    $i++;
    }
}
// création d'input radio et checkbox pour les propriétés customisables des produits
function select_box($bdd,$entrees,$champ,$id_produit) {
    $checkbox = "";

    foreach ($entrees as $ligne) {
        // pour update test si propriété est cochée
        if ($champ == 'couleurs') {
            $customisations = req_produit_custom_c($bdd,$id_produit,$ligne[0]);
        }
        elseif ($champ == 'matieres') {
            $customisations = req_produit_custom_m($bdd,$id_produit,$ligne[0]);
        }
        elseif ($champ == 'customisations') {
            $customisations = req_produit_custom_a($bdd,$id_produit,$ligne[0]);
        }

        if (isset($customisations) && $customisations != NULL) {
            $etat = 'checked';
            $value = $customisations['prix_customisation'];
        }
        else {
            $etat = '';
            $value = '';
        }

        $checkbox .= '
        <div class="col-6 my-3">
            <div class="row flex-nowrap">
                <div class="form-check col-3 cb_c" >
                    <input class="form-check-input" type="checkbox" value="'.$ligne[0].'" id="'.$champ.$ligne[0].'" name="'.$champ.'[]" '.$etat.'/>
                    <label class="form-check-label me-3" for="'.$champ.$ligne[0].'"> '.$ligne[1].' </label>
                </div>
                <div class="col-6 me-3 d-flex align-items-center">
                    <label for="prix_'.$champ.$ligne[0].'" class="form-label me-3"> + </label>
                    <div>
                        <input class="form-control" type="text" value="'.$value.'" name="prix_'.$champ.'[]" id="prix_'.$champ.$ligne[0].'" placeholder=""/>
                        <small id="helpId6" class="form-text text-muted">augmentation du prix en €</small>
                    </div>
                    <label for="prix_'.$champ.$ligne[0].'" class="form-label ms-3"> €</label>
                </div>
        
            </div>
        </div>
        ';
    }
    $radio = "";
    foreach ($entrees as $ligne) {
        if ($champ == 'couleurs') {
            $customisations = req_produit_custom_c($bdd,$id_produit,$ligne[0]);
        }
        elseif ($champ == 'matieres') {
            $customisations = req_produit_custom_m($bdd,$id_produit,$ligne[0]);
        }
        elseif ($champ == 'customisations') {
            $customisations = req_produit_custom_a($bdd,$id_produit,$ligne[0]);
        }

        if (isset($customisations) && $customisations != NULL) {
            $etat = 'checked';
        }
        else {
            $etat = '';
        }

        $radio .= '
        <div class="form-check " >
            <input class="form-check-input" type="radio" value="'.$ligne[0].'" id="'.$champ.$ligne[0].'_r" name="'.$champ.'_r" '.$etat.'/>
            <label class="form-check-label me-3" for="'.$champ.$ligne[0].'_r"> '.$ligne[1].' </label>
        </div>
        ';
    }
    $sortie = [$checkbox,$radio];
    return $sortie;
}
// création de la partie du formulaire produit concernant les dimensions modifiable par le client à la commande
// dimensions 
function select_dimensions($bdd,$dimensions_produit) {
    $boite = "";
    foreach ($dimensions_produit as $ligne) {
        $boite .= '
        <div class="d-flex justify-content-between" >
            <input type="hidden" name="id_dimension[]" value="'.$ligne['id_taille'].'">
            <div class="mb-3 w-20">
                <label for="longueur'.$ligne['id_taille'].'" class="form-label">Longueur</label>
                <input
                    type="text"
                    class="form-control"
                    name="longueur[]"
                    id="longueur'.$ligne['id_taille'].'"
                    aria-describedby="longueur'.$ligne['id_taille'].'"
                    placeholder=""
                    value="'.$ligne['longueur'].'"
                />
                <small id="longueur'.$ligne['id_taille'].'" class="form-text text-muted">longueur disponible</small>
            </div>
            <div class="mb-3 w-20">
                <label for="largeur'.$ligne['id_taille'].'" class="form-label">Largeur</label>
                <input
                    type="text"
                    class="form-control"
                    name="largeur[]"
                    id="largeur'.$ligne['id_taille'].'"
                    aria-describedby="largeur'.$ligne['id_taille'].'"
                    placeholder=""
                    value="'.$ligne['largeur'].'"
                />
                <small id="largeur'.$ligne['id_taille'].'" class="form-text text-muted">Largeur disponible</small>
            </div>
            <div class="mb-3 w-20">
                <label for="hauteur'.$ligne['id_taille'].'" class="form-label">Hauteur</label>
                <input
                    type="text"
                    class="form-control"
                    name="hauteur[]"
                    id="hauteur'.$ligne['id_taille'].'"
                    aria-describedby="hauteur'.$ligne['id_taille'].'"
                    placeholder=""
                    value="'.$ligne['hauteur'].'"
                />
                <small id="hauteur'.$ligne['id_taille'].'" class="form-text text-muted">Hauteur disponible</small>
            </div>
            <div class="mb-3 w-20">
                <label for="prix_dimensions'.$ligne['id_taille'].'" class="form-label">Incrément prix</label>
                <input
                    type="text"
                    class="form-control"
                    name="prix_dimensions[]"
                    id="prix_dimensions'.$ligne['id_taille'].'"
                    aria-describedby="prix_dimensions'.$ligne['id_taille'].'"
                    placeholder=""
                    value="'.$ligne['prix_customisation'].'"
                />
                <small id="prix_dimensions'.$ligne['id_taille'].'" class="form-text text-muted">Pour le calcul du nouveau prix après choix des dimensions de l\'objet</small>
            </div>
        </div>
        ';
    }
    return $boite;
}
// autres tailles
function select_tailles($bdd,$tailles,$id_produit) {
    $boite = "";
    
    foreach ($tailles as $ligne) {
        $customisations = req_produit_custom_t($bdd,$id_produit,$ligne['id_autre_taille']);
        if (isset($customisations) && $customisations != NULL) {
            $min = $customisations['min_var_taille'];
            $max = $customisations['max_var_taille'];
            $step = $customisations['step_taille'];
            $prix = $customisations['prix_customisation'];
        }
        else {
            $min = '';
            $max = '';
            $step = '';
            $prix = '';
        }
        $boite .= '
        <h6>'.$ligne['nom_taille'].'</h6>
        <div class="d-flex justify-content-between" >
            <input type="hidden" name="id_autre_taille[]" value="'.$ligne['id_autre_taille'].'">
            <div class="mb-3 w-20">
                <label for="min'.$ligne['id_autre_taille'].'" class="form-label">Minimum</label>
                <input
                    type="text"
                    class="form-control"
                    name="min[]"
                    id="min'.$ligne['id_autre_taille'].'"
                    aria-describedby="min'.$ligne['id_autre_taille'].'"
                    placeholder=""
                    value="'.$min.'"
                />
                <small id="min'.$ligne['id_autre_taille'].'" class="form-text text-muted">'.$ligne['nom_taille'].' minimale possible</small>
            </div>
            <div class="mb-3 w-20">
                <label for="max'.$ligne['id_autre_taille'].'" class="form-label">Maximum</label>
                <input
                    type="text"
                    class="form-control"
                    name="max[]"
                    id="max'.$ligne['id_autre_taille'].'"
                    aria-describedby="max'.$ligne['id_autre_taille'].'"
                    placeholder=""
                    value="'.$max.'"
                />
                <small id="max'.$ligne['id_autre_taille'].'" class="form-text text-muted">'.$ligne['nom_taille'].' maximale possible</small>
            </div>
            <div class="mb-3 w-20">
                <label for="step'.$ligne['id_autre_taille'].'" class="form-label">Pas</label>
                <input
                    type="text"
                    class="form-control"
                    name="step[]"
                    id="step'.$ligne['id_autre_taille'].'"
                    aria-describedby="step'.$ligne['id_autre_taille'].'"
                    placeholder=""
                    value="'.$step.'"
                />
                <small id="step'.$ligne['id_autre_taille'].'" class="form-text text-muted">difference entre deux '.$ligne['nom_taille'].'s possibles</small>
            </div>
            <div class="mb-3 w-20">
                <label for="prix_step'.$ligne['id_autre_taille'].'" class="form-label">Incrément prix</label>
                <input
                    type="text"
                    class="form-control"
                    name="prix_step[]"
                    id="prix_step'.$ligne['id_autre_taille'].'"
                    aria-describedby="prix_step'.$ligne['id_autre_taille'].'"
                    placeholder=""
                    value="'.$prix.'"
                />
                <small id="prix_step'.$ligne['id_autre_taille'].'" class="form-text text-muted">Pour le calcul du nouveau prix après modification des dimensions de l\'objet</small>
            </div>
        </div>
        ';
    }
    return $boite;
}
// ajout d'une customisation couleur pour un produit
function req_custom_couleur_insert($bdd,$id_produit,$id_couleur,$prix_couleur){
    $requete = "INSERT INTO `customisations_couleur`(`id_produit`, 
                                                    `id_couleur`,
                                                    `prix_customisation`) 
                VALUES (:id_produit,
                        :id_couleur,
                        :prix_couleur)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_couleur', $id_couleur, PDO::PARAM_INT);
    $req -> bindValue(':prix_couleur', $prix_couleur, PDO::PARAM_STR);
    $req -> execute();
    
}
// suppression de toutes les customisations couleur pour un produit
function req_custom_couleur_sup($bdd,$id_produit) {
    $requete = "DELETE FROM customisations_couleur
                WHERE id_produit = :id_produit";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
}
// ajout d'une customisation matiere pour un produit
function req_custom_matiere_insert($bdd,$id_produit,$id_matiere,$prix_matiere){
    $requete = "INSERT INTO `customisations_matiere`(`id_produit`, 
                                                    `id_matiere`,
                                                    `prix_customisation`) 
                VALUES (:id_produit,
                        :id_matiere,
                        :prix_matiere)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_matiere', $id_matiere, PDO::PARAM_INT);
    $req -> bindValue(':prix_matiere', $prix_matiere, PDO::PARAM_STR);
    $req -> execute();
    
}
// suppression de toutes les customisations matiere pour un produit
function req_custom_matiere_sup($bdd,$id_produit) {
    $requete = "DELETE FROM customisations_matiere
                WHERE id_produit = :id_produit";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
}
// ajout d'une autre customisation  pour un produit
function req_custom_customisation_insert($bdd,$id_produit,$id_custom,$prix_custom){
    $requete = "INSERT INTO `customisations_autres`(`id_produit`, 
                                                    `id_custom`,
                                                    `prix_customisation`) 
                VALUES (:id_produit,
                        :id_custom,
                        :prix_custom)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
    $req -> bindValue(':prix_custom', $prix_custom, PDO::PARAM_STR);
    $req -> execute();
    
}
// suppression de toutes les autres customisations  pour un produit
function req_custom_customisation_sup($bdd,$id_produit) {
    $requete = "DELETE FROM customisations_autres
                WHERE id_produit = :id_produit";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
}
// ajout d'une customisation taille pour un produit
function req_custom_taille_insert($bdd,$id_produit,$id_taille,$min,$max,$step,$prix_custom){
    $requete = "INSERT INTO `customisations_taille`(`id_produit`, 
                                                    `id_autre_taille`,
                                                    `prix_customisation`,
                                                    min_var_taille,
                                                    max_var_taille,
                                                    step_taille
                                                    ) 
                VALUES (:id_produit,
                        :id_taille,
                        :prix_custom,
                        :min,
                        :max,
                        :step
                        )
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> bindValue(':prix_custom', $prix_custom, PDO::PARAM_STR);
    $req -> bindValue(':min', $min, PDO::PARAM_STR);
    $req -> bindValue(':max', $max, PDO::PARAM_STR);
    $req -> bindValue(':step', $step, PDO::PARAM_STR);
    $req -> execute();
    
}
// suppression de toutes les customisations tailles pour un produit
function req_custom_taille_sup($bdd,$id_produit) {
    $requete = "DELETE FROM customisations_taille
                WHERE id_produit = :id_produit";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
}
//------------------
// produits
//------------------
// récupère les produits d'une section
function req_produits($bdd,$id_section,$ordre) {
    $requete = 'SELECT * FROM produits
                INNER JOIN categories ON produits.id_cat = categories.id_cat
                INNER JOIN filtres ON produits.id_filtre = filtres.id_filtre
                WHERE categories.id_section = :id_section
                '.$ordre;
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère un produit précis
function req_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM produits
                INNER JOIN categories ON produits.id_cat = categories.id_cat
                INNER JOIN filtres ON produits.id_filtre = filtres.id_filtre
                WHERE produits.id_produit = :id_produit
                ';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère les customisations d'un produit
    // toutes les autres
function req_produit_custom_a($bdd,$id_produit,$id_custom) {
    $requete = 'SELECT * FROM customisations_autres
                WHERE id_produit = :id_produit AND id_custom = :id_custom';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
    // les couleurs
function req_produit_custom_c($bdd,$id_produit,$id_couleur) {
    $requete = 'SELECT * FROM customisations_couleur
                WHERE id_produit = :id_produit AND id_couleur = :id_couleur';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_couleur', $id_couleur, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
    // les tailles
function req_produit_custom_t($bdd,$id_produit,$id_taille) {
    $requete = 'SELECT * FROM customisations_taille
                WHERE id_produit = :id_produit AND id_autre_taille = :id_taille';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
    // les matières
function req_produit_custom_m($bdd,$id_produit,$id_matiere) {
    $requete = 'SELECT * FROM customisations_matiere
                WHERE id_produit = :id_produit AND id_matiere = :id_matiere';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':id_matiere', $id_matiere, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère les images d'un produit
function req_images_produit($bdd,$id_produit) {
    $requete = "SELECT * FROM images_produits
                WHERE id_produit = :id_produit 
                ORDER BY position_img_produit
                ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// crée la table de gestion des produits
function table_produits($bdd,$produits) {
    $table = '';
    foreach ($produits as $lignes) {
        $images = req_images_produit($bdd,$lignes['id_produit']);
        if ($images[1] == 0 ) {
            $nom_image = 'public/assets/img/image-gallery.png';
            $class_img = 'icones_table modifier';
        }
        else {
            $nom_image = '../public/assets/img/produits/'.$images[0][0]['nom_img_produit'];
            $class_img = 'mignature_table';
        }

        // gestion des données de type boolean
        if ($lignes['piece_unique'] == 1) {
            $unique = 'afficher';
        }
        else {
            $unique = "non_afficher";
        }
        if ($lignes['promo_produit'] == 1) {
            $promo = 'afficher';
        }
        else {
            $promo = "non_afficher";
        }
        if ($lignes['afficher_produit'] == 1) {
            $afficher = 'afficher';
        }
        else {
            $afficher = "non_afficher";
        }

        // écriture du tableau
        $table .= '
        <tr>
            <td><a href="index.php?page=530&c=1&id_produit='.$lignes['id_produit'].'"><img src="'.$nom_image.'" class="'.$class_img.'" alt="" data-bs-toggle="tooltip" data-bs-placement="top" title="Gestion des images"></a></td>
            <td>'.$lignes['nom_produit'].'</td>
            <td>'.$lignes['nom_categorie'].'</td>
            <td>'.$lignes['nom_filtre'].'</td>
            <td>'.number_format($lignes['prix_ht_produit'],2,',',' ').'€ HT <br>'.number_format($lignes['prix_ht_produit']*(1+20/100),2,',',' ').'€ TTC</td>
            <td id="'.$lignes['id_produit'].'"><input type="text" id="stock'.$lignes['id_produit'].'" value="'.$lignes['stock_produit'].'" class="input_dispo" ></td>
            <td><button type="button" class="btn btn-link btn_uni" id="uni'.$lignes['id_produit'].'"value="'.$lignes['piece_unique'].'"><img src="public/assets/img/verifier.png" class="icones_table '.$unique.'" alt=""></button></td>
            <td><button type="button" class="btn btn-link btn_promo" id="promo'.$lignes['id_produit'].'"value="'.$lignes['promo_produit'].'"><img src="public/assets/img/verifier.png" class="icones_table '.$promo.'" alt=""></button></td>
            <td><button type="button" class="btn btn-link btn_aff" id="aff'.$lignes['id_produit'].'"value="'.$lignes['afficher_produit'].'"><img src="public/assets/img/verifier.png" class="icones_table '.$afficher.'" alt=""></button></td>
            <td><a href="index.php?page=520&c=2&id='.$lignes['id_produit'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=520&c=1&sup='.$lignes['id_produit'].'&s='.$lignes['id_section'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }

    return $table;
}
// crée les options du select catégories
function select_cat($categories,$id_cat) {
    $select = "";

    foreach ($categories as $lignes) {
        if ($id_cat == $lignes['id_cat']) {
            $select .= '<option value="'.$lignes['id_cat'].'" selected>'.$lignes['nom_categorie'].'</option>';
        }
        else {
            $select .= '<option value="'.$lignes['id_cat'].'">'.$lignes['nom_categorie'].'</option>';
        }
    }
    return $select;
}
// crée les options du select sous catégorie
function select_filtre($filtres,$id_filtre) {
    $select = "";

    foreach ($filtres as $lignes) {
        if ($id_filtre == $lignes['id_filtre']) {
            $select .= '<option value="'.$lignes['id_filtre'].'" selected>'.$lignes['nom_filtre'].'</option>';
        }
        else {
            $select .= '<option value="'.$lignes['id_filtre'].'">'.$lignes['nom_filtre'].'</option>';
        }
    }
    return $select;
}
// supprime un produit
function req_sup_produit($bdd,$id_produit) {
    // supprime les customisations
    req_custom_taille_sup($bdd,$id_produit);
    req_custom_customisation_sup($bdd,$id_produit);
    req_custom_matiere_sup($bdd,$id_produit);
    req_custom_couleur_sup($bdd,$id_produit);
    // supprime les tailles
    $requete = "DELETE FROM tailles WHERE id_produit = :id_produit";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    // supprime les images
    $requete = "DELETE FROM images_produits WHERE id_produit = :id_produit"; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
    // supprime le produit
    $requete = "DELETE FROM produits WHERE id_produit = :id_produit"; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();
}
// mise à jour d'un produit
function req_update_produit($bdd,$id_produit,$nom_produit,$description_produit,$id_cat,$id_filtre,$prix_ht_produit,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$poids_produit,$customisable,$promo_produit,$id_taille,$origine_produit,$estim_tps_livraison,$devis_obligatoire) {
    $requete = "UPDATE `produits` 
                SET `nom_produit`= :nom_produit,
                `description_produit`= :description_produit,
                `prix_ht_produit`= :prix_ht_produit,
                `customisable`= :customisable,
                `promo_produit`= :promo_produit,
                `poids_produit`= :poids_produit,
                `id_cat`= :id_cat,
                `id_filtre`= :id_filtre,
                `origine_produit`= :origine_produit,
                estim_tps_livraison = :estim_tps_livraison,
                devis_obligatoire = :devis_obligatoire
                WHERE `id_produit`= :id_produit
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_produit',$nom_produit,PDO::PARAM_STR);
    $req -> bindValue(':description_produit',$description_produit,PDO::PARAM_STR);
    $req -> bindValue(':prix_ht_produit',$prix_ht_produit,PDO::PARAM_STR);
    $req -> bindValue(':customisable',$customisable,PDO::PARAM_INT);
    $req -> bindValue(':promo_produit',$promo_produit,PDO::PARAM_INT);
    $req -> bindValue(':poids_produit',$poids_produit,PDO::PARAM_STR);
    $req -> bindValue(':id_cat',$id_cat,PDO::PARAM_INT);
    $req -> bindValue(':id_filtre',$id_filtre,PDO::PARAM_INT);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> bindValue(':origine_produit',$origine_produit,PDO::PARAM_STR);
    $req -> bindValue(':estim_tps_livraison',$estim_tps_livraison,PDO::PARAM_STR);
    $req -> bindValue(':devis_obligatoire',$devis_obligatoire,PDO::PARAM_INT);
    $req -> execute();

    req_dimensions_produit_update($bdd,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$id_taille,0,$id_produit);
}
function req_dimensions_produit_update($bdd,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$id_taille,$prix_custom,$id_produit) {
    if ($id_taille != '' ) {
        $requete = "UPDATE `tailles` 
                    SET `longueur`=:longueur_ref_produit,
                        `largeur`=:largeur_ref_produit,
                        `hauteur`=:hauteur_ref_produit,
                        `prix_customisation`=:prix_custom
                    WHERE `id_taille`= :id_taille
        ";
        $req = $bdd -> prepare($requete);
        $req -> bindValue(':longueur_ref_produit',$longueur_ref_produit,PDO::PARAM_INT);
        $req -> bindValue(':largeur_ref_produit',$largeur_ref_produit,PDO::PARAM_INT);
        $req -> bindValue(':hauteur_ref_produit',$hauteur_ref_produit,PDO::PARAM_INT);
        $req -> bindValue(':prix_custom',$prix_custom,PDO::PARAM_INT);
        $req -> bindValue(':id_taille',$id_taille,PDO::PARAM_INT);
        $req -> execute();
    }
    else {
        req_dimensions_produit_insert($bdd,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$id_produit,0);
    }
}
// ajoute un produit
function req_insert_produit($bdd,$nom_produit,$description_produit,$id_cat,$id_filtre,$prix_ht_produit,$poids_produit,$customisable,$promo_produit,$origine_produit,$estim_tps_livraison,$devis_obligatoire) {
    // enregistrement des données
    $requete= "INSERT INTO `produits`(`id_produit`, 
                                      `nom_produit`, 
                                      `description_produit`, 
                                      `prix_ht_produit`, 
                                      `afficher_produit`, 
                                      `stock_produit`, 
                                      `piece_unique`, 
                                      `customisable`, 
                                      `promo_produit`,
                                      `origine_produit`,
                                      `poids_produit`, 
                                      estim_tps_livraison,
                                      devis_obligatoire,
                                      `id_cat`, 
                                      `id_filtre`) 
                VALUES (0,
                        :nom_produit,
                        :description_produit,
                        :prix_ht_produit,
                        0,
                        20,
                        0,
                        :customisable,
                        :promo_produit,
                        :origine_produit,
                        :poids_produit,
                        :estim_tps_livraison,
                        :devis_obligatoire,
                        :id_cat,
                        :id_filtre)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_produit',$nom_produit,PDO::PARAM_STR);
    $req -> bindValue(':description_produit',$description_produit,PDO::PARAM_STR);
    $req -> bindValue(':prix_ht_produit',$prix_ht_produit,PDO::PARAM_STR);
    $req -> bindValue(':customisable',$customisable,PDO::PARAM_INT);
    $req -> bindValue(':promo_produit',$promo_produit,PDO::PARAM_INT);
    $req -> bindValue(':origine_produit',$origine_produit,PDO::PARAM_STR);
    $req -> bindValue(':poids_produit',$poids_produit,PDO::PARAM_STR);
    $req -> bindValue(':estim_tps_livraison',$estim_tps_livraison,PDO::PARAM_STR);
    $req -> bindValue(':devis_obligatoire',$devis_obligatoire,PDO::PARAM_INT);
    $req -> bindValue(':id_cat',$id_cat,PDO::PARAM_INT);
    $req -> bindValue(':id_filtre',$id_filtre,PDO::PARAM_INT);
    $req -> execute();

    // récupération de l'id 
    $requete = "SELECT * FROM produits
                ORDER BY id_produit DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['id_produit'];
}
function req_dimensions_produit_insert($bdd,$longueur_ref_produit,$largeur_ref_produit,$hauteur_ref_produit,$id_produit,$prix_custom) {
    $requete = "INSERT INTO `tailles`(`id_taille`, 
                                      `longueur`, 
                                      `largeur`, 
                                      `hauteur`, 
                                      `prix_customisation`, 
                                      `id_produit`) 
                VALUES (0,
                        :longueur,
                        :largeur,
                        :hauteur,
                        :prix_custom,
                        :id_produit)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':longueur',$longueur_ref_produit,PDO::PARAM_INT);
    $req -> bindValue(':largeur',$largeur_ref_produit,PDO::PARAM_INT);
    $req -> bindValue(':hauteur',$hauteur_ref_produit,PDO::PARAM_INT);
    $req -> bindValue(':prix_custom',$prix_custom,PDO::PARAM_INT);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();
}
// crée la table de gestion des images d'un produit
function table_img_produit_gestion($donnees) {
    $boite = '
    <tr class="table-anticbeige" >
        <td scope="row"><img src="../public/assets/img/produits/'.$donnees['nom_img_produit'].'" class="mignature_table"></td>
        <td id="'.$donnees['id_img_produit'].'"><input type="text" id="position'.$donnees['id_img_produit'].'" value="'.$donnees['position_img_produit'].'" class="input_dispo"></td>';
        
        if ($donnees['afficher_img_produit'] == 1) {
            $boite .='
            <td><button type="button" class="btn btn-link btn_aff" id="aff'.$donnees['id_img_produit'].'" value="'.$donnees['afficher_img_produit'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button></td>';
        }
        else {
            $boite .='
            <td><button type="button" class="btn btn-link btn_aff" id="aff'.$donnees['id_img_produit'].'" value="'.$donnees['afficher_img_produit'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button></td>';
        }
    $boite .='
        <td><a href="index.php?page=530&c=2&id='.$donnees['id_img_produit'].'&id_produit='.$donnees['id_produit'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=530&c=1&sup='.$donnees['id_img_produit'].'&id_produit='.$donnees['id_produit'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
    return $boite;
}
// met à jour une image d'un produit
function req_img_update_produit($bdd,$id_img,$nom_image) {
    $requete = "UPDATE `images_produits` SET nom_img_produit = :nom_image 
                WHERE id_img_produit = :id_img"; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img', $id_img, PDO::PARAM_INT);
    $req->bindValue(':nom_image', $nom_image, PDO::PARAM_STR);  
    $req -> execute();
}
// ajoute une image à un produit
function req_img_insert_produit($bdd,$id_produit,$nom_image) {
    // vérifie si l'image existe déjà
    $requete = "SELECT * FROM produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                WHERE produits.id_produit = :id_produit
                ";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $i = 0;
    while($donnees = $req->fetch()) {
        if ($donnees['position_img_produit'] > $i) { 
            $i = $donnees['position_img_produit'];
        }
    }
    $position_image = $i + 1;

    // INSERT
    $requete = "INSERT INTO `images_produits`(`id_img_produit`, 
                                                `nom_img_produit`, 
                                                `position_img_produit`, 
                                                `afficher_img_produit`, 
                                                `id_produit`) 
        VALUES (0,
                :nom_image,
                $position_image, 
                1, 
                :id_produit)"; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req->bindValue(':nom_image', $nom_image, PDO::PARAM_STR);  
    $req -> execute();
}
// récupère une image précise d'un produit
function req_select_img_produit($bdd,$id_img_produit) {
    $requete = "SELECT * FROM images_produits
                WHERE id_img_produit = :id_image";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_image', $id_img_produit, PDO::PARAM_INT);
    $req -> execute();
    $donnees = $req -> fetch();
    return $donnees;
}
// supprime une image d'un produit
function req_sup_img_produit($bdd,$id_image) {
    $image = req_select_img_produit($bdd,$id_image);

    $requete = "DELETE FROM images_produits 
                WHERE id_img_produit = :id_image"; // ne pas oublier le where !!!
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_image', $id_image, PDO::PARAM_INT);
    $req -> execute();

    // mise à jour de l'ordre des images
    $images = req_images_produit($bdd, $image['id_produit']);
    $i = 1;
    foreach ($images[0] as $ligne) {
        $requete = "UPDATE `images_produits` 
                    SET `position_img_produit`= $i 
                    WHERE id_img_produit = :id_img
        ";
            $req = $bdd->prepare($requete);
            $req->bindValue(':id_img', $ligne['id_img_produit'], PDO::PARAM_INT); 
            $req -> execute();
        $i++;
    }
}
//--------------------
// promotions
//--------------------
function req_update_promo($bdd,$debut_promo,$fin_promo,$taux_promo,$texte_promo,$afficher_promo) {
    $requete = "UPDATE `promotions` 
                SET `debut_promo`=:debut_promo,
                    `fin_promo`=:fin_promo,
                    `taux_promo`=:taux_promo,
                    `texte_promo`=:texte_promo,
                    `afficher_promo`=:afficher_promo
                WHERE `id_promo`=1
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':debut_promo',$debut_promo,PDO::PARAM_INT);
    $req -> bindValue(':fin_promo',$fin_promo,PDO::PARAM_INT);
    $req -> bindValue(':taux_promo',$taux_promo,PDO::PARAM_INT);
    $req -> bindValue(':texte_promo',$texte_promo,PDO::PARAM_STR);
    $req -> bindValue(':afficher_promo',$afficher_promo,PDO::PARAM_INT);
    $req -> execute();
}
function req_promo($bdd) {
    $requete = "SELECT * FROM promotions
                WHERE id_promo = 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
//---------------------------------------------------------------
//                          Paniers
//---------------------------------------------------------------
// récupère un client précit
function req_client($bdd,$id_user) {
    $requete = "SELECT * FROM utilisateurs
                WHERE id_user = :id_user
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// select tous les paniers ventes
function req_paniers_ventes($bdd) {
    $requete = "SELECT * FROM paniers 
                GROUP BY id_commande";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select tous les paniers ventes d'un client precis
function req_paniers_ventes_client($bdd,$id_user) {
    $requete = "SELECT * FROM paniers 
                WHERE id_user = :id_user
                GROUP BY id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select un panier precis
function req_panier_vente($bdd,$id_commande) {
    $requete = "SELECT * FROM paniers
                INNER JOIN produits ON paniers.id_produit = produits.id_produit
                WHERE paniers.id_commande = :id_commande
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees, $nbr];
    return $sortie;
}
// table gestion des paniers
function table_paniers_gestion($bdd,$paniers) {
    $table = '';

    foreach ($paniers as $lignes) {
        $panier = req_panier_vente($bdd,$lignes['id_commande']);
        $prix = 0;
        $nbr = 0;
        foreach ($panier[0] as $ligne) {
            $prix += $ligne['quantite_produit']*$ligne['prix_unitaire'];
            $nbr += $ligne['quantite_produit'];
        }
        if ($lignes['id_user'] != NUll) {
            $client = req_client($bdd, $lignes['id_user']);
            $client_lien = '<a href="index.php?page=810&id='.$client['id_user'].'#'.$client['id_user'].'">'.$client['prenom_utilisateur'].' '.$client['nom_utilisateur'].'</a>';
        }
        else {
            $client_lien = 'visiteur';
        }

        $table .= '
        <tr
            class="table-anticbeige"
        >
            <td scope="row">'.$lignes['id_commande'].'</td>
            <td>'.date('d/m/Y', $lignes['id_commande']).'</td>
            <td>'.$nbr.'</td>
            <td>'.number_format($prix*(1+20/100),2,'.',' ').'</td>
            <td>'.$client_lien.'</td>
            <td><a href="index.php?page=601&id='.$lignes['id_commande'].'&c=1">Voir</a></td>
        </tr>';
    }
    return $table;
}
// select les paniers locations
function req_paniers_locations($bdd) {
    $requete = "SELECT * FROM paniers_location 
                GROUP BY id_location";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select les commandes locations
function req_commandes_locations($bdd) {
    $requete = "SELECT * FROM commandes_location 
                GROUP BY id_location";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select les commandes ventes
function req_commandes_ventes($bdd,$req_ordre) {
    $requete = "SELECT * FROM commandes
                GROUP BY id_commande".$req_ordre;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select les paniers locations pour un client précis
function req_paniers_locations_client($bdd,$id_user) {
    $requete = "SELECT * FROM paniers_location 
                WHERE id_user = :id_user
                GROUP BY id_location";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select les commandes locations pour un client précis
function req_commandes_locations_client($bdd,$id_user) {
    $requete = "SELECT * FROM commandes_location 
                WHERE id_user = :id_user
                GROUP BY id_location";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select les commandes ventes pour un client précis
function req_commandes_ventes_client($bdd,$id_user,$req_ordre) {
    $requete = "SELECT * FROM commandes 
                WHERE id_user = :id_user
                GROUP BY id_commande".$req_ordre;
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// select un panier location precis
function req_panier_location($bdd,$id_location) {
    $requete = "SELECT * FROM paniers_location
                INNER JOIN produits ON paniers_location.id_produit = produits.id_produit
                WHERE paniers_location.id_location = :id_location
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_location', $id_location, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees, $nbr];
    return $sortie;
}
// select une commande location precise
function req_commande_location($bdd,$id_location) {
    $requete = "SELECT * FROM commandes_location
                INNER JOIN produits ON commandes_location.id_produit = produits.id_produit
                WHERE commandes_location.id_location = :id_location
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_location', $id_location, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees, $nbr];
    return $sortie;
}
// select une commande vente precise
function req_commande_vente($bdd,$id_commande) {
    $requete = "SELECT * FROM commandes
                INNER JOIN produits ON commandes.id_produit = produits.id_produit
                WHERE commandes.id_commande = :id_commande
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees, $nbr];
    return $sortie;
}
// table gestion des paniers locations
function table_paniers_locations_gestion($bdd,$paniers) {
    $table = '';

    foreach ($paniers as $lignes) {
        $panier = req_panier_location($bdd,$lignes['id_location']);
        $prix = 0;
        $nbr = 0;
        foreach ($panier[0] as $ligne) {
            $prix += $ligne['quantite_produit']*$ligne['prix_unitaire'];
            $nbr += $ligne['quantite_produit'];
        }
        if ($lignes['id_user'] != NUll) {
            $client = req_client($bdd, $lignes['id_user']);
            $client_lien = '<a href="index.php?page=810&id='.$client['id_user'].'#'.$client['id_user'].'">'.$client['prenom_utilisateur'].' '.$client['nom_utilisateur'].'</a>';
        }
        else {
            $client_lien = 'visiteur';
        }

        $table .= '
        <tr
            class="table-anticbeige"
        >
            <td scope="row">'.$lignes['id_location'].'</td>
            <td>'.date('d/m/Y', $lignes['id_location']).'</td>
            <td>'.$nbr.'</td>
            <td>'.number_format($prix*(1+20/100),2,'.',' ').'</td>
            <td>'.$client_lien.'</td>
            <td><a href="index.php?page=710&id='.$lignes['id_location'].'&c=1&table=0">Voir</a></td>
        </tr>';
    }
    return $table;
}
// table gestion des commandes locations
function table_commandes_locations_gestion($bdd,$paniers) {
    $table = '';

    foreach ($paniers as $lignes) {
        $panier = req_commande_location($bdd,$lignes['id_location']);
        $prix = 0;
        $nbr = 0;
        foreach ($panier[0] as $ligne) {
            $prix += $ligne['quantite_produit']*$ligne['prix_unitaire'];
            $nbr += $ligne['quantite_produit'];
        }
        if ($lignes['id_user'] != NUll) {
            $client = req_client($bdd, $lignes['id_user']);
            $client_lien = '<a href="index.php?page=810&id='.$client['id_user'].'#'.$client['id_user'].'">'.$client['prenom_utilisateur'].' '.$client['nom_utilisateur'].'</a>';
        }
        else {
            $client_lien = 'visiteur';
        }

        $table .= '
        <tr
            class="table-anticbeige"
        >
            <td scope="row">'.$lignes['id_location'].'</td>
            <td>'.date('d/m/Y', $lignes['id_location']).'</td>
            <td>'.$nbr.'</td>
            <td>'.number_format($prix*(1+20/100),2,'.',' ').'</td>
            <td>'.$client_lien.'</td>
            <td><a href="index.php?page=710&id='.$lignes['id_location'].'&c=1&table=1">Voir</a></td>
        </tr>';
    }
    return $table;
}
// table gestion des commandes ventes
function table_commandes_ventes_gestion($bdd,$paniers) {
    $table = '';

    foreach ($paniers as $lignes) {
        $panier = req_commande_vente($bdd,$lignes['id_commande']);
        $facture = req_facture($bdd,$lignes['id_commande']);
        $livraison = req_adresse($bdd,$facture['adresse_livraison']);
        $facturation = req_adresse($bdd,$facture['adresse_facturation']);
        $cherche_devis = req_devis_v($bdd,$lignes['id_commande']);

        if ($cherche_devis != NULL ) {
            $devis = '<a href="index.php?page=621&id='.$cherche_devis['id_commande'].'">voir le devis</a>';
            $montant = $facture['montant_commande'];
        }
        else {
            $devis = 'pas de devis';
            $montant =$facture['montant_commande'];
        }

        $nbr = 0;
        foreach ($panier[0] as $ligne) {
            $nbr += $ligne['quantite_produit'];
        }
        if ($lignes['id_user'] != NUll) {
            $client = req_client($bdd, $lignes['id_user']);
            $client_lien = '<a href="index.php?page=810&id='.$client['id_user'].'#'.$client['id_user'].'">'.$client['prenom_utilisateur'].' '.$client['nom_utilisateur'].'</a>';
        }
        else {
            $client_lien = 'visiteur';
        }

        $liste_etat_livraisons = req_etat_livraison($bdd);
        if ($facture['id_etat_livraison'] == 5) {
            $etat_livraison = $facture['nom_etat_livraison'];
        }
        else {
            $etat_livraison = '
            <select class="form-select select_livrer" name="" id="'.$lignes['id_commande'].'"';
            if ($facture['id_etat_livraison'] == 4) {
                $table .= 'disabled';
            }
            $etat_livraison .= '>';
            foreach ($liste_etat_livraisons as $key) {
                if ($key['id_etat_livraison'] == $facture['id_etat_livraison']) {
    
                    $etat_livraison .= '<option value="'.$key['id_etat_livraison'].'"selected>'.$key['nom_etat_livraison'].'</option>';
                }
                else {
                    $etat_livraison .= '<option value="'.$key['id_etat_livraison'].'">'.$key['nom_etat_livraison'].'</option>';
    
                }
            }
            $etat_livraison .= '
            </select>
            ';
        }

        $table .= '
        <tr
            class="table-anticbeige"
        >
            <td scope="row">'.$lignes['id_commande'].'</td>
            <td>'.date('d/m/Y', $facture['date_commande']).'</td>
            <td>'.$nbr.'</td>
            <td>'.number_format($montant,2,'.',' ').'</td>
            <td>'.$client_lien.'</td>
            <td>'.$livraison['numero_adresse'].' '.$livraison['rue_adresse'].'<br>'.$livraison['code_postal_adresse'].' '.$livraison['ville_adresse'].'<br>'.$livraison['nom_fr_fr'].'</td>
            <td>'.$facturation['numero_adresse'].' '.$facturation['rue_adresse'].'<br>'.$facturation['code_postal_adresse'].' '.$facturation['ville_adresse'].'<br>'.$facturation['nom_fr_fr'].'</td>
            <td>'.$facture['nom_etat_commande'].'</td>
            <td>'.$etat_livraison.'</td>
            <td>'.$devis.'</td>
            <td><a href="index.php?page=601&id='.$lignes['id_commande'].'&c=2">Voir</a></td>
        </tr>';
    }
    return $table;
}
// recupère une facture précise
function req_facture($bdd,$id_commande) {
    $requete = "SELECT * FROM factures
                INNER JOIN etats_commandes ON factures.id_etat_commande = etats_commandes.id_etat_commande
                INNER JOIN etats_livraisons ON etats_livraisons.id_etat_livraison = factures.id_etat_livraison
                INNER JOIN numeros_factures ON factures.id_facture = numeros_factures.id_facture
                WHERE factures.id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère une adresse précise 
function req_adresse($bdd,$id_adresse) {
    $requete = "SELECT * FROM adresses_utilisateurs
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE adresses_utilisateurs.id_adresse = :id_adresse";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_adresse', $id_adresse, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère le devis associé à une facture si il existe
function req_devis_v($bdd,$id_commande) {
    $requete = "SELECT * FROM devis_livraisons
                INNER JOIN etat_devis ON devis_livraisons.id_etat = etat_devis.id_etat
                WHERE devis_livraisons.id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère la liste des états livraison possible 
function req_etat_livraison($bdd) {
    $requete = "SELECT * FROM etats_livraisons";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $donnees = $req -> fetchAll();
    return $donnees;
}
// vérifie si il existe deja un fichier facture associé à une commande
function req_facture_v_unique($bdd,$id_commande) {
    $requete = "SELECT * FROM factures
                INNER JOIN numeros_factures ON factures.id_facture = numeros_factures.id_facture
                WHERE factures.id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
} 
// update numeros_factures avec le fichier facture
function req_insert_facture($bdd,$fichier_facture,$id_facture) {
    $requete = "UPDATE numeros_factures
                SET fichier_facture = :fichier_facture
                WHERE id_facture = :id_facture";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':fichier_facture', $fichier_facture, PDO::PARAM_STR);
    $req -> bindValue(':id_facture', $id_facture, PDO::PARAM_INT);
    $req -> execute();
}
// nombre de facture en attente de traitement
function req_aff_nbr_livraison($bdd) {
    $requete = "SELECT COUNT(id_facture) AS nbr FROM factures
                WHERE id_etat_livraison = 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['nbr']; 
}

//--------------------------
// grille tarif petit colis
//--------------------------
// récupère le tarif livraison pour la grille tarifaire
function req_tarif($bdd,$poids,$zone) {
    $requete = "SELECT * FROM tarifs_livraison
                WHERE poids_max = :poids AND zone_destination = :zone_destination";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':poids', $poids, PDO::PARAM_INT);
    $req -> bindValue(':zone_destination', $zone, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    if ($donnees['prix'] != 0) {
        $prix = $donnees['prix'];
    }
    else {
        $prix = '-';
    }
    return $prix;
}
// récupère le nom d'un pays pour la zone 
function req_nom_pays($bdd,$id_pays) {
    $requete = "SELECT * FROM pays
                WHERE id_pays = :id_pays";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pays', $id_pays, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['nom_fr_fr'];
}
//---------------------------------------------------------------
//                              Devis
//---------------------------------------------------------------
//-------------------
// locations
//-------------------
// récupère tous les devis
function req_devis_l($bdd,$ordre_req) {
    $requete = "SELECT * FROM devis_evenementiel
                INNER JOIN utilisateurs ON devis_evenementiel.id_user = utilisateurs.id_user
                INNER JOIN etat_devis ON devis_evenementiel.id_etat = etat_devis.id_etat
                ".$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// tous les devis d'un client précis
function req_devis_l_client($bdd,$ordre_req,$id_user) {
    $requete = "SELECT * FROM devis_evenementiel
                INNER JOIN utilisateurs ON devis_evenementiel.id_user = utilisateurs.id_user
                INNER JOIN etat_devis ON devis_evenementiel.id_etat = etat_devis.id_etat
                WHERE devis_evenementiel.id_user = :id_user
                ".$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// table de gestion des devis événementiels
function table_devis_l($devis) {
    $table = '';

    foreach ($devis as $lignes) {
        if ($lignes['repondu_devis'] == 0) {
            $etat_repondu = 'non_afficher';
        }
        else {
            $etat_repondu = 'afficher';
        }

        if ($lignes['lu_devis'] == 0) {
            $etat_lu = 'non_afficher';
        }
        else {
            $etat_lu = 'afficher';
        }

        if ($lignes['id_etat'] == 1) {
            $etat = '';
            $page = '&table=0';
        }
        elseif ($lignes['id_etat'] == 2) {
            $etat = 'text-terracotta';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 3) {
            $etat = 'text-vert';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 4) {
            $etat = 'text-bleu-nuit';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 5) {
            $etat = 'text-vert';
            $page = '&table=1';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td>'.$lignes['id_devis'].'</td>
            <td>'.date('d/m/Y',$lignes['date_devis']).'</td>
            <td>'.date('d/m/Y',$lignes['date_evenement_devis']).'</td>
            <td><a href="index.php?page=710&id='.$lignes['id_location'].'&c=2'.$page.'">'.$lignes['id_location'].'</a></td>
            <td>'.$lignes['adresse_evenement'].'</td>
            <td><a href="index.php?page=810&id='.$lignes['id_user'].'#'.$lignes['id_user'].'">'.$lignes['prenom_utilisateur'].' '.$lignes['nom_utilisateur'].'</a></td>
            <td><a href ="index.php?page=721&id='.$lignes['id_devis'].'"><img src="public/assets/img/letter.png" class="icones_table '.$etat_lu.'"></a></td>
            <td id="'.$lignes['id_devis'].'" class="btn_repondre"><a href="mailto:'.$lignes['mail_utilisateur'].'?subject=Qualis%20Arma%20votre%20devis"><img src="public/assets/img/feather-pen.png" class="icones_table '.$etat_repondu.'"></a></td>
            <td class="'.$etat.' fw-bold">'.$lignes['nom_etat'].'</td>
        </tr>
        ';
    }
    return $table;
}
// récupère un devis précis
function req_devis_l_unique($bdd,$id_devis) {
    $requete = "SELECT * FROM devis_evenementiel
                INNER JOIN utilisateurs ON devis_evenementiel.id_user = utilisateurs.id_user
                INNER JOIN etat_devis ON devis_evenementiel.id_etat = etat_devis.id_etat
                WHERE devis_evenementiel.id_devis = :id_devis";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('id_devis',$id_devis,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}

// récupère un devis à partir du numéro de panier associé
function req_devis_avec_panier($bdd,$id_location) {
    $requete = "SELECT * FROM devis_evenementiel
                WHERE id_location = :id_location";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('id_location',$id_location,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// update le statu du devis à lu
function req_devis_l_lu($bdd,$id_devis) {
    $requete = "UPDATE `devis_evenementiel` 
                SET `lu_devis`= 1
                WHERE `id_devis`= :id_devis";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('id_devis',$id_devis,PDO::PARAM_INT);
    $req -> execute();
}
// update le devis avec le nom du fichier fichier devis
function req_insert_devis_location($bdd,$fichier_devis_location,$id_devis){
    $requete = "UPDATE `devis_evenementiel` 
                SET `fichier_devis_location`= :fichier_devis_location
                WHERE id_devis = :id_devis
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('id_devis',$id_devis,PDO::PARAM_INT);
    $req -> bindValue('fichier_devis_location',$fichier_devis_location,PDO::PARAM_STR);
    $req -> execute();
}
// update le devis avec le nom du fichier fichier facture
function req_insert_facture_location($bdd,$fichier_facture_location,$id_devis){
    $requete = "UPDATE `devis_evenementiel` 
                SET `fichier_facture_location`= :fichier_facture_location
                WHERE id_devis = :id_devis
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('id_devis',$id_devis,PDO::PARAM_INT);
    $req -> bindValue('fichier_facture_location',$fichier_facture_location,PDO::PARAM_STR);
    $req -> execute();
}
// nombre de devis non lu
function req_aff_nbr_devis_loc($bdd) {
    $requete = "SELECT COUNT(id_devis) AS nbr FROM devis_evenementiel
                WHERE lu_devis = 0";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['nbr'];
}

// ------------------
// livraisons
// ------------------
// nombre de devis non lu
function req_aff_nbr_devis_liv($bdd) {
    $requete = "SELECT COUNT(id_livraison) AS nbr FROM devis_livraisons
                WHERE lu_devis = 0";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['nbr'];   
}
// récupère tous les devis
function req_devis_v_all($bdd,$ordre_req) {
    $requete = "SELECT * FROM devis_livraisons
                INNER JOIN commandes ON devis_livraisons.id_commande = commandes.id_commande
                INNER JOIN utilisateurs ON utilisateurs.id_user = commandes.id_user
                INNER JOIN etat_devis ON devis_livraisons.id_etat = etat_devis.id_etat
                GROUP BY devis_livraisons.id_commande
                ".$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// tous les devis d'un client précis
function req_devis_v_client($bdd,$ordre_req,$id_user) {
    $requete = "SELECT * FROM devis_livraisons
                INNER JOIN factures ON devis_livraisons.id_commande = factures.id_commande
                INNER JOIN commandes ON factures.id_commande = commandes.id_commande
                INNER JOIN utilisateurs ON utilisateurs.id_user = commandes.id_user
                INNER JOIN etat_devis ON devis_livraisons.id_etat = etat_devis.id_etat
                WHERE commandes.id_user = :id_user
                GROUP BY devis_livraisons.id_commande
                ".$ordre_req;
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// table de gestion des devis livraisons
function table_devis_v($bdd,$devis) {
    $table = '';

    foreach ($devis as $lignes) {
        if ($lignes['repondu_devis'] == 0) {
            $etat_repondu = 'non_afficher';
        }
        else {
            $etat_repondu = 'afficher';
        }

        if ($lignes['lu_devis'] == 0) {
            $etat_lu = 'non_afficher';
        }
        else {
            $etat_lu = 'afficher';
        }

        if ($lignes['id_etat'] == 1) {
            $etat = '';
            $page = '&table=0';
        }
        elseif ($lignes['id_etat'] == 2) {
            $etat = 'text-terracotta';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 3) {
            $etat = 'text-vert';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 4) {
            $etat = 'text-bleu-nuit';
            $page = '&table=1';
        }
        elseif ($lignes['id_etat'] == 5) {
            $etat = 'text-orange';
            $page = '&table=1';
        }

        $facture = req_facture($bdd,$lignes['id_commande']);
        $livraison = req_adresse($bdd, $facture['adresse_livraison']);

        $table .= '
        <tr class="table-anticbeige">
            <td>'.$lignes['id_livraison'].'</td>
            <td>'.date('d/m/Y',$lignes['id_commande']).'</td>
            <td><a href="index.php?page=601&id='.$lignes['id_commande'].'&c=3">'.$lignes['id_commande'].'</a></td>
            <td>w'.$facture['id_facture'].'</td>
            <td>'.$livraison['numero_adresse'].' '.$livraison['rue_adresse'].'<br>'.$livraison['code_postal_adresse'].' '.$livraison['ville_adresse'].'<br>'.$livraison['nom_fr_fr'].'</td>
            <td><a href="index.php?page=810&id='.$lignes['id_user'].'#'.$lignes['id_user'].'">'.$lignes['prenom_utilisateur'].' '.$lignes['nom_utilisateur'].'</a></td>
            <td><a href ="index.php?page=621&id='.$lignes['id_commande'].'"><img src="public/assets/img/letter.png" class="icones_table '.$etat_lu.'"></a></td>
            <td id="'.$lignes['id_livraison'].'" class="btn_repondre"><a href="mailto:'.$lignes['mail_utilisateur'].'?subject=Qualis%20Arma%20votre%20devis"><img src="public/assets/img/feather-pen.png" class="icones_table '.$etat_repondu.'"></a></td>
            <td class="'.$etat.' fw-bold">'.$lignes['nom_etat'].'</td>
        </tr>
        ';
    }
    return $table;
}
// récupère les tailles du produit pour commande
function req_produit_taille_select($bdd,$id_produit) {
    $requete = "SELECT * FROM commandes
                INNER JOIN tailles ON commandes.id_taille = tailles.id_taille
                WHERE commandes.id_produit = :id_produit 
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// select une commande vente precise
function req_commande_vente_detail($bdd,$id_commande) {
    $requete = "SELECT * FROM commandes
                INNER JOIN produits ON commandes.id_produit = produits.id_produit
                WHERE commandes.id_commande = :id_commande
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
//update devis livraison : prix et statu répondu à 1 (à fait une proposition)
function req_update_prix_dl($bdd,$prix_livraisons,$id_commande) {
    $requete = "UPDATE `devis_livraisons` 
                SET `prix_livraisons`=:prix_livraisons,
                    `id_etat`= 5
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':prix_livraisons', $prix_livraisons, PDO::PARAM_STR);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
// update devis livraison : fichier devis 
function req_update_fichier_dl($bdd,$fichier_devis_livraison,$id_commande) {
    $requete = "UPDATE `devis_livraisons` 
                SET `fichier_devis_livraison`=:fichier_devis_livraison 
                WHERE `id_commande`=:id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':fichier_devis_livraison', $fichier_devis_livraison, PDO::PARAM_STR);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
// update devis livraisons : état lu
function req_devis_dl_lu($bdd,$id_commande) {
    $requete = "UPDATE `devis_livraisons`
                SET lu_devis = 1
                WHERE `id_commande`=:id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
//---------------------------------------------------------------
//                         Administratif
//---------------------------------------------------------------

//-------------------
// Contacts
//-------------------
// récupère tous les messages qui ne sont pas des demandes de devis
function req_contacts($bdd,$ordre_req) {
    $requete = 'SELECT * FROM contacts
                INNER JOIN sujets_contacts ON contacts.id_sujet = sujets_contacts.id_sujet
                WHERE contacts.id_sujet > 1
                '.$ordre_req;
    $req = $bdd->prepare($requete);
    $req -> execute();
    $contacts = $req -> fetchAll();

    return $contacts;
}
// récupère un message précis
function req_contact($bdd, $id_contact) {
    $requete = "SELECT * FROM contacts
                INNER JOIN sujets_contacts ON contacts.id_sujet = sujets_contacts.id_sujet
                WHERE contacts.id_contact = :id_contact";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
    $contact = $req -> fetch();

    return $contact;
}
// update l'état d'un message comme lue
function req_lu_contact($bdd, $id_contact) {
    $requete = "UPDATE `contacts` SET `lu_contact`= 1 
                WHERE id_contact = :id_contact";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
}
// supprime un message
function req_sup_contacts($bdd, $id_contact) {
    $requete = "DELETE FROM contacts
                WHERE id_contact = :id_contact";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
} 
// table de gestion des messages
function table_contacts($devis) {
    $table = "";
    
    foreach ($devis as $lignes) {
        if ($lignes['lu_contact'] == 0) {
            $badge = '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-camel">
            Nouveau
            <span class="visually-hidden">unread messages</span>
          </span>';
        }
        else {
            $badge ='';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row">'.$lignes['id_contact'].'</td>
            <td class="position-relative">'.date('d/m/Y à H:i',$lignes['date_contact']).$badge.'</td>
            <td>'.$lignes['nom_contact'].'</td>
            <td>'.$lignes['mail_contact'].'</td>
            <td>'.$lignes['tel_contact'].'</td>
            <td>'.$lignes['nom_sujet'].'</td>
            <td><a href="index.php?page=800&c=2&id='.$lignes['id_contact'].'"><img src="public/assets/img/letter.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="mailto:'.$lignes['mail_contact'].'" name="'.$lignes['id_contact'].'" value="'.$lignes['repondu_contact'].'" class="btn_aff"><img src="public/assets/img/feather-pen.png" alt="" class="icones_table modifier"></a></td>';
        if ($lignes['lu_contact'] == 1) {
            $table .= '<td><img src="public/assets/img/verifier.png" alt="" class="icones_table afficher"></td>';
        }
        else {
            $table .= '<td><img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher"></td>';
        }
        if ($lignes['repondu_contact'] == 1) {
            $table .= '<td id='.$lignes['id_contact'].'><img src="public/assets/img/verifier.png" alt="" class="icones_table afficher"></td>';
        }
        else {
            $table .= '<td id='.$lignes['id_contact'].'><img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher"></td>';
        }
        $table .= '<td><a href="index.php?page=800&c=1&sup='.$lignes['id_contact'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }
    return $table;
}
// trouve le nombre de message non lu
function req_aff_nbr_messages($bdd,$cas) {
    $requete = "SELECT COUNT(id_contact) AS nbr FROM contacts 
                WHERE lu_contact = 0 AND id_sujet ".$cas;
    $req = $bdd->prepare($requete);
    $req -> execute();
    
    $donnees = $req -> fetch();
    return $donnees['nbr'];
}
//-------------------
// Clients
//-------------------
// récupère tous les clients
function req_clients($bdd,$ordre_req) {
    $requete = 'SELECT * FROM utilisateurs 
                WHERE id_cat_utilisateur = 2
               '.$ordre_req;
    $req = $bdd->prepare($requete);
    $req -> execute();
    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère les adresses de livraison d'un client
function req_adresse_livraison($bdd,$id_user) {
    $requete = "SELECT * FROM adresses_utilisateurs
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE adresses_utilisateurs.id_user = :id_user AND adresses_utilisateurs.livraison_adresse = 1";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();
    
    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère les adresses de facturation d'un client
function req_adresse_facturation($bdd,$id_user) {
    $requete = "SELECT * FROM adresses_utilisateurs
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE adresses_utilisateurs.id_user = :id_user AND adresses_utilisateurs.facturation_adresse = 1";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();
    
    $donnees = $req -> fetchAll();
    return $donnees;
}
// crée la table de gestion des clients
function table_clients($clients, $bdd,$id_user) {
    $table = "";

    foreach ($clients as $lignes) {
        $livraisons = req_adresse_livraison($bdd,$lignes['id_user']);
        $facturations = req_adresse_facturation($bdd,$lignes['id_user']);

        // adresse livraison
        if(isset($livraisons) && $livraisons != NULL) {
            $i = 1;
            $livraison = '<td class="text-start">';
            foreach ($livraisons as $ligne) {
                $livraison .= '<strong>adresse '.$i.'</strong> :
                '.$ligne['rue_adresse'].'<br>'.$ligne['code_postal_adresse'].' '.$ligne['ville_adresse'].'<br>'.$ligne['nom_fr_fr'].'<br>'.$ligne['complement_adresse'];
                $i++;
            }
            $livraison .= '</td>';
        }
        else {
            $livraison = '<td></td>';
        }
        // adresse facturation
        if(isset($facturations) && $facturations != NULL) {
            $i = 1;
            $facturation = '<td class="text-start">';
            foreach ($facturations as $ligne) {
                $facturation .= '<strong>adresse '.$i.'</strong> :
                '.$ligne['rue_adresse'].'<br>'.$ligne['code_postal_adresse'].' '.$ligne['ville_adresse'].'<br>'.$ligne['nom_fr_fr'].'<br>'.$ligne['complement_adresse'];
                $i++;
            }
        }
        else {
            $facturation = '<td></td>';
        }

        // couleur de la ligne si cherche un client précit
        if ($id_user == $lignes['id_user']) {
            $couleur = 'table-baby-blue';
        }
        else {
            $couleur = 'table-anticbeige';
        }
        $table .= '
        <tr class="'.$couleur.'" id="'.$lignes['id_user'].'">
            <td scope="row">'.$lignes['identifiant_client'].'</td>
            <td>'.date('d/m/Y à H:i',$lignes['identifiant_client']).'</td>
            <td>'.$lignes['nom_utilisateur'].'</td>
            <td>'.$lignes['prenom_utilisateur'].'</td>
            <td>'.$lignes['mail_utilisateur'].'</td>
            <td>'.$lignes['tel_utilisateur'].'</td>
            '.$livraison.'
            '.$facturation.'
    
            <td>
                <a href="index.php?page=600&id='.$lignes['id_user'].'">voir boutique</a><br>
                <a href="index.php?page=700&id='.$lignes['id_user'].'">voir locations</a>
            </td>
            
            <td>
                <a href="index.php?page=610&id='.$lignes['id_user'].'">voir boutique</a>
            </td>
            <td>
                <a href="index.php?page=410&id='.$lignes['mail_utilisateur'].'">voir sur-mesure</a><br>
                <a href="index.php?page=620&id='.$lignes['id_user'].'">voir boutique</a><br>
                <a href="index.php?page=720&id='.$lignes['id_user'].'">voir locations</a>
            </td>
            
        </tr>
        ';
    }
    return $table;
}
// récupère la liste des clients pour la newsletter
function req_user_newsletter($bdd) {
    $requete = "SELECT * FROM utilisateurs
                WHERE newsletter = 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
//-------------------
// Partenaires
//-------------------
// crée la table de gestion des partenaires
function table_partenaires($datas) {
    $table = "";

    foreach ($datas as $lignes) {
        if ($lignes['afficher_partenaire'] == 1) {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_partenaire'].'" value="'.$lignes['afficher_partenaire'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button>';
        }
        else {
            $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_partenaire'].'" value="'.$lignes['afficher_partenaire'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button>';
        }

        $table .= '
        <tr class="table-anticbeige">
            <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table"></td>
            <td>'.$lignes['nom_partenaire'].'</td>
            <td>'.$lignes['adresse_site_partenaire'].'</td>
            <td>'.$lignes['mail_partenaire'].'</td>
            <td>'.$lignes['tel_partenaire'].'</td>
            <td>'.$affichage.'</td>
            <td><a href="index.php?page=820&c=2&id='.$lignes['id_partenaire'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=820&c=1&sup='.$lignes['id_partenaire'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }

    return $table;
}
// récupère les partenaires
function req_partenaires($bdd) {
    $requete = "SELECT * FROM partenaires
                INNER JOIN images_sites ON partenaires.id_img = images_sites.id_img
                ORDER BY partenaires.nom_partenaire";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère un partenaire précis
function req_partenaire($bdd, $id_partenaire) {
    $requete = "SELECT * FROM partenaires
                WHERE id_partenaire = :id_partenaire
    ";
    $req = $bdd -> prepare ($requete);
    $req -> bindValue(':id_partenaire', $id_partenaire, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// supprime un partenaire 
function req_sup_partenaire($bdd, $id_partenaire) {
    $partenaire = req_partenaire($bdd, $id_partenaire);
    $logo = req_img_site($bdd,$partenaire['id_img']);

    $requete = "DELETE FROM partenaires 
                WHERE id_partenaire = :id_partenaire";
    $req = $bdd -> prepare ($requete);
    $req -> bindValue(':id_partenaire', $id_partenaire, PDO::PARAM_INT);
    $req -> execute();

    $chemin = '../public/assets/img/site/'.$logo['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    req_sup_image_site($bdd,$logo['id_img']);
}
// mise à jour d'un partenaire
function req_partenaire_update($bdd,$nom_partenaire,$mail_partenaire,$adresse_site_partenaire,$description_partenaire,$tel_partenaire,$id_partenaire) {
    $requete = "UPDATE `partenaires` 
                SET `nom_partenaire`=:nom_partenaire,
                    `mail_partenaire`=:mail_partenaire,
                    `adresse_site_partenaire`=:adresse_site_partenaire,
                    `description_partenaire`=:description_partenaire,
                    `tel_partenaire`=:tel_partenaire
                WHERE id_partenaire = :id_partenaire
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_partenaire', $nom_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':mail_partenaire', $mail_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':adresse_site_partenaire', $adresse_site_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':description_partenaire', $description_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':tel_partenaire', $tel_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':id_partenaire', $id_partenaire, PDO::PARAM_INT);
    $req -> execute();
}
// ajouter un partenaire
function req_partenaire_insert($bdd,$nom_partenaire,$mail_partenaire,$adresse_site_partenaire,$description_partenaire,$tel_partenaire,$id_img) {
    $requete = "INSERT INTO `partenaires`(`id_partenaire`, 
                                        `nom_partenaire`, 
                                        `mail_partenaire`, 
                                        `adresse_site_partenaire`, 
                                        `description_partenaire`, 
                                        `tel_partenaire`, 
                                        `afficher_partenaire`, 
                                        `id_img`) 
                VALUES (0,
                        :nom_partenaire,
                        :mail_partenaire,
                        :adresse_site_partenaire,
                        :description_partenaire,
                        :tel_partenaire,
                        0,
                        $id_img)
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':nom_partenaire', $nom_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':mail_partenaire', $mail_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':adresse_site_partenaire', $adresse_site_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':description_partenaire', $description_partenaire, PDO::PARAM_STR);
    $req -> bindValue(':tel_partenaire', $tel_partenaire, PDO::PARAM_STR);
    $req -> execute();
}

//------------------
// FAQ
//------------------
// sélectionne  une question précise
function req_faq($bdd,$id_faq) {
    $requete = "SELECT * FROM faq
                WHERE id_faq = :id_faq";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// sélectionne toutes les questions
function req_all_faq($bdd) {
    $requete = "SELECT * FROM faq
                ";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// update une question 
function req_update_faq($bdd,$question_faq,$reponse_faq,$id_faq) {
    $requete = "UPDATE `faq` 
                SET `question_faq`=:question_faq,
                    `reponse_faq`=:reponse_faq
                WHERE `id_faq`=:id_faq
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
    $req -> bindValue(':question_faq', $question_faq, PDO::PARAM_STR);
    $req -> bindValue(':reponse_faq', $reponse_faq, PDO::PARAM_STR);
    $req -> execute();
}
// insert une question
function req_insert_faq($bdd,$question_faq,$reponse_faq) {
    $nbr = req_all_faq($bdd);

    $requete = "INSERT INTO `faq`(`id_faq`, 
                                  `question_faq`, 
                                  `reponse_faq`, 
                                  `afficher_faq`, 
                                  `position_faq`) 
                VALUES (0,
                        :question_faq,
                        :reponse_faq,
                        0,
                        :nbr)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':question_faq', $question_faq, PDO::PARAM_STR);
    $req -> bindValue(':reponse_faq', $reponse_faq, PDO::PARAM_STR);
    $req -> bindValue(':nbr', $nbr[1]+1, PDO::PARAM_INT);
    $req -> execute();
}
// supprime une question
function req_sup_faq($bdd,$id_faq) {
    $requete = "DELETE FROM `faq` 
                WHERE id_faq = :id_faq
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
    $req -> execute();
}

//------------------------------------------------------------------------
//                       pages fixes
//------------------------------------------------------------------------
// récupère le nom d'une page fixe
function req_pages_fixes($bdd,$id_pf) {
    $requete = "SELECT * FROM pages_fixes
                WHERE id_pf = :id_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère un paragraphe précis des pages fixes
function req_pages_fixes_txt($bdd,$id_txt_pf) {
    $requete = "SELECT * FROM textes_pages_fixes
                WHERE id_txt_pf = :id_txt_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_txt_pf', $id_txt_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère tous les paragraphes d'une page fixe
function req_pages_fixes_all_txt($bdd,$id_pf) {
    $requete = "SELECT * FROM textes_pages_fixes
                WHERE id_pf = :id_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// update paragraphe de page fixe 
function req_update_pages_fixes($bdd,$titre_pf,$texte_pf,$id_txt_pf) {
    $requete = "UPDATE `textes_pages_fixes` 
                SET `titre_pf`=:titre_pf,
                    `texte_pf`=:texte_pf
                WHERE `id_txt_pf`=:id_txt_pf
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_txt_pf', $id_txt_pf, PDO::PARAM_INT);
    $req -> bindValue(':titre_pf', $titre_pf, PDO::PARAM_STR);
    $req -> bindValue(':texte_pf', $texte_pf, PDO::PARAM_STR);
    $req -> execute();
}
// insert paragraphe de page fixe
function req_insert_pages_fixes($bdd,$titre_pf,$texte_pf,$id_pf) {
    $requete = "INSERT INTO `textes_pages_fixes`(`id_txt_pf`, 
                                                 `titre_pf`, 
                                                 `texte_pf`, 
                                                 `id_pf`) 
                VALUES (0,
                        :titre_pf,
                        :texte_pf,
                        :id_pf)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> bindValue(':titre_pf', $titre_pf, PDO::PARAM_STR);
    $req -> bindValue(':texte_pf', $texte_pf, PDO::PARAM_STR);
    $req -> execute();
}
//supprime un paragraphe 
function req_sup_txt_pf($bdd,$id_txt_pf) {
    $requete = "DELETE FROM `textes_pages_fixes` 
                WHERE id_txt_pf = :id_txt_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_txt_pf', $id_txt_pf, PDO::PARAM_INT);
    $req -> execute();
}
// supprime une image
function req_sup_img_pf($bdd,$id_img_pf,$id_pf) {
    // supprime dans la page img_pages_fixes
    $requete = "DELETE FROM `img_pages_fixes` 
                WHERE id_img = :id_img_pf AND id_pf = :id_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_img_pf', $id_img_pf, PDO::PARAM_INT);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    // récupère le nom de l'image
    $requete = "SELECT * FROM images_sites
                WHERE id_img = :id_img";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_img', $id_img_pf, PDO::PARAM_INT);
    $req -> execute();
    $img = $req -> fetch();
    // suprime l'image dans le dossier
    $chemin = '../public/assets/img/site/'.$img['nom_img'];
    if (file_exists($chemin)) {
        unlink($chemin);
    }
    // supprime l'image dans la table
    $requete = "DELETE FROM images_sites
                WHERE id_img = :id_img";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_img', $id_img_pf, PDO::PARAM_INT);
    $req -> execute();
}
// ajoute une image aux pages fixes
function req_insert_img_pf($bdd,$id_pf,$nom_image) {
    $id_img = req_img_site_insert($bdd,$nom_image);

    $requete = "INSERT INTO `img_pages_fixes`(`id_img`, `id_pf`) 
                VALUES (:id_img,:id_pf)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> bindValue(':id_img', $id_img['id_img'], PDO::PARAM_INT);
    $req -> execute();

}
// récupères les images d'une page fixe 
function req_img_pf($bdd,$id_pf) {
    $requete = "SELECT * FROM img_pages_fixes
                INNER JOIN images_sites ON img_pages_fixes.id_img = images_sites.id_img
                WHERE id_pf = :id_pf
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
?>