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
if (isset($_POST['afficher_partenaire'],
          $_POST['id_partenaire']) 
          && $_POST['afficher_partenaire'] != NULL
          && $_POST['id_partenaire'] != NULL
    ) {
    $afficher_partenaire = intval($_POST['afficher_partenaire']);
    $id_partenaire = intval($_POST['id_partenaire']);

    if ($afficher_partenaire == 1) {
        $afficher_partenaire = 0;
    }
    else {
        $afficher_partenaire = 1;
    }
}
else {
    $afficher_partenaire = 0;
    $id_partenaire = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `partenaires` SET afficher_partenaire = :afficher_partenaire WHERE id_partenaire = :id_partenaire";
$req = $bdd->prepare($requete);
$req->bindValue(':id_partenaire', $id_partenaire, PDO::PARAM_INT);
$req->bindValue(':afficher_partenaire', $afficher_partenaire, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM partenaires WHERE id_partenaire = :id_partenaire";
$req = $bdd->prepare($requete);
$req->bindValue(':id_partenaire', $id_partenaire, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>