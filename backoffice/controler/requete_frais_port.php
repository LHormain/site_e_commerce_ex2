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
if (isset($_POST['poids'],
          $_POST['zone'],
          $_POST['valeur']
          ) 
          && $_POST['poids'] != NULL
          && $_POST['zone'] != NULL
          && $_POST['valeur'] != NULL
    ) {
    $poids = intval($_POST['poids']);
    $zone = intval($_POST['zone']);
    $valeur = intval($_POST['valeur']);
}

// recuperation de sous cat dans la bdd 
$requete = "UPDATE `tarifs_livraison`
            SET prix = :valeur
            WHERE poids_max = :poids AND zone_destination = :zone_destination
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':valeur', $valeur, PDO::PARAM_INT);
$req4->bindValue(':poids', $poids, PDO::PARAM_INT);
$req4->bindValue(':zone_destination', $zone, PDO::PARAM_INT);
$req4 -> execute();
?>