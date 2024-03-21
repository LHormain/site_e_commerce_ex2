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
if (isset($_POST['id_devis'],$_POST['id_etat']) 
          && $_POST['id_devis'] != NULL
          && $_POST['id_etat'] != NULL
    ) {
    $id_devis = intval($_POST['id_devis']);
    $id_etat = intval($_POST['id_etat']);
}
// update de l'état du devis
$requete = "UPDATE `devis_evenementiel` SET id_etat = :id_etat WHERE id_devis = :id_devis";
$req = $bdd->prepare($requete);
$req->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
$req->bindValue(':id_etat', $id_etat, PDO::PARAM_INT);
$req -> execute();

// si etat > 1 passe le panier location dans la table commande location
if ($id_etat > 1) {
    // récupère id_location
    $requete = "SELECT * FROM devis_evenementiel WHERE id_devis = :id_devis";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
    $req -> execute();
    $id_location = $req -> fetch();

    // enregistre le panier en commande
    $requete = "INSERT INTO commandes_location (SELECT * FROM paniers_location WHERE id_location = :id_location)";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_location', $id_location['id_location'], PDO::PARAM_INT);
    $req -> execute();

    // efface le panier pour que le client puisse en faire un nouveau
    $requete = "DELETE FROM paniers_location WHERE id_location = :id_location";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_location', $id_location['id_location'], PDO::PARAM_INT);
    $req -> execute();
}

// récupère les données pour le select
$requete = "SELECT * FROM etat_devis";
$req = $bdd->prepare($requete);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>