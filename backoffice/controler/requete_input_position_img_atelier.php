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
          $_POST['id_image']) 
          && $_POST['position_image'] != NULL
          && $_POST['id_image'] != NULL
    ) {
    $position_image = intval($_POST['position_image']);
    $id_image = intval($_POST['id_image']);
}
else {
    $position_image = 0;
    $id_image = 0;
}

// // cherche l'atelier'
$requete = "SELECT * FROM illustrations_ateliers WHERE id_img = :id_image1";
$req = $bdd->prepare($requete);
$req -> bindValue(':id_image1', $id_image, PDO::PARAM_INT);
$req -> execute();
$image = $req -> fetch();

//cherche si position deja affecter pour l'atelier'
$requete = "SELECT * FROM illustrations_ateliers 
            WHERE  position_image = :position_image AND id_atelier = :id_atelier";
$req = $bdd->prepare($requete);
$req->bindValue(':position_image', $position_image, PDO::PARAM_INT);
$req->bindValue(':id_atelier', $image['id_atelier'], PDO::PARAM_INT);
$req -> execute();

$double = $req -> fetch();
$test = $req -> rowCount();

if ($test != 0) {
    // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
    $requete = "UPDATE `illustrations_ateliers`
                SET position_image = :position_image
                WHERE id_img = :id_image2
                    "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_image2', $double['id_img'], PDO::PARAM_INT);
    $req->bindValue(':position_image', $image['position_image'], PDO::PARAM_INT);
    $req -> execute();
}

// met la nouvelle position à l'image 1
$requete = "UPDATE `illustrations_ateliers`
            SET position_image = :position_image
            WHERE id_img = :id_image
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_image', $id_image, PDO::PARAM_INT);
$req4->bindValue(':position_image', $position_image, PDO::PARAM_INT);
$req4 -> execute();
?>