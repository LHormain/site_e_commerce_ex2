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
if (isset($_POST['promo_categorie'],
          $_POST['id_cat']) 
          && $_POST['promo_categorie'] != NULL
          && $_POST['id_cat'] != NULL
    ) {
    $promo_categorie = intval($_POST['promo_categorie']);
    $id_cat = intval($_POST['id_cat']);

    if ($promo_categorie == 1) {
        $promo_categorie = 0;
    }
    else {
        $promo_categorie = 1;
    }
}
else {
    $promo_categorie = 0;
    $id_cat = 0;
}
//mise à jour de la table catégories
$requete = "UPDATE `categories` SET promo_categorie = :promo_categorie WHERE id_cat = :id_cat";
$req = $bdd->prepare($requete);
$req->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
$req->bindValue(':promo_categorie', $promo_categorie, PDO::PARAM_INT);
$req -> execute();
// mise a jour des produits appartenant à la catégorie choisie.
$requete = "UPDATE produits SET promo_produit = :promo_categorie WHERE id_cat = :id_cat";
$req = $bdd->prepare($requete);
$req->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
$req->bindValue(':promo_categorie', $promo_categorie, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM categories WHERE id_cat = :id_cat";
$req = $bdd->prepare($requete);
$req->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>