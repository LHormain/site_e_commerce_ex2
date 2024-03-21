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
if (isset($_POST['id_etat_livraison'], $_POST['id_commande']) 
&& $_POST['id_etat_livraison'] != NULL
&& $_POST['id_commande'] != NULL
) {
    $id_etat_livraison = intval($_POST['id_etat_livraison']);
    $id_commande = intval($_POST['id_commande']);
}
else {
    $id_etat_livraison = 1;
    $id_commande = 1;
}
// mise à jour de l'etat de livraison 
$requete = "UPDATE `factures` SET `id_etat_livraison`= :id_etat_livraison
            WHERE `id_commande`= :id_commande"; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_etat_livraison', $id_etat_livraison, PDO::PARAM_INT);
$req4->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
$req4 -> execute();



?>