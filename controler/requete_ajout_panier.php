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
    // recuperation couleur produit
    if (isset($_POST['id_couleur']) && $_POST['id_couleur'] != NULL) {
        $id_couleur = intval($_POST['id_couleur']);
    }
    else {
        $id_couleur = NULL;
    }

    // recuperation matiere produit
    if (isset($_POST['id_matiere']) && $_POST['id_matiere'] != NULL) {
        $id_matiere = intval($_POST['id_matiere']);
    }
    else {
        $id_matiere = NULL;
    }
    // recuperation taille produit
    if (isset($_POST['id_taille']) && $_POST['id_taille'] != NULL) {
        $id_taille = intval($_POST['id_taille']);
    }
    else {
        $id_taille = NULL;
    }
    // récupération autres tailles produit
    if (isset($_POST['id_autre_taille']) && $_POST['id_autre_taille'] != NULL ) {
        $id_autre_taille = intval($_POST['id_autre_taille']);
    }
    else {
        $id_autre_taille = NULL;
    }
    if (isset($_POST['autres_tailles_choix']) && $_POST['autres_tailles_choix'] != NULL) {
        $autres_tailles_choix = intval($_POST['autres_tailles_choix']);
    }
    else {
        $autres_tailles_choix = 0;
    }
    // récupération des autres customization produit
    if (isset($_POST['id_custom']) && $_POST['id_custom'] != NULL) {
        $id_custom = intval($_POST['id_custom']);
    }
    else {
        $id_custom = NULL;
    }

    if ($quantite_produit != 0) { 

        // test si produit existe deja dans le panier
        $requete = "SELECT quantite_produit FROM paniers 
                    WHERE id_commande = :id_commande AND id_produit = :id_produit";
        $req3 = $bdd->prepare($requete);
        $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
        $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
        $req3 -> execute();
        $test = $req3 -> fetch();
    
        if (isset($test) && $test != NULL) {
            // UPDATE 
    
            $requete = "UPDATE paniers 
                        SET `quantite_produit`= :quantite_produit,
                            `prix_unitaire`=:prix_unitaire,
                            `autres_tailles_choix`=:autres_tailles_choix, 
                            `id_autre_taille`=:id_autre_taille,
                            `id_taille`=:id_taille,
                            `id_custom`=:id_custom,
                            `id_couleur`=:id_couleur,
                            `id_matiere`=:id_matiere
                        WHERE id_commande = :id_commande AND id_produit = :id_produit";
            $req3 = $bdd->prepare($requete);
            $req3->bindValue(':quantite_produit', $quantite_produit, PDO::PARAM_STR);
            $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
            $req3->bindValue(':prix_unitaire', $prix_unitaire, PDO::PARAM_STR);
            $req3->bindValue(':autres_tailles_choix', $autres_tailles_choix, PDO::PARAM_STR);
            $req3->bindValue(':id_autre_taille', $id_autre_taille, PDO::PARAM_STR);
            $req3->bindValue(':id_taille', $id_taille, PDO::PARAM_STR);
            $req3->bindValue(':id_custom', $id_custom, PDO::PARAM_STR);
            $req3->bindValue(':id_couleur', $id_couleur, PDO::PARAM_STR);
            $req3->bindValue(':id_matiere', $id_matiere, PDO::PARAM_STR);
            $req3 -> execute();

            $sortie = "ok".$_POST['id_autre_taille'];
            
        }
        else {
            // INSERT
            $requete = "INSERT INTO `paniers`(`id_panier`, 
                                            `quantite_produit`, 
                                            `prix_unitaire`, 
                                            `autres_tailles_choix`, 
                                            `id_commande`, 
                                            `id_user`, 
                                            `id_produit`, 
                                            `id_autre_taille`, 
                                            `id_taille`, 
                                            `id_custom`, 
                                            `id_couleur`, 
                                            `id_matiere`)
                        VALUES (0,
                                :quantite_produit,
                                :prix_unitaire,
                                :autres_tailles_choix,
                                :id_commande,
                                :id_client,
                                :id_produit,
                                :id_autre_taille,
                                :id_taille,
                                :id_custom,
                                :id_couleur,
                                :id_matiere
                                )
                        ";
            $req3 = $bdd->prepare($requete);
            $req3->bindValue(':quantite_produit', $quantite_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
            $req3->bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
            $req3->bindValue(':id_client', $id_client, PDO::PARAM_STR);
            $req3->bindValue(':prix_unitaire', $prix_unitaire, PDO::PARAM_STR);
            $req3->bindValue(':autres_tailles_choix', $autres_tailles_choix, PDO::PARAM_STR);
            $req3->bindValue(':id_autre_taille', $id_autre_taille, PDO::PARAM_STR);
            $req3->bindValue(':id_taille', $id_taille, PDO::PARAM_STR);
            $req3->bindValue(':id_custom', $id_custom, PDO::PARAM_STR);
            $req3->bindValue(':id_couleur', $id_couleur, PDO::PARAM_STR);
            $req3->bindValue(':id_matiere', $id_matiere, PDO::PARAM_STR);
            $req3 -> execute();

            $sortie = "ok".$id_client;
        }
    }

    echo $sortie;
}

?>