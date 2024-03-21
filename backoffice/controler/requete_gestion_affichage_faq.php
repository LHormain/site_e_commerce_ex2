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
if (isset($_POST['afficher_faq'],
          $_POST['id_faq']) 
          && $_POST['afficher_faq'] != NULL
          && $_POST['id_faq'] != NULL
    ) {
    $afficher_faq = intval($_POST['afficher_faq']);
    $id_faq = intval($_POST['id_faq']);

    if ($afficher_faq == 1) {
        $afficher_faq = 0;
    }
    else {
        $afficher_faq = 1;
    }
}
else {
    $afficher_faq = 0;
    $id_faq = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `faq` SET afficher_faq = :afficher_faq WHERE id_faq = :id_faq";
$req = $bdd->prepare($requete);
$req->bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
$req->bindValue(':afficher_faq', $afficher_faq, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM faq WHERE id_faq = :id_faq";
$req = $bdd->prepare($requete);
$req->bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>