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
if (isset($_POST['promo_produit'],
          $_POST['id_produit']) 
          && $_POST['promo_produit'] != NULL
          && $_POST['id_produit'] != NULL
    ) {
    $promo_produit = intval($_POST['promo_produit']);
    $id_produit = intval($_POST['id_produit']);

    if ($promo_produit == 1) {
        $promo_produit = 0;
    }
    else {
        $promo_produit = 1;
    }
}
else {
    $promo_produit = 0;
    $id_produit = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `produits` SET promo_produit = :promo_produit WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req->bindValue(':promo_produit', $promo_produit, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM produits WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>