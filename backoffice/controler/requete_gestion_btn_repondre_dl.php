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
if (isset($_POST['id_devis']) 
          && $_POST['id_devis'] != NULL
    ) {
    $id_devis = intval($_POST['id_devis']);
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `devis_livraisons` SET repondu_devis = 1 WHERE id_livraison = :id_devis";
$req = $bdd->prepare($requete);
$req->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM devis_livraisons
            INNER JOIN commandes ON commandes.id_commande = devis_livraisons.id_commande
            INNER JOIN utilisateurs ON commandes.id_user = utilisateurs.id_user
            WHERE devis_livraisons.id_livraison = :id_devis";
$req = $bdd->prepare($requete);
$req->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>