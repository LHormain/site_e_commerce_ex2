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
if (isset($_POST['afficher_atelier'],
          $_POST['id_atelier']) 
          && $_POST['afficher_atelier'] != NULL
          && $_POST['id_atelier'] != NULL
    ) {
    $afficher_atelier = intval($_POST['afficher_atelier']);
    $id_atelier = intval($_POST['id_atelier']);

    if ($afficher_atelier == 1) {
        $afficher_atelier = 0;
    }
    else {
        $afficher_atelier = 1;
    }
}
else {
    $afficher_atelier = 0;
    $id_atelier = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `team_building` SET afficher_tb = :afficher_atelier WHERE id_tb = :id_atelier";
$req = $bdd->prepare($requete);
$req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
$req->bindValue(':afficher_atelier', $afficher_atelier, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM team_building WHERE id_tb = :id_atelier";
$req = $bdd->prepare($requete);
$req->bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>