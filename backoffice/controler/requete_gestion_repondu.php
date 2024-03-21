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
if (isset($_POST['repondu_message'],
          $_POST['id_contact']) 
          && $_POST['repondu_message'] != NULL
          && $_POST['id_contact'] != NULL
    ) {
    $repondu_message = intval($_POST['repondu_message']);
    $id_contact = intval($_POST['id_contact']);

    if ($repondu_message == 1) {
        $repondu_message = 0;
    }
    else {
        $repondu_message = 1;
    }
}
else {
    $repondu_message = 0;
    $id_contact = 0;
}
// recuperation de sous cat dans la bdd 
$requete = "UPDATE `contacts` SET repondu_contact = :repondu_message WHERE id_contact = :id_contact";
$req = $bdd->prepare($requete);
$req->bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
$req->bindValue(':repondu_message', $repondu_message, PDO::PARAM_INT);
$req -> execute();

$requete = "SELECT * FROM contacts WHERE id_contact = :id_contact";
$req = $bdd->prepare($requete);
$req->bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
$req -> execute();

$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
?>