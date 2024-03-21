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
if (isset($_POST['afficher_tb_txt'],
          $_POST['id_tb_txt']) 
          && $_POST['afficher_tb_txt'] != NULL
          && $_POST['id_tb_txt'] != NULL
    ) {
    $afficher_tb_txt = intval($_POST['afficher_tb_txt']);
    $id_tb_txt = intval($_POST['id_tb_txt']);

    if ($afficher_tb_txt == 1) {
        $afficher_tb_txt = 0;
    }
    else {
        $afficher_tb_txt = 1;
    }
}
else {
    $afficher_tb_txt = 0;
    $id_tb_txt = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `team_building_textes` SET afficher_tb_txt = :afficher_tb_txt WHERE id_tb_txt = :id_tb_txt";
$req = $bdd->prepare($requete);
$req->bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
$req->bindValue(':afficher_tb_txt', $afficher_tb_txt, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM team_building_textes WHERE id_tb_txt = :id_tb_txt";
$req = $bdd->prepare($requete);
$req->bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>