<?php
$user = 'root';
$pass = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=qualis_arma',$user,$pass); // concerne la base
}
catch(PDOException $e) {
    die('Erreur : '.$e->getMessage());
}

$ortie = 'pas ok';
if (isset($_POST['quantite_produit'],
          $_POST['id_panier'],
          $_POST['id_produit'], 
          $_POST['prix_unitaire']
          )
&& $_POST['quantite_produit'] != NULL
&& $_POST['id_panier'] != NULL
&& $_POST['id_produit'] != NULL
&& $_POST['prix_unitaire'] != NULL
){
    $quantite_produit = intval($_POST['quantite_produit']);
    $id_commande = intval($_POST['id_panier']);
    $id_produit = intval($_POST['id_produit']);
    $prix_unitaire = htmlspecialchars($_POST['prix_unitaire']);
    
    if (isset($_POST['identifiant_client']) && $_POST['identifiant_client'] != NULL) {
        $identifiant_client = intval($_POST['identifiant_client']);
        // si co
        $requete = "SELECT * FROM utilisateurs 
                    WHERE identifiant_client = :identifiant_client";
        $req = $bdd->prepare($requete);
        $req->bindValue(':identifiant_client', $identifiant_client, PDO::PARAM_INT);
        $req -> execute();

        $id_client_fetch = $req -> fetch();
        $id_client = $id_client_fetch['id_user']; 
    }
    else {
        $id_client = NULL; 
    }
    

    if ($quantite_produit != 0) { 

        // test si produit existe deja dans le panier
        $requete = "SELECT quantite_produit FROM paniers_location 
                    WHERE id_location = :id_commande AND id_produit = :id_produit";
        $req3 = $bdd->prepare($requete);
        $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
        $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
        $req3 -> execute();
        $test = $req3 -> fetch();
    
        if (isset($test) && $test != NULL) {
    
            $requete = "UPDATE paniers_location SET `quantite_produit`= :quantite_produit 
                        WHERE id_location = :id_commande AND id_produit = :id_produit";
            $req3 = $bdd->prepare($requete);
            $req3->bindValue(':quantite_produit', $quantite_produit, PDO::PARAM_STR);
            $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
            $req3 -> execute();

            
        }
        else {
            // INSERT
            $requete = "INSERT INTO `paniers_location`(`id_panier_loc`,`id_location`, `quantite_produit`, `prix_unitaire`,  `id_user`, `id_produit`) 
                        VALUES (0,:id_commande,:quantite_produit,:prix_unitaire,:id_client,:id_produit)
                        ";
            $req3 = $bdd->prepare($requete);
            $req3->bindValue(':quantite_produit', $quantite_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
            $req3->bindValue(':id_client', $id_client, PDO::PARAM_STR);
            $req3->bindValue(':prix_unitaire', $prix_unitaire, PDO::PARAM_STR);
            $req3 -> execute();

        }
    }

}

?>