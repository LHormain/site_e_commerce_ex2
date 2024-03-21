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
if (isset($_POST['ordre_affichage'],
          $_POST['id_custom'],
          $_POST['table']) 
          && $_POST['ordre_affichage'] != NULL
          && $_POST['id_custom'] != NULL
          && $_POST['table'] != NULL
    ) {
    $ordre_affichage = intval($_POST['ordre_affichage']);
    $id_custom = intval($_POST['id_custom']);
    $table = htmlspecialchars($_POST['table']);
}
else {
    $ordre_affichage = 0;
    $id_custom = 0;
    $table = 0;
}

// 
    if ($table == 'couleurs') {
        // cherche la customisation
        $requete = "SELECT * FROM couleurs WHERE id_couleur = :id_custom";
        $req = $bdd->prepare($requete);
        $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
        $req -> execute();
        $image = $req -> fetch();

        //cherche si position deja affecter pour le produit
        $requete = 'SELECT * FROM couleurs 
        WHERE  ordre_affichage = :ordre_affichage';
        $req = $bdd->prepare($requete);
        $req->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req -> execute();

        $double = $req -> fetch();
        $test = $req -> rowCount();

        if ($test != 0) {
        // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
        $requete = "UPDATE `couleurs`
            SET ordre_affichage = :ordre_affichage
            WHERE id_couleur = :id_couleur2
                "; 
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_couleur2', $double['id_couleur'], PDO::PARAM_INT);
        $req->bindValue(':ordre_affichage', $image['ordre_affichage'], PDO::PARAM_INT);
        $req -> execute();
        }

        // met la nouvelle position à l'image 1
        $requete = "UPDATE `couleurs`
        SET ordre_affichage = :ordre_affichage
        WHERE id_couleur = :id_couleur
            "; 
        $req4 = $bdd->prepare($requete);
        $req4->bindValue(':id_couleur', $id_custom, PDO::PARAM_INT);
        $req4->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req4 -> execute();
    }
    elseif ($table == 'matieres') {
        $requete = "SELECT * FROM matieres WHERE id_matiere = :id_custom";
        $req = $bdd->prepare($requete);
        $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
        $req -> execute();
        $image = $req -> fetch();

        //cherche si position deja affecter pour le produit
        $requete = 'SELECT * FROM matieres 
        WHERE  ordre_affichage = :ordre_affichage';
        $req = $bdd->prepare($requete);
        $req->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req -> execute();

        $double = $req -> fetch();
        $test = $req -> rowCount();

        if ($test != 0) {
        // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
        $requete = "UPDATE `matieres`
            SET ordre_affichage = :ordre_affichage
            WHERE id_matiere = :id_matiere2
                "; 
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_matiere2', $double['id_matiere'], PDO::PARAM_INT);
        $req->bindValue(':ordre_affichage', $image['ordre_affichage'], PDO::PARAM_INT);
        $req -> execute();
        }

        // met la nouvelle position à l'image 1
        $requete = "UPDATE `matieres`
        SET ordre_affichage = :ordre_affichage
        WHERE id_matiere = :id_matiere
            "; 
        $req4 = $bdd->prepare($requete);
        $req4->bindValue(':id_matiere', $id_custom, PDO::PARAM_INT);
        $req4->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req4 -> execute();
    }
    elseif ($table == 'tailles') {
        $requete = "SELECT * FROM tailles WHERE id_taille = :id_custom";
        $req = $bdd->prepare($requete);
        $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
        $req -> execute();
        $image = $req -> fetch();

        //cherche si position deja affecter pour le produit
        $requete = 'SELECT * FROM tailles 
        WHERE  ordre_affichage = :ordre_affichage';
        $req = $bdd->prepare($requete);
        $req->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req -> execute();

        $double = $req -> fetch();
        $test = $req -> rowCount();

        if ($test != 0) {
        // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
        $requete = "UPDATE `tailles`
            SET ordre_affichage = :ordre_affichage
            WHERE id_taille = :id_taille2
                "; 
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_taille2', $double['id_taille'], PDO::PARAM_INT);
        $req->bindValue(':ordre_affichage', $image['ordre_affichage'], PDO::PARAM_INT);
        $req -> execute();
        }

        // met la nouvelle position à l'image 1
        $requete = "UPDATE `tailles`
        SET ordre_affichage = :ordre_affichage
        WHERE id_taille = :id_taille
            "; 
        $req4 = $bdd->prepare($requete);
        $req4->bindValue(':id_taille', $id_custom, PDO::PARAM_INT);
        $req4->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req4 -> execute();
    }
    elseif ($table == 'customisations') {
        $requete = "SELECT * FROM customisations WHERE id_custom = :id_custom";
        $req = $bdd->prepare($requete);
        $req -> bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
        $req -> execute();
        $image = $req -> fetch();

        //cherche si position deja affecter pour le produit
        $requete = 'SELECT * FROM customisations 
        WHERE  ordre_affichage = :ordre_affichage';
        $req = $bdd->prepare($requete);
        $req->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req -> execute();

        $double = $req -> fetch();
        $test = $req -> rowCount();

        if ($test != 0) {
        // si la position est deja prise affecte l'ancienne position de l'image 1 à l'image trouvé
        $requete = "UPDATE `customisations`
            SET ordre_affichage = :ordre_affichage
            WHERE id_custom = :id_custom2
                "; 
        $req = $bdd->prepare($requete);
        $req->bindValue(':id_custom2', $double['id_custom'], PDO::PARAM_INT);
        $req->bindValue(':ordre_affichage', $image['ordre_affichage'], PDO::PARAM_INT);
        $req -> execute();
        }

        // met la nouvelle position à l'image 1
        $requete = "UPDATE `customisations`
        SET ordre_affichage = :ordre_affichage
        WHERE id_custom = :id_custom
            "; 
        $req4 = $bdd->prepare($requete);
        $req4->bindValue(':id_custom', $id_custom, PDO::PARAM_INT);
        $req4->bindValue(':ordre_affichage', $ordre_affichage, PDO::PARAM_INT);
        $req4 -> execute();
    }


?>