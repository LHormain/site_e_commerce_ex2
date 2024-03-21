<?php
include('modele/connexion_bdd.php');

$pwd = $_POST['pwd'];
$mailuser = htmlspecialchars($_POST['usermail']);

$requete = "SELECT * FROM utilisateurs WHERE mail_utilisateur = :mail AND id_cat_utilisateur = 1";
$req = $bdd->prepare($requete);
$req -> bindValue(':mail', $mailuser, PDO::PARAM_STR);
$req -> execute();

$user = $req -> fetch();
$compte = $req -> rowCount();

$requete = "SELECT * FROM administrateurs WHERE mail_admin = :mail AND id_cat_utilisateur = 3";
$req = $bdd->prepare($requete);
$req -> bindValue(':mail', $mailuser, PDO::PARAM_STR);
$req -> execute();

$user2 = $req -> fetch();
$compte2 = $req -> rowCount();

if ( $compte != 0) {

    if (password_verify($pwd, $user['mdp_utilisateur'])) {
        $_SESSION['connexion'] = 1;
        header("location:index.php");
    }
    else {
        // le mot de passe est faux
        header("location:index.php?page=1");
    }
}
elseif ($compte2 != 0) {
    if (password_verify($pwd, $user2['mdp_admin'])) {
        $_SESSION['connexion'] = 2;
        header("location:index.php");
    }
    else {
        // le mot de passe est faux
        header("location:index.php?page=1");
    }
}
else {
    header("location:index.php");
}

?>