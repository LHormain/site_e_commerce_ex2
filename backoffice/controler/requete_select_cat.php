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
if (isset($_POST['section']) && $_POST['section'] != NULL) {
    $section = intval($_POST['section']);
}
else {
    $section = 1;
}
// recuperation de cat dans la bdd 
$requete = "SELECT * FROM categories 
            WHERE id_section = :section 
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':section', $section, PDO::PARAM_INT);
$req4 -> execute();
$tableau_donnees = json_encode($req4->fetchAll());
echo $tableau_donnees;
?>