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
if (isset($_POST['position_tb_txt'],
          $_POST['id_tb_txt']) 
          && $_POST['position_tb_txt'] != NULL
          && $_POST['id_tb_txt'] != NULL
    ) {
    $position_tb_txt = intval($_POST['position_tb_txt']);
    $id_tb_txt = intval($_POST['id_tb_txt']);
}
else {
    $position_tb_txt = 0;
    $id_tb_txt = 0;
}

// // cherche le paragraphe
$requete = "SELECT * FROM team_building_textes WHERE id_tb_txt = :id_tb_txt1";
$req = $bdd->prepare($requete);
$req -> bindValue(':id_tb_txt1', $id_tb_txt, PDO::PARAM_INT);
$req -> execute();
$image = $req -> fetch();

//cherche si position deja affecter 
$requete = "SELECT * FROM team_building_textes 
            WHERE  position_tb_txt = :position_tb_txt ";
$req = $bdd->prepare($requete);
$req->bindValue(':position_tb_txt', $position_tb_txt, PDO::PARAM_INT);
$req -> execute();

$double = $req -> fetch();
$test = $req -> rowCount();

if ($test != 0) {
    // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
    $requete = "UPDATE `team_building_textes`
                SET position_tb_txt = :position_tb_txt
                WHERE id_tb_txt = :id_tb_txt2
                    "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_tb_txt2', $double['id_tb_txt'], PDO::PARAM_INT);
    $req->bindValue(':position_tb_txt', $image['position_tb_txt'], PDO::PARAM_INT);
    $req -> execute();
}

// met la nouvelle position à l'image 1
$requete = "UPDATE `team_building_textes`
            SET position_tb_txt = :position_tb_txt
            WHERE id_tb_txt = :id_tb_txt
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_tb_txt', $id_tb_txt, PDO::PARAM_INT);
$req4->bindValue(':position_tb_txt', $position_tb_txt, PDO::PARAM_INT);
$req4 -> execute();
?>