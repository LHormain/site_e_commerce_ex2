<?php
$user = 'root';
$pass = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=qualis_arma',$user,$pass); // concerne la base
}
catch(PDOException $e) {
    die('Erreur : '.$e->getMessage());
}

if (isset($_POST['id_produit'],
         $_POST['identifiant_client'])
&& $_POST['id_produit'] != NULL
&& $_POST['identifiant_client'] != NULL
){
    $id_produit = intval($_POST['id_produit']);
    $identifiant_client = intval($_POST['identifiant_client']);

    // récupère le client
    $requete = "SELECT id_user FROM utilisateurs WHERE identifiant_client = :identifiant_client";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':identifiant_client', $identifiant_client, PDO::PARAM_INT);
    $req -> execute();
    
    $id_client = $req -> fetch();

    // vérifie si deja dans favoris
    $requete = "SELECT * FROM favoris WHERE id_produit = :id_produit AND id_user = :id_client";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_client', $id_client['id_user'], PDO::PARAM_INT);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $si_fav = $req -> rowCount();

    if ($si_fav == 0) {
        // ajoute dans favoris
        $requete = "INSERT INTO favoris VALUES (:id_produit, :id_client)";
        $req = $bdd -> prepare($requete);
        $req -> bindValue(':id_client', $id_client['id_user'], PDO::PARAM_INT);
        $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
        $req -> execute();
        $sortie = 'add';
    }
    else {
        // enlève des favoris
        $requete = "DELETE FROM favoris WHERE id_user = :id_client AND id_produit = :id_produit";
        $req = $bdd -> prepare($requete);
        $req -> bindValue(':id_client', $id_client['id_user'], PDO::PARAM_INT);
        $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
        $req -> execute();
        $sortie = 'sup';
    }

    echo $sortie;
}

?>