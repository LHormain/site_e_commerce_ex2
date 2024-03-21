<?php
$user = 'root';
$pass = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=qualis_arma',$user,$pass); // concerne la base
}
catch(PDOException $e) {
    die('Erreur : '.$e->getMessage());
}

if (isset($_POST['id_devis'], 
          $_POST['id_etat'])
    && $_POST['id_devis'] != NULL
    && $_POST['id_etat'] != NULL
) {
    $id_devis = intval($_POST['id_devis']);
    $id_etat = intval($_POST['id_etat']);

    $requete = "UPDATE devis_sur_mesure SET id_etat = :id_etat WHERE id_devis_sm = :id_devis";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_etat', $id_etat, PDO::PARAM_INT);
    $req->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
    $req -> execute();


$tableau_donnees = json_encode($req->fetchAll());
echo $tableau_donnees;
}

?>