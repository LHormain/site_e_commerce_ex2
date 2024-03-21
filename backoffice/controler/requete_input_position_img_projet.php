<?php
$user = 'root';
$pass = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=qualis_arma',$user,$pass); // concerne la base
}
catch(PDOException $e) {
    die('Erreur : '.$e->getMessage());
}


// récupération des catégories 
if (isset($_POST['position_image'],
          $_POST['id_img']) 
          && $_POST['position_image'] != NULL
          && $_POST['id_img'] != NULL
    ) {
    $position_image = intval($_POST['position_image']);
    $id_img = intval($_POST['id_img']);
}
else {
    $position_image = 0;
    $id_img = 0;
}

// // cherche le projet
$requete = "SELECT * FROM galerie WHERE id_img = :id_img1";
$req = $bdd->prepare($requete);
$req -> bindValue(':id_img1', $id_img, PDO::PARAM_INT);
$req -> execute();
$image = $req -> fetch();

//cherche si position deja affecter pour le projet
$requete = "SELECT * FROM galerie 
            WHERE  position_image = :position_image AND id_projet = :id_projet";
$req = $bdd->prepare($requete);
$req->bindValue(':position_image', $position_image, PDO::PARAM_INT);
$req->bindValue(':id_projet', $image['id_projet'], PDO::PARAM_INT);
$req -> execute();

$double = $req -> fetch();
$test = $req -> rowCount();

if ($test != 0) {
    // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
    $requete = "UPDATE `galerie`
                SET position_image = :position_image
                WHERE id_img = :id_img2
                    "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img2', $double['id_img'], PDO::PARAM_INT);
    $req->bindValue(':position_image', $image['position_image'], PDO::PARAM_INT);
    $req -> execute();
}

// met la nouvelle position à l'image 1
$requete = "UPDATE `galerie`
            SET position_image = :position_image
            WHERE id_img = :id_img
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_img', $id_img, PDO::PARAM_INT);
$req4->bindValue(':position_image', $position_image, PDO::PARAM_INT);
$req4 -> execute();
?>