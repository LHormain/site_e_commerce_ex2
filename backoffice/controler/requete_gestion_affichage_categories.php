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
if (isset($_POST['afficher_categorie'],
          $_POST['id_categorie']) 
          && $_POST['afficher_categorie'] != NULL
          && $_POST['id_categorie'] != NULL
    ) {
    $afficher_categorie = intval($_POST['afficher_categorie']);
    $id_categorie = intval($_POST['id_categorie']);

    if ($afficher_categorie == 1) {
        $afficher_categorie = 0;
    }
    else {
        $afficher_categorie = 1;
    }
}
else {
    $afficher_categorie = 0;
    $id_categorie = 0;
}
// 
$requete = "UPDATE `categories` SET afficher_categorie = :afficher_categorie WHERE id_cat = :id_categorie";
$req = $bdd->prepare($requete);
$req->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
$req->bindValue(':afficher_categorie', $afficher_categorie, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM categories WHERE id_cat = :id_categorie";
$req = $bdd->prepare($requete);
$req->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>