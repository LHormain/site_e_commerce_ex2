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
if (isset($_POST['afficher_img_produit'],
          $_POST['id_img_produit']) 
          && $_POST['afficher_img_produit'] != NULL
          && $_POST['id_img_produit'] != NULL
    ) {
    $afficher_img_produit = intval($_POST['afficher_img_produit']);
    $id_img_produit = intval($_POST['id_img_produit']);

    if ($afficher_img_produit == 1) {
        $afficher_img_produit = 0;
    }
    else {
        $afficher_img_produit = 1;
    }
}
else {
    $afficher_img_produit = 0;
    $id_img_produit = 0;
}
//
$requete = "UPDATE `images_produits` SET afficher_img_produit = :afficher_img_produit WHERE id_img_produit = :id_img_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_img_produit', $id_img_produit, PDO::PARAM_INT);
$req->bindValue(':afficher_img_produit', $afficher_img_produit, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM images_produits WHERE id_img_produit = :id_img_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_img_produit', $id_img_produit, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>