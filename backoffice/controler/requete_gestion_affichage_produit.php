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
if (isset($_POST['afficher_produit'],
          $_POST['id_produit']) 
          && $_POST['afficher_produit'] != NULL
          && $_POST['id_produit'] != NULL
    ) {
    $afficher_produit = intval($_POST['afficher_produit']);
    $id_produit = intval($_POST['id_produit']);

    if ($afficher_produit == 1) {
        $afficher_produit = 0;
    }
    else {
        $afficher_produit = 1;
    }
}
else {
    $afficher_produit = 0;
    $id_produit = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `produits` SET afficher_produit = :afficher_produit WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req->bindValue(':afficher_produit', $afficher_produit, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM produits WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>