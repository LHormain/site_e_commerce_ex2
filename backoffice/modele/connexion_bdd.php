<?php 
// Connexion à la base de donné //

$user = 'root';
$pass = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=qualis_arma',$user,$pass); // concerne la base
}
catch(PDOException $e) {
    die('Erreur : '.$e->getMessage());
}
?>