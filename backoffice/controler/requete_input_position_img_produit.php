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
if (isset($_POST['position_img_produit'],
          $_POST['id_img_produit']) 
          && $_POST['position_img_produit'] != NULL
          && $_POST['id_img_produit'] != NULL
    ) {
    $position_img_produit = intval($_POST['position_img_produit']);
    $id_img_produit = intval($_POST['id_img_produit']);
}
else {
    $position_img_produit = 0;
    $id_img_produit = 0;
}

// // cherche le produit
$requete = "SELECT * FROM images_produits WHERE id_img_produit = :id_img_produit1";
$req = $bdd->prepare($requete);
$req -> bindValue(':id_img_produit1', $id_img_produit, PDO::PARAM_INT);
$req -> execute();
$image = $req -> fetch();

//cherche si position deja affecter pour le produit
$requete = "SELECT * FROM images_produits 
            WHERE id_produit = :id_produit AND position_img_produit = :position_img_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $image['id_produit'], PDO::PARAM_INT);
$req->bindValue(':position_img_produit', $position_img_produit, PDO::PARAM_INT);
$req -> execute();

$double = $req -> fetch();
$test = $req -> rowCount();

if ($test != 0) {
    // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
    $requete = "UPDATE `images_produits`
                SET position_img_produit = :position_img_produit
                WHERE id_img_produit = :id_img_produit2
                    "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_img_produit2', $double['id_img_produit'], PDO::PARAM_INT);
    $req->bindValue(':position_img_produit', $image['position_img_produit'], PDO::PARAM_INT);
    $req -> execute();
}

// met la nouvelle position à l'image 1
$requete = "UPDATE `images_produits`
            SET position_img_produit = :position_img_produit
            WHERE id_img_produit = :id_img_produit
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_img_produit', $id_img_produit, PDO::PARAM_INT);
$req4->bindValue(':position_img_produit', $position_img_produit, PDO::PARAM_INT);
$req4 -> execute();
?>