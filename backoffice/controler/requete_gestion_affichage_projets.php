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
if (isset($_POST['afficher_projet'],
          $_POST['id_projet']) 
          && $_POST['afficher_projet'] != NULL
          && $_POST['id_projet'] != NULL
    ) {
    $afficher_projet = intval($_POST['afficher_projet']);
    $id_projet = intval($_POST['id_projet']);

    if ($afficher_projet == 1) {
        $afficher_projet = 0;
    }
    else {
        $afficher_projet = 1;
    }
}
else {
    $afficher_projet = 0;
    $id_projet = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `projets_sur_mesure` SET afficher_projet = :afficher_projet WHERE id_projet = :id_projet";
$req = $bdd->prepare($requete);
$req->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
$req->bindValue(':afficher_projet', $afficher_projet, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM projets_sur_mesure WHERE id_projet = :id_projet";
$req = $bdd->prepare($requete);
$req->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>