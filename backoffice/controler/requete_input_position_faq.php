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
if (isset($_POST['position_faq'],
          $_POST['id_faq']) 
          && $_POST['position_faq'] != NULL
          && $_POST['id_faq'] != NULL
    ) {
    $position_faq = intval($_POST['position_faq']);
    $id_faq = intval($_POST['id_faq']);
}
else {
    $position_faq = 0;
    $id_faq = 0;
}

// // cherche l'atelier'
$requete = "SELECT * FROM faq WHERE id_faq = :id_faq1";
$req = $bdd->prepare($requete);
$req -> bindValue(':id_faq1', $id_faq, PDO::PARAM_INT);
$req -> execute();
$image = $req -> fetch();

//cherche si position deja affecter pour l'atelier'
$requete = "SELECT * FROM faq 
            WHERE  position_faq = :position_faq ";
$req = $bdd->prepare($requete);
$req->bindValue(':position_faq', $position_faq, PDO::PARAM_INT);
$req -> execute();

$double = $req -> fetch();
$test = $req -> rowCount();

if ($test != 0) {
    // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
    $requete = "UPDATE `faq`
                SET position_faq = :position_faq
                WHERE id_faq = :id_faq2
                    "; 
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_faq2', $double['id_faq'], PDO::PARAM_INT);
    $req->bindValue(':position_faq', $image['position_faq'], PDO::PARAM_INT);
    $req -> execute();
}

// met la nouvelle position à l'image 1
$requete = "UPDATE `faq`
            SET position_faq = :position_faq
            WHERE id_faq = :id_faq
                "; 
$req4 = $bdd->prepare($requete);
$req4->bindValue(':id_faq', $id_faq, PDO::PARAM_INT);
$req4->bindValue(':position_faq', $position_faq, PDO::PARAM_INT);
$req4 -> execute();
?>