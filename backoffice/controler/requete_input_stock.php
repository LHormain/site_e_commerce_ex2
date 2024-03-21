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
if (isset($_POST['stock_produit'],
          $_POST['id_produit']) 
          && $_POST['stock_produit'] != NULL
          && $_POST['id_produit'] != NULL
    ) {
    $stock_produit = intval($_POST['stock_produit']);
    $id_produit = intval($_POST['id_produit']);
}
else {
    $stock_produit = 0;
    $id_produit = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `produits`
            SET stock_produit = :stock_produit
            WHERE id_produit = :id_produit
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req4->bindValue(':stock_produit', $stock_produit, PDO::PARAM_STR);
$req4 -> execute();
?>