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
if (isset($_POST['piece_unique'],
          $_POST['id_produit']) 
          && $_POST['piece_unique'] != NULL
          && $_POST['id_produit'] != NULL
    ) {
    $piece_unique = intval($_POST['piece_unique']);
    $id_produit = intval($_POST['id_produit']);

    if ($piece_unique == 1) {
        $piece_unique = 0;
    }
    else {
        $piece_unique = 1;
    }
}
else {
    $piece_unique = 0;
    $id_produit = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `produits` SET piece_unique = :piece_unique WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req->bindValue(':piece_unique', $piece_unique, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM produits WHERE id_produit = :id_produit";
$req = $bdd->prepare($requete);
$req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>