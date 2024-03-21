<?php
//  remplace image par logo si image n'existe pas
function image_par_default($chemin, $nom_img) {
    if ($nom_img == '' ) {
        $chemin_img = 'public/assets/img/logo/qualisarmalogo2.png';
    }
    else {
        $chemin_img = $chemin.$nom_img;
    }
    
    return $chemin_img;
}

// -----------------------------------------------------------------------
//                             clients
// -----------------------------------------------------------------------
// récupération d'un client avec son identifiant de session
function req_id_client($bdd) {
    $donnees = '';
    if (isset($_SESSION['id_client'])) {
        $requete = "SELECT * FROM utilisateurs 
                    WHERE identifiant_client = :identifiant_client";
        $req = $bdd->prepare($requete);
        $req->bindValue(':identifiant_client', $_SESSION['id_client'], PDO::PARAM_INT);
        $req -> execute();
        $donnees = $req -> fetch();
    }
    return $donnees;
}
// récupération d'une adresse
function req_adresse_client($bdd, $id_adresse) {

    $requete = 'SELECT * FROM adresses_utilisateurs
                WHERE id_adresse = :id_adresse ';
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_adresse', $id_adresse, PDO::PARAM_INT);
    $req -> execute();
    $donnees = $req -> fetch();

    return $donnees;
}
// récupération de toutes ses adresses
function req_adresses_client($bdd,$id_user, $cas) {
    if ($cas == 1) {
        //facturation
        $where = ' adresses_utilisateurs.facturation_adresse = 1';
    }
    elseif ($cas == 2) {
        // livraison
        $where = 'adresses_utilisateurs.livraison_adresse = 1';
    }

    $requete = 'SELECT * FROM adresses_utilisateurs
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE adresses_utilisateurs.id_user = :id_user AND '.$where;
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();
    $donnees = $req -> fetchAll();

    return $donnees;
}
// récupération d'un client avec son mail
function req_mail($bdd,$username) {
    $requete = "SELECT * FROM utilisateurs 
                WHERE mail_utilisateur = :username"; 
    $req = $bdd->prepare($requete);
    $req -> bindValue(':username', $username, PDO::PARAM_STR);
    $req -> execute();

    $user = $req -> fetch();
    $compte = $req -> rowCount(); 
    $donnees = [$user,$compte];
    return $donnees;
}
// récupération de la liste des pays
function req_pays($bdd) {
    $requete = "SELECT * FROM pays
                ORDER BY nom_fr_fr";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $donnees = $req -> fetchAll();
    return $donnees;
}
// inscription nouveau client
function req_inscription_utilisateur($bdd,$identifiant_client,$nom_utilisateur,$prenom_utilisateur,$mail_utilisateur,$tel_utilisateur,$mdp_hash,$adresse_facturation,$adresse_livraison,$newsletter) {
    // insert dans utilisateur
    $requete = "INSERT INTO `utilisateurs`(`id_user`, 
                                            `nom_utilisateur`, 
                                            `prenom_utilisateur`, 
                                            `mail_utilisateur`, 
                                            `mdp_utilisateur`, 
                                            `tel_utilisateur`, 
                                            `identifiant_client`, 
                                            `id_cat_utilisateur`,
                                            `newsletter`) 
                VALUES (0,
                :nom_utilisateur,
                :prenom_utilisateur,
                :mail_utilisateur,
                :mdp_hash,
                :tel_utilisateur,
                :identifiant_client,
                2,
                :newsletter)";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':nom_utilisateur', $nom_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':prenom_utilisateur', $prenom_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':mail_utilisateur', $mail_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':mdp_hash', $mdp_hash, PDO::PARAM_STR);
    $req -> bindValue(':tel_utilisateur', $tel_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':identifiant_client', $identifiant_client, PDO::PARAM_INT);
    $req -> bindValue(':newsletter', $newsletter, PDO::PARAM_INT);
    $req -> execute();

    // récupère l'id juste créer
    $requete = "SELECT * FROM utilisateurs
                ORDER BY id_user DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req -> execute();

    $client = $req -> fetch();

    // insère l'adresse de facturation
    $new_adresse_f = req_insert_adresse($bdd, $adresse_facturation, 1, $client['id_user']);
    
    // insère l'adresse de livraison
    $new_adresse_l = req_insert_adresse($bdd, $adresse_livraison, 2, $client['id_user']);
    
    // renvoie l'id créer pour mise à jour des paniers
    $sortie = [$client['id_user'],$new_adresse_f,$new_adresse_l];
    return $sortie;
}
// enregistrement d'une adresse
function req_insert_adresse($bdd, $adresse, $cas, $id_user) {
    if ($cas == 1) {
        // facturation
        $facturation = 1;
        $livraison = 0;
    }
    elseif ($cas == 2) {
        //livraison
        $facturation = 0;
        $livraison = 1;
    }

    $requete = "INSERT INTO `adresses_utilisateurs`(`id_adresse`,
                                                     `rue_adresse`, 
                                                     `ville_adresse`, 
                                                     `code_postal_adresse`, 
                                                     `complement_adresse`, 
                                                     `facturation_adresse`, 
                                                     `livraison_adresse`, 
                                                     `numero_adresse`, 
                                                     `id_user`,
                                                     id_pays) 
                VALUES (0,
                        :rue_adresse,
                        :ville_adresse,
                        :code_postal_adresse,
                        :complement_adresse,
                        $facturation,
                        $livraison,
                        :numero_adresse,
                        :id_user,
                        :id_pays)";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':numero_adresse', $adresse['numero_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':rue_adresse', $adresse['rue_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':complement_adresse', $adresse['complement_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':ville_adresse', $adresse['ville_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':code_postal_adresse', $adresse['code_postal_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':id_pays', $adresse['id_pays'], PDO::PARAM_INT);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    // récupère l'id juste créer
    $requete = "SELECT * FROM adresses_utilisateurs
                ORDER BY id_adresse DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req -> execute();

    $sortie = $req -> fetch();
    return $sortie['id_adresse'];
}
// mise a jour des données personnelles d'un utilisateur
function req_maj_utilisateur($bdd,$nom_utilisateur,$prenom_utilisateur,$mail_utilisateur,$tel_utilisateur,$adresse_facturation,$adresse_livraison,$id_user,$id_facturation,$id_livraison,$newsletter){
    // update utilisateurs
    $requete = "UPDATE `utilisateurs` 
                SET `nom_utilisateur`=:nom_utilisateur,
                    `prenom_utilisateur`=:prenom_utilisateur,
                    `mail_utilisateur`=:mail_utilisateur,
                    `tel_utilisateur`=:tel_utilisateur,
                    newsletter = :newsletter
                    WHERE id_user = :id_user";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':nom_utilisateur', $nom_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':prenom_utilisateur', $prenom_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':mail_utilisateur', $mail_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':tel_utilisateur', $tel_utilisateur, PDO::PARAM_STR);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':newsletter', $newsletter, PDO::PARAM_INT);
    $req -> execute();

    //update facturation
    if ($id_facturation != 0) {
        // update de l'adresse
        req_maj_adresse($bdd,$adresse_facturation,$id_facturation);
    }
    else {
        // ajout d'une nouvelle adresse
        $id_facturation = req_insert_adresse($bdd, $adresse_facturation, 1, $id_user);
    }

    // update livraison
    if ($id_livraison != 0) {
        // update adresse
        req_maj_adresse($bdd,$adresse_livraison,$id_livraison);
    }
    else {
        // ajout d'une nouvelle adresse
        $id_livraison = req_insert_adresse($bdd, $adresse_livraison, 2, $id_user);
    }

    $sortie = [$id_user, $id_facturation, $id_livraison];
    return $sortie;
}
// mise à jour d'une adresse
function req_maj_adresse($bdd,$adresse,$id_adresse) {
    $requete = "UPDATE `adresses_utilisateurs` 
                SET `rue_adresse`=:rue_adresse,
                    `ville_adresse`=:ville_adresse,
                    `code_postal_adresse`=:code_postal_adresse,
                    `id_pays`=:id_pays,
                    `complement_adresse`=:complement_adresse,
                    `numero_adresse`=:numero_adresse 
                WHERE `id_adresse`= :id_adresse";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':numero_adresse', $adresse['numero_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':rue_adresse', $adresse['rue_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':complement_adresse', $adresse['complement_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':ville_adresse', $adresse['ville_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':code_postal_adresse', $adresse['code_postal_adresse'], PDO::PARAM_STR);
    $req -> bindValue(':id_pays', $adresse['id_pays'], PDO::PARAM_INT);
    $req -> bindValue(':id_adresse', $id_adresse, PDO::PARAM_INT);
    $req -> execute();
}
// liste des favoris d'un client
function req_produits_fav($bdd,$id_user,$offset,$nbr_entree_page,$id_section) {
    $requete = 'SELECT * FROM produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                INNER JOIN categories ON categories.id_cat = produits.id_cat
                INNER JOIN favoris on produits.id_produit = favoris.id_produit
                WHERE favoris.id_user = :id_user  AND categories.id_section = :id_section
                GROUP BY produits.id_produit
                LIMIT '.$offset.', '.$nbr_entree_page;
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// nbr de favoris d'un client 
function req_nbr_entre_favoris($bdd,$id_user,$id_section) {
    $requete = "SELECT * from produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                INNER JOIN categories ON categories.id_cat = produits.id_cat
                INNER JOIN favoris on produits.id_produit = favoris.id_produit
                WHERE favoris.id_user = :id_user AND categories.id_section = :id_section
                GROUP BY produits.id_produit
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}

// test si id commande existe dans la table paniers
function test_id_commande($bdd,$id_commande) {
    $requete = "SELECT * FROM paniers
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}
// test si id_location existe dans la table paniers_location
function test_id_location($bdd,$id_location) {
    $requete = "SELECT * FROM paniers_location
                WHERE id_location = :id_location";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_location', $id_location, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}
function test_id_location2($bdd,$id_location) {
    $requete = "SELECT * FROM commandes_location
                WHERE id_location = :id_location";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_location', $id_location, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}

// demande mdp oublier
function req_token($bdd, $expiration_date, $token_hash,$mail) {
    $requete = "UPDATE `utilisateurs` SET `token`=:token_hash,
                                     `date_expiration`=:expiration_date 
                WHERE mail_utilisateur = :mail AND id_cat_utilisateur = 2";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':expiration_date', $expiration_date, PDO::PARAM_INT);
    $req -> bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
    $req -> bindValue(':mail', $mail, PDO::PARAM_STR);
    $req -> execute();

    $nbr = $req -> rowCount();
    return $nbr;
}
// recherche tous les token dans la table utilisateurs
function req_cherche_token($bdd) {
    $requete = "SELECT * FROM utilisateurs 
                WHERE token != 'NULL'";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    
    $liste_token = $req -> fetchAll();
    return $liste_token;
}
//update du mot de passe
function req_update_mdp($bdd,$id_user,$mdp_hash) {
    $requete = "UPDATE utilisateurs 
                SET `mdp_utilisateur`=:mdp_hash, 
                    `token`= NULL,
                    `date_expiration`= NULL
                WHERE  id_user = $id_user";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':mdp_hash', $mdp_hash, PDO::PARAM_STR);
    $req -> execute();
}

//----------------------------
// gestion commande
//----------------------------
// créer une facture vente au format pdf avec la bibliothèque FPDF
function req_facture_v($bdd,$id_commande) {
    require_once('public/assets/fpdf186/fpdf.php');
    // récupéré le numéro de facture la facture généré aura pour numéro le n° précédé de w.
    // ainsi que toute les info nécessaires
    $requete = "SELECT * FROM factures
                INNER JOIN adresses_utilisateurs ON factures.adresse_facturation = adresses_utilisateurs.id_adresse
                INNER JOIN utilisateurs ON utilisateurs.id_user = adresses_utilisateurs.id_user
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE factures.id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande',$id_commande,PDO::PARAM_INT);
    $req -> execute();
    $facture = $req -> fetch();

    $requete = "SELECT * FROM commandes
                INNER JOIN produits ON commandes.id_produit = produits.id_produit
                WHERE commandes.id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande',$id_commande,PDO::PARAM_INT);
    $req -> execute();
    $produits = $req -> fetchAll();

    // créer et enregistrer le fichier
    // création des données
    $nom_facture = 'w'.$facture['id_facture'].'.pdf';
    $titre = 'facture N° w'.$facture['id_facture'];
    $titre = iconv('UTF-8','windows-1252', $titre);
    $date = 'Date: '.date('d/m/Y', time());

    $en_tete1 = 'QUALIS ARMA ';
    $en_tete2 = '58 rue Saint-François';
    $en_tete3 = '57350 Stiring-Wendel';
    $en_tete4 = 'FRANCE';
    $en_tete5 = 'Contact: 06 80 07 32 96 / contact@qualisarma.com';
    $en_tete6 = 'www.qualisarma.com';
    $en_tete7 = 'SARL au capital de 5000€ - N° SIREN: 889472288';
    $en_tete8 = '- RCS SARREGUEMINES 889 472 288 ';
    $en_tete9 = '  N° de gestion 2020B00456';
    $en_tete10 = '- N° de TVA Intracommunautaire: FR32889472288';

    $client1 = 'Client: '.$facture['prenom_utilisateur'].' '.$facture['nom_utilisateur'];
    $adresse1 = 'Adresse: '.$facture['numero_adresse'].' '.$facture['rue_adresse'];
    $adresse2 = $facture['code_postal_adresse'].' '.$facture['ville_adresse'];
    $pays = 'Pays: '.$facture['nom_fr_fr'];
    $tel = 'Tel: '.$facture['tel_utilisateur'];
    $mail = 'Mail: '.$facture['mail_utilisateur'];

    $texte_pied = 'Tout incident de paiement est passible d\'intérêt de retard. Le montant des pénalités résulte de l\'application aux sommes restant dues, d\'un taux d\'intérêt légal en vigueur au moment de l\'incident. Indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement: 40€';
    $texte_pied = iconv('UTF-8','windows-1252',$texte_pied);
    
    // converti les caractères spéciaux
    $en_tete1 = iconv('UTF-8','windows-1252',$en_tete1);
    $en_tete2 = iconv('UTF-8','windows-1252',$en_tete2);
    $en_tete3 = iconv('UTF-8','windows-1252',$en_tete3);
    $en_tete4 = iconv('UTF-8','windows-1252',$en_tete4);
    $en_tete5 = iconv('UTF-8','windows-1252',$en_tete5);
    $en_tete6 = iconv('UTF-8','windows-1252',$en_tete6);
    $en_tete7 = iconv('UTF-8','windows-1252',$en_tete7);
    $en_tete8 = iconv('UTF-8','windows-1252',$en_tete8);
    $en_tete9 = iconv('UTF-8','windows-1252',$en_tete9);
    $en_tete10 = iconv('UTF-8','windows-1252',$en_tete10);

    $client1 = iconv('UTF-8','windows-1252',$client1);
    $adresse1 = iconv('UTF-8','windows-1252',$adresse1);
    $adresse2 = iconv('UTF-8','windows-1252',$adresse2);
    $pays = iconv('UTF-8','windows-1252',$pays);
    $tel = iconv('UTF-8','windows-1252',$tel);
    $mail = iconv('UTF-8','windows-1252',$mail);

    // début écriture
    $pdf = new FPDF();
 
    $pdf -> AddPage();
    $pdf -> SetFont('Times', '',12);
    $pdf -> SetFillColor(179,217,255);
    // début de l'écriture de l'en tête
    $pdf -> Image('public/assets/img/logo/qualisarmalogo4.png',10,10,25,25);
    $pdf -> Cell(95,6, $en_tete1, 'LTR',0, 'R');
    $pdf -> Cell(0,6, $titre,0,1,'R');
    $pdf -> Cell(95,6, $en_tete2, 'LR',0, 'R');
    $pdf -> Cell(0,6, $date,0,1,'R');
    $pdf -> Cell(95,6, $en_tete3, 'LR',1, 'R');
    $pdf -> Cell(95,6, $en_tete4, 'LR',0, 'R');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $client1, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete5, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $adresse1, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete6, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $adresse2, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete7, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $pays, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete8, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $tel, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete9, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $mail, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete10, 'LRB',1, 'L');

    // début de l'écriture du corps du document
    $pdf -> Ln(10);
    $pdf -> Cell(0,6,$titre,0,1,'C',true);
    $pdf -> Ln(10);
    $pdf -> SetFont('Arial','B',12);
    $pdf -> Cell(15,6,iconv('UTF-8','windows-1252','Réf'), 1,0,'C');
    $pdf -> Cell(80,6,iconv('UTF-8','windows-1252','Désignation'), 1,0,'C');
    $pdf -> Cell(15,6,iconv('UTF-8','windows-1252','Qté'), 1,0,'C');
    $pdf -> Cell(20,6,'Prix HT', 1,0,'C');
    $pdf -> Cell(30,6,'Remise HT', 1,0,'C');
    $pdf -> Cell(30,6,'Total net HT', 1,1,'C');

    $pdf -> SetFont('Arial','',12);
    $prix = 0;
    foreach ($produits as $lignes) {
        $pdf -> Cell(15,6,$lignes['id_produit'], 1,0,'C');
        $pdf -> Cell(80,6,iconv('UTF-8','windows-1252',$lignes['nom_produit']), 1,0,'C');
        $pdf -> Cell(15,6,$lignes['quantite_produit'], 1,0,'C');
        $pdf -> Cell(20,6,$lignes['prix_unitaire'], 1,0,'C');
        $pdf -> Cell(30,6,'', 1,0,'C');
        $pdf -> Cell(30,6,number_format($lignes['prix_unitaire']*$lignes['quantite_produit'],2,'.',' '), 1,1,'C');
        $prix += $lignes['prix_unitaire']*$lignes['quantite_produit'];
    }
    $TVA = $prix*(20/100);
    $euro = iconv('UTF-8','windows-1252',' €');
    $frais = $facture['montant_commande']-$prix-$TVA;

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Remise HT',1,0,'C');
    $pdf -> Cell(30,6,'',1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Frais de port HT',1,0,'C');
    $pdf -> Cell(30,6,number_format($frais,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Prix total net HT',1,0,'C');
    $pdf -> Cell(30,6,number_format($prix,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'TVA 20%',1,0,'C');
    $pdf -> Cell(30,6,number_format($TVA,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Prix total TTC',1,0,'C',true);
    $pdf -> Cell(30,6,$facture['montant_commande'].$euro,1,1,'C',true);

    $pdf -> Ln(10);
    $pdf -> Cell(0,6,'Condition et mode de payement: payement en ligne',0,1);

    $pdf -> Cell(0,6,'Titulaire du compte : Qualis Arma',0,1);
    $pdf -> Cell(0,6,'RIB CCM DE FORBACH ET ENVIRONS : 10278  05400  00021412603  16',0,1);
    $pdf -> Cell(0,6,'IBAN : FR7610278054000002141260316',0,1);
    $pdf -> Cell(0,6,'BIC : CMCIFR2A',0,1);

    // texte pied de page
    $pdf -> SetY(-40);
    $pdf -> SetFont('Arial','',10);
    $pdf -> MultiCell(190,6,$texte_pied,0,1);

    // numéro de page en bas de page et fermeture du doc
    $pdf -> SetY(-20.1);
    $pdf -> AliasNbPages();
    $pdf -> Cell(0,0,'Page '.$pdf->PageNo().'/{nb}',0,0,'R');
    $pdf -> Output('F','public/assets/devis/'.$nom_facture);

    // update numero_facture avec le nom du fichier
    $requete = "UPDATE numeros_factures
                SET fichier_facture = :nom
                WHERE id_facture = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id',$facture['id_facture'], PDO::PARAM_INT);
    $req -> bindValue(':nom',$nom_facture, PDO::PARAM_STR);
    $req -> execute();
}
// créer une facture pour les ateliers
function req_facture_a($bdd,$id_user,$id_atelier,$id_date) {
    require_once('public/assets/fpdf186/fpdf.php');
    // récupéré le numéro de facture la facture généré aura pour numéro le n° précédé de w.
    // ainsi que toute les info nécessaires
    $requete = "SELECT * FROM inscriptions
                INNER JOIN utilisateurs ON utilisateurs.id_user = inscriptions.id_user
                INNER JOIN adresses_utilisateurs ON utilisateurs.id_user = adresses_utilisateurs.id_user
                INNER JOIN pays ON pays.id_pays = adresses_utilisateurs.id_pays
                WHERE inscriptions.id_user = :id_user AND inscriptions.id_date = :id_date AND adresses_utilisateurs.facturation_adresse = 1
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user',$id_user,PDO::PARAM_INT);
    $req -> bindValue(':id_date',$id_date,PDO::PARAM_INT);
    $req -> execute();
    $facture = $req -> fetch();

    $requete = "SELECT * FROM ateliers
                WHERE ateliers.id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier',$id_atelier,PDO::PARAM_INT);
    $req -> execute();
    $produits = $req -> fetch();

    // créer et enregistrer le fichier
    // création des données
    $nom_facture = 'w'.$facture['id_facture'].'.pdf';
    $titre = 'facture N° w'.$facture['id_facture'];
    $titre = iconv('UTF-8','windows-1252', $titre);
    $date = 'Date: '.date('d/m/Y', time());

    $en_tete1 = 'QUALIS ARMA ';
    $en_tete2 = '58 rue Saint-François';
    $en_tete3 = '57350 Stiring-Wendel';
    $en_tete4 = 'FRANCE';
    $en_tete5 = 'Contact: 06 80 07 32 96 / contact@qualisarma.com';
    $en_tete6 = 'www.qualisarma.com';
    $en_tete7 = 'SARL au capital de 5000€ - N° SIREN: 889472288';
    $en_tete8 = '- RCS SARREGUEMINES 889 472 288 ';
    $en_tete9 = '  N° de gestion 2020B00456';
    $en_tete10 = '- N° de TVA Intracommunautaire: FR32889472288';

    $client1 = 'Client: '.$facture['prenom_utilisateur'].' '.$facture['nom_utilisateur'];
    $adresse1 = 'Adresse: '.$facture['numero_adresse'].' '.$facture['rue_adresse'];
    $adresse2 = $facture['code_postal_adresse'].' '.$facture['ville_adresse'];
    $pays = 'Pays: '.$facture['nom_fr_fr'];
    $tel = 'Tel: '.$facture['tel_utilisateur'];
    $mail = 'Mail: '.$facture['mail_utilisateur'];

    $texte_pied = 'Tout incident de paiement est passible d\'intérêt de retard. Le montant des pénalités résulte de l\'application aux sommes restant dues, d\'un taux d\'intérêt légal en vigueur au moment de l\'incident. Indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement: 40€';
    $texte_pied = iconv('UTF-8','windows-1252',$texte_pied);
    
    // converti les caractères spéciaux
    $en_tete1 = iconv('UTF-8','windows-1252',$en_tete1);
    $en_tete2 = iconv('UTF-8','windows-1252',$en_tete2);
    $en_tete3 = iconv('UTF-8','windows-1252',$en_tete3);
    $en_tete4 = iconv('UTF-8','windows-1252',$en_tete4);
    $en_tete5 = iconv('UTF-8','windows-1252',$en_tete5);
    $en_tete6 = iconv('UTF-8','windows-1252',$en_tete6);
    $en_tete7 = iconv('UTF-8','windows-1252',$en_tete7);
    $en_tete8 = iconv('UTF-8','windows-1252',$en_tete8);
    $en_tete9 = iconv('UTF-8','windows-1252',$en_tete9);
    $en_tete10 = iconv('UTF-8','windows-1252',$en_tete10);

    $client1 = iconv('UTF-8','windows-1252',$client1);
    $adresse1 = iconv('UTF-8','windows-1252',$adresse1);
    $adresse2 = iconv('UTF-8','windows-1252',$adresse2);
    $pays = iconv('UTF-8','windows-1252',$pays);
    $tel = iconv('UTF-8','windows-1252',$tel);
    $mail = iconv('UTF-8','windows-1252',$mail);

    // début écriture
    $pdf = new FPDF();
 
    $pdf -> AddPage();
    $pdf -> SetFont('Times', '',12);
    $pdf -> SetFillColor(179,217,255);
    // début de l'écriture de l'en tête
    $pdf -> Image('public/assets/img/logo/qualisarmalogo4.png',10,10,25,25);
    $pdf -> Cell(95,6, $en_tete1, 'LTR',0, 'R');
    $pdf -> Cell(0,6, $titre,0,1,'R');
    $pdf -> Cell(95,6, $en_tete2, 'LR',0, 'R');
    $pdf -> Cell(0,6, $date,0,1,'R');
    $pdf -> Cell(95,6, $en_tete3, 'LR',1, 'R');
    $pdf -> Cell(95,6, $en_tete4, 'LR',0, 'R');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $client1, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete5, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $adresse1, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete6, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $adresse2, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete7, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $pays, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete8, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $tel, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete9, 'LR',0, 'L');
    $pdf -> SetX(110);
    $pdf -> Cell(0,6, $mail, 0,1, 'L');
    $pdf -> Cell(95,6, $en_tete10, 'LRB',1, 'L');

    // début de l'écriture du corps du document
    $pdf -> Ln(10);
    $pdf -> Cell(0,6,$titre,0,1,'C',true);
    $pdf -> Ln(10);
    $pdf -> SetFont('Arial','B',12);
    $pdf -> Cell(15,6,iconv('UTF-8','windows-1252','Réf'), 1,0,'C');
    $pdf -> Cell(80,6,iconv('UTF-8','windows-1252','Désignation'), 1,0,'C');
    $pdf -> Cell(15,6,iconv('UTF-8','windows-1252','Qté'), 1,0,'C');
    $pdf -> Cell(20,6,'Prix HT', 1,0,'C');
    $pdf -> Cell(30,6,'Remise HT', 1,0,'C');
    $pdf -> Cell(30,6,'Total net HT', 1,1,'C');

    $pdf -> SetFont('Arial','',12);
    $prix = 0;

        $pdf -> Cell(15,6,$produits['id_atelier'], 1,0,'C');
        $pdf -> Cell(80,6,iconv('UTF-8','windows-1252',$produits['nom_atelier']), 1,0,'C');
        $pdf -> Cell(15,6,$facture['nbr_inscrit'], 1,0,'C');
        $pdf -> Cell(20,6,$produits['tarif_atelier'], 1,0,'C');
        $pdf -> Cell(30,6,'', 1,0,'C');
        $pdf -> Cell(30,6,number_format($produits['tarif_atelier']*$facture['nbr_inscrit'],2,'.',' '), 1,1,'C');
        $prix += $produits['tarif_atelier']*$facture['nbr_inscrit'];

    $TVA = $prix*(20/100);
    $euro = iconv('UTF-8','windows-1252',' €');
    $frais = 0;

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Remise HT',1,0,'C');
    $pdf -> Cell(30,6,'',1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Frais de port HT',1,0,'C');
    $pdf -> Cell(30,6,number_format($frais,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Prix total net HT',1,0,'C');
    $pdf -> Cell(30,6,number_format($prix,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'TVA 20%',1,0,'C');
    $pdf -> Cell(30,6,number_format($TVA,2,'.',' ').$euro,1,1,'C');

    $pdf -> SetX(120);
    $pdf -> Cell(50,6,'Prix total TTC',1,0,'C',true);
    $pdf -> Cell(30,6,number_format($prix+$TVA,2,'.',' ').$euro,1,1,'C',true);

    $pdf -> Ln(10);
    $pdf -> Cell(0,6,'Condition et mode de payement: payement en ligne',0,1);

    $pdf -> Cell(0,6,'Titulaire du compte : Qualis Arma',0,1);
    $pdf -> Cell(0,6,'RIB CCM DE FORBACH ET ENVIRONS : 10278  05400  00021412603  16',0,1);
    $pdf -> Cell(0,6,'IBAN : FR7610278054000002141260316',0,1);
    $pdf -> Cell(0,6,'BIC : CMCIFR2A',0,1);

    // texte pied de page
    $pdf -> SetY(-40);
    $pdf -> SetFont('Arial','',10);
    $pdf -> MultiCell(190,6,$texte_pied,0,1);

    // numéro de page en bas de page et fermeture du doc
    $pdf -> SetY(-20.1);
    $pdf -> AliasNbPages();
    $pdf -> Cell(0,0,'Page '.$pdf->PageNo().'/{nb}',0,0,'R');
    $pdf -> Output('F','public/assets/devis/'.$nom_facture);

    // update numero_facture avec le nom du fichier
    $requete = "UPDATE numeros_factures
                SET fichier_facture = :nom
                WHERE id_facture = :id";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id',$facture['id_facture'], PDO::PARAM_INT);
    $req -> bindValue(':nom',$nom_facture, PDO::PARAM_STR);
    $req -> execute();
}
// enregistre la commande 
function req_save_token($bdd,$id_commande,$jour,$token,$total_TTC,$id_livraison,$id_facturation)  {
    // crée un nouveau numéro de facture
    $requete = "INSERT INTO numeros_factures (`id_facture`)  VALUES (0)";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    // récupère ce numéro
    $requete = "SELECT * FROM numeros_factures
                ORDER BY id_facture DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    $nbr = $req -> fetch();
    // insert 
    $requete = "INSERT INTO `factures` (`id_commande`,
                                        `date_commande`, 
                                        `token`, 
                                        `montant_commande`, 
                                        `id_etat_livraison`, 
                                        `id_etat_commande`, 
                                        `id_facture`, 
                                        `adresse_livraison`, 
                                        `adresse_facturation`)
                VALUES (:id_commande, 
                        :date_commande, 
                        :token_commande,
                        :montant_commande,
                        1,
                        1,
                        :id_facture,
                        :id_livraison,
                        :id_facturation)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande',$id_commande,PDO::PARAM_INT);
    $req -> bindValue(':date_commande',$jour,PDO::PARAM_INT);
    $req -> bindValue(':montant_commande',$total_TTC,PDO::PARAM_STR);
    $req -> bindValue(':token_commande',$token,PDO::PARAM_STR);
    $req -> bindValue(':id_livraison',$id_livraison,PDO::PARAM_INT);
    $req -> bindValue(':id_facturation',$id_facturation,PDO::PARAM_INT);
    $req -> bindValue(':id_facture',$nbr['id_facture'],PDO::PARAM_INT);
    $req -> execute();
}
// met a jour la commande (cas pour payer avec devis livraison)
function req_update_token($bdd,$id_commande,$jour,$token,$prix_payer,$id_livraison,$id_facturation) {
    $requete = "UPDATE factures
                SET date_commande = :date_commande,
                    token = :token_commande,
                    montant_commande = :montant_commande,
                    adresse_livraison = :id_livraison,
                    adresse_facturation = :id_facturation
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande',$id_commande,PDO::PARAM_INT);
    $req -> bindValue(':date_commande',$jour,PDO::PARAM_INT);
    $req -> bindValue(':montant_commande',$prix_payer,PDO::PARAM_STR);
    $req -> bindValue(':token_commande',$token,PDO::PARAM_STR);
    $req -> bindValue(':id_livraison',$id_livraison,PDO::PARAM_INT);
    $req -> bindValue(':id_facturation',$id_facturation,PDO::PARAM_INT);
    $req -> execute();
}
// déplace le panier dans commande
function req_panier_a_commande($bdd,$id_commande) {
    $requete = "INSERT INTO commandes (SELECT * FROM paniers WHERE id_commande = :id_commande)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $requete = "DELETE FROM paniers WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
// enregistrement de demande de devis livraison
function req_save_devis_livraison($bdd,$id_commande){
    $requete = "INSERT INTO `devis_livraisons`(`id_livraison`, 
                                               `prix_livraisons`, 
                                               `lu_devis`, 
                                               `repondu_devis`, 
                                               `fichier_devis_livraison`, 
                                               `id_etat`, 
                                               `id_commande`) 
                VALUES (0,
                        0,
                        0,
                        0,
                        '',
                        1,
                        :id_commande)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
// changement d'état du devis passer à accepter
function req_update_devis_livraison($bdd,$id_commande) {
    $requete = "UPDATE devis_livraisons
                SET id_etat = 3
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();
}
// détermine les frais de port pour petits achats
function req_frais_de_port($bdd,$poids_livraison,$zone_livraison) {

    $requete = "SELECT * FROM tarifs_livraison
                WHERE poids_max <= :poids_livraison AND zone_destination = :zone_livraison
                ORDER BY poids_max DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> bindValue('poids_livraison', $poids_livraison, PDO::PARAM_INT);
    $req -> bindValue('zone_livraison', $zone_livraison, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees['prix'];
}
// tous les devis livraisons d'un client précis
function req_devis_v_client($bdd,$id_user) {
    $requete = "SELECT * FROM devis_livraisons
                INNER JOIN factures ON devis_livraisons.id_commande = factures.id_commande
                INNER JOIN commandes ON factures.id_commande = commandes.id_commande
                INNER JOIN etat_devis ON devis_livraisons.id_etat = etat_devis.id_etat
                INNER JOIN etats_livraisons ON factures.id_etat_livraison = etats_livraisons.id_etat_livraison
                WHERE commandes.id_user = :id_user
                GROUP BY devis_livraisons.id_commande
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère le devis associé à une facture si il existe
function req_devis_v($bdd,$id_commande) {
    $requete = "SELECT * FROM devis_livraisons
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// toutes les commandes d'un client précis
function req_commandes_ventes_client($bdd,$id_user) {
    $requete = "SELECT * FROM  factures 
                INNER JOIN commandes ON factures.id_commande = commandes.id_commande
                INNER JOIN etats_commandes ON factures.id_etat_commande = etats_commandes.id_etat_commande
                INNER JOIN etats_livraisons ON factures.id_etat_livraison = etats_livraisons.id_etat_livraison
                INNER JOIN numeros_factures ON factures.id_facture = numeros_factures.id_facture
                WHERE commandes.id_user = :id_user
                GROUP BY factures.id_commande
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// annuler une commande 
function req_annulation_commande($bdd,$id_livraison) {
    // récupéré l'id_commande
    $requete = "SELECT * FROM devis_livraisons
                WHERE id_livraison = :id_livraison";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_livraison',$id_livraison,PDO::PARAM_INT);
    $req -> execute();
    $id = $req -> fetch();

    // change l'état dans devis_livraisons
    $requete = "UPDATE devis_livraisons
                SET id_etat = 4
                WHERE id_livraison = :id_livraison";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_livraison',$id_livraison,PDO::PARAM_INT);
    $req -> execute();

    // change l'état dans factures
    $requete = "UPDATE factures
                SET id_etat_commande = 4, id_etat_livraison = 5
                WHERE id_commande = :id_commande";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande',$id['id_commande'],PDO::PARAM_INT);
    $req -> execute();
}
// -----------------------------------------------------------------------
//                             accueil
// -----------------------------------------------------------------------
// récupération des parties de la boutique
function req_sections($bdd) {
    $requete = "SELECT * FROM sections 
                INNER JOIN images_sites ON sections.id_img = images_sites.id_img";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// affichage des cards des parties de la boutique
function affiche_sections($donnees) {
    $sections = "";
    $i = 0;
    foreach ($donnees as $donnee) {
        if ($i == 0) {
            $order = 'order-1 order-lg-0';
        }
        elseif ($i == 1) {
            $order = 'order-0 order-lg-1';
        }
        else {
            $order = 'order-'.$i;
        }
        $sections .= '
            <div class="card position-relative  border-0 card_cat '.$order.'">
                <a href="index.php?page=201&s='.$donnee['id_section'].'" class="">
                    <div class="watermark">
                        <img class="card-img-top " src="public/assets/img/site/'.$donnee['nom_img'].'" alt="'.$donnee['nom_section'].'" title="'.$donnee['nom_section'].'">
                    </div>
                    <div class="card-body position-absolute  bottom-0  start-50 translate-middle w-100 text-center">
                        <h4 class="card-title text-white mb-3 px-5 px-lg-3">'.$donnee['nom_section'].'</h4>
                        <a href="index.php?page=201&s='.$donnee['id_section'].'" class="btn btn-gris-souris rounded-pill mb-lg-3 mt-5 mt-lg-0 ">Découvrir</a>
                    </div>
                </a>
            </div>
        ';
        $i++;
    }
    return $sections;
}
// récupération des "sous catégories" des parties de la boutique
function req_sous_categories($bdd,$section) {
    $requete = "SELECT * FROM filtres
                WHERE id_section = :section";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':section', $section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération des nouveautés
function req_nouveautes($bdd) {
    $requete = "SELECT * FROM produits
                INNER JOIN categories ON produits.id_cat = categories.id_cat
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                WHERE (categories.id_section = 1 OR categories.id_section = 2) 
                AND produits.afficher_produit = 1 AND images_produits.position_img_produit = 1
                ORDER BY produits.id_produit DESC
                LIMIT 15";
    $req = $bdd->prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// carousel de produit pour la page d'accueil
function carousel_produit($bdd,$produits) {
    $sortie = "";
    $i = 1;
    foreach ($produits as $lignes) {
        if ($i == 1) { 
            $etat = 'active';
        }
        else { 
            $etat = '';
        }

        // ajout au favoris si connecté
        if (isset($_SESSION['id_client'])) {
            $img_fav = produit_dans_fav($bdd,$_SESSION['id_client'],$lignes['id_produit']);
            if ($img_fav['test'] == 1) {
                $img_coeur = 'coeur1.png';
            }
            else {
                $img_coeur = 'coeur.png';
            }

            $btn_fav = '<button type="button"  class="btn btn-button-light add_fav" id="btn_add'.$lignes['id_produit'].'" value="'.$_SESSION['id_client'].'"><img src="public/assets/img/icones/'.$img_coeur.'" alt="" class="img-fluid icones"></button>';
        }
        else {
            $btn_fav = '';
        }

        $sortie .= '
        <div class="carousel-item '.$etat.'">
            <div class="col-lg-3 col-md-6">
                <div class="card card_produit">
                    <a class="card-img-top watermark" href="index.php?page=203&c='.$lignes['id_produit'].'">
                        <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" alt="image '.$lignes['nom_img_produit'].'" title=" image '.$lignes['nom_img_produit'].'" class="img-fluid">
                    </a>
                    <div class="card-body w-100">
                        <h4 class="card-title fs-6">'.$lignes['nom_produit'].'</h4>
                        <div class="card-text ">
                            '.$btn_fav.'
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
        $i++;
    }
    return $sortie;
}
// test si produit est dans les favoris
function produit_dans_fav($bdd,$identifiant_client,$id_produit) {
    $requete = "SELECT COUNT(favoris.id_user) AS test FROM favoris 
                INNER JOIN utilisateurs ON favoris.id_user = utilisateurs.id_user
                WHERE favoris.id_produit = :id_produit AND utilisateurs.identifiant_client = :identifiant_client
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> bindValue(':identifiant_client', $identifiant_client, PDO::PARAM_INT);
    $req -> execute();
    $sortie = $req -> fetch();
    return $sortie;
}
// récupération des promotions
function req_promo($bdd) {
    $requete = "SELECT * FROM promotions
                WHERE id_promo = 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
//-------------------------------------------------------------------
//                        produits et boutique
//-------------------------------------------------------------------
// récupère une section précise
function req_section($bdd,$id_section) {
    $requete = "SELECT * FROM sections
                WHERE id_section = :id_section";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_section', $id_section, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère les catégories
function req_categories($bdd,$section,$sous_cat) {
    if ($sous_cat != 0) {
        $where = ' AND produits.id_filtre = :id_filtre';
    }
    else {
        $where = '';
    }
    $requete = 'SELECT * FROM categories
                INNER JOIN images_sites ON categories.id_img = images_sites.id_img
                INNER JOIN produits ON categories.id_cat = produits.id_cat
                WHERE categories.id_section = :section '.$where.'
                GROUP BY categories.id_cat
                ORDER BY categories.nom_categorie
    ';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':section', $section, PDO::PARAM_INT);
    if ($sous_cat != 0) {
        $req -> bindValue(':id_filtre', $sous_cat, PDO::PARAM_INT);
    }
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère une catégorie précise
function req_categorie($bdd,$id_categorie) {
    $requete = "SELECT * FROM categories
                INNER JOIN images_sites ON categories.id_img = images_sites.id_img
                WHERE categories.id_cat = :id_categorie
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupération des produits appartenant à une catégorie et une sous catégorie précise.
function req_produits($bdd,$id_categorie,$id_sous_cat,$offset,$nbr_entree_page,$p,$u) {
    if ($id_categorie != 0) {
        $where_c = ' WHERE produits.id_cat = :id_categorie ';
    }
    else {
        $where_c = '';
    }
    if ($id_sous_cat != 0) {
        $where = ' AND produits.id_filtre = :id_sous_cat  ';
    }
    else {
        $where = '';
    }
    
    if ($p == 1) {
        // seulement les produits en promo
        if ($id_categorie != 0) {
            $where_p = ' AND produits.promo_produit = 1 ';
        }
        else {
            $where_p = 'WHERE produits.promo_produit = 1 ';
        }

    }
    else {
        $where_p = '';
    }

    if ($u == 1) {
        // seulement les pieces uniques
        $where_u = ' AND produits.piece_unique = 1 ';
    }
    else {
        $where_u = '';
    }

    $requete = 'SELECT * FROM produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                '.$where_c.$where.$where_p.$where_u.'
                AND produits.afficher_produit = 1
                GROUP BY produits.id_produit
                LIMIT '.$offset.', '.$nbr_entree_page;
    $req = $bdd -> prepare($requete);
    if ($id_categorie != 0) {
        $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    }
    if ($id_sous_cat != 0) {
        $req -> bindValue(':id_sous_cat', $id_sous_cat, PDO::PARAM_INT);
    }
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
function req_nbr_entre_catalogue($bdd,$id_sous_cat,$id_categorie,$p,$u) {
    if ($id_categorie != 0) {
        $where_c = ' WHERE produits.id_cat = :id_categorie ';
    }
    else {
        $where_c = '';
    }
    if ($id_sous_cat != 0) {
        // une sous cat est sélectionnée
        $where = ' AND produits.id_filtre = :id_sous_cat  ';
    }
    else {
        $where = '';
    }

    if ($p == 1) {
        // seulement les produits en promo
        $where_p = ' AND produits.promo_produit = 1 ';
    }
    else {
        if ($id_categorie == 0) {
            $where_p = ' WHERE produits.promo_produit = 1 ';
        }
        else {
            $where_p = '';
        }
    }

    if ($u == 1) {
        // seulement les pieces uniques
        $where_u = ' AND produits.piece_unique = 1 ';
    }
    else {
        $where_u = '';
    }

    $requete = 'SELECT * FROM produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                '.$where_c.$where.$where_p.$where_u.'
                AND produits.afficher_produit = 1
                GROUP BY produits.id_produit
                ';
    $req = $bdd -> prepare($requete);
    if ($id_categorie != 0) {
        $req -> bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    }
    if ($id_sous_cat != 0) {
        $req -> bindValue(':id_sous_cat', $id_sous_cat, PDO::PARAM_INT);
    }
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}
// affichage des produits
function cards_produits($bdd,$produits) {
    $sortie = "";
    $i = 0;
    foreach ($produits as $lignes) {
        // ajout au favoris si connecté
        if (isset($_SESSION['id_client'])) {
            $img_fav = produit_dans_fav($bdd,$_SESSION['id_client'],$lignes['id_produit']);
            if ($img_fav['test'] == 1) {
                $img_coeur = 'coeur1.png';
            }
            else {
                $img_coeur = 'coeur.png';
            }

            $btn_fav = '<button type="button"  class="btn btn-button-light add_fav" id="btn_add'.$lignes['id_produit'].'" value="'.$_SESSION['id_client'].'"><img src="public/assets/img/icones/'.$img_coeur.'" alt="" class="img-fluid icones"></button>';
        }
        else {
            $btn_fav = '';
        }

        $sortie .= '
        <div class="col-lg-4 col-md-6">
            <div class="card card_produit_catalogue text-center bg-transparent">
                <a class="card-img-top watermark" href="index.php?page=203&c='.$lignes['id_produit'].'">
                    <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" alt="image '.$lignes['nom_img_produit'].'" title=" image '.$lignes['nom_img_produit'].'" class="img-fluid">
                </a>
                <div class="card-body w-100">
                    <h4 class="card-title fs-6">'.$lignes['nom_produit'].'</h4>
                    <div class="card-text ">

                        '.$btn_fav.'
                    </div>
                </div>
            </div>
        </div>
        ';
        $i++;
    }
    if ($i == 0) {
        $sortie = '<p class="text-center py-3">Nous vous remercions de votre visite sur notre site ! Actuellement, la section que vous avez sélectionnée est en cours de construction et les produits ne sont pas encore disponibles. Nous travaillons activement pour ajouter de nouveaux articles et nous nous excusons pour tout inconvénient que cela pourrait causer. Restez à l\'écoute, car nous avons hâte de vous présenter notre collection de produits exceptionnels très bientôt !</p>';
    }
    return $sortie;
}
// récupération d'un produit précis
function req_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM produits
                INNER JOIN categories ON produits.id_cat = categories.id_cat
                INNER JOIN filtres ON produits.id_filtre = filtres.id_filtre
                INNER JOIN sections ON categories.id_section = sections.id_section
                WHERE produits.id_produit = :id_produit
                ';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupération des images d'un produit
function req_images_produit($bdd,$id_produit) {
    $requete = "SELECT * FROM images_produits
                WHERE id_produit = :id_produit
                AND afficher_img_produit = 1
                ORDER BY position_img_produit";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// carousel produit page produit
function carousel_produit2($bdd,$images,$id) {
    $carousel_indicators = "";
    $carousel_item = "";
    $i = 0;

    if (isset($images)) {
        foreach ($images as $lignes) {
            $carousel_indicators .= '
                <button type="button" 
                    data-bs-target="#'.$id.'" 
                    data-bs-slide-to="'.$i.'" ';
            if ($i == 0) {
                $carousel_indicators .= '
                    class="active watermark"
                    aria-current="true"';
            }
            else {
                $carousel_indicators .= '
                class="watermark"';
            }
            $carousel_indicators .= '
                    aria-label="Slide '.($i+1).'"
                    "> 
                    <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" alt="" class=" d-block border_indicator">
                </button>';
    
    
            $carousel_item .= '
                <div class="carousel-item watermark ';
            if ($i == 0) {
                $carousel_item .= 'active';
            }
            $carousel_item .= '">
                    <img
                        src="public/assets/img/produits/'.$lignes['nom_img_produit'].'"
                        class="w-100 d-block"
                        alt="slide '.($i+1).'"
                    />
                </div>
                ';
            $i++;
        }
    }
    else {
        // si il n'y a pas d'images
        $carousel_indicators .= '
            <button type="button" 
                data-bs-target="#'.$id.'" 
                data-bs-slide-to="'.$i.'" ';
        if ($i == 0) {
            $carousel_indicators .= '
                class="active watermark"
                aria-current="true"';
        }
        else {
            $carousel_indicators .= '
                class="watermark"
                ';
        }
        $carousel_indicators .= '
                aria-label="Slide '.($i+1).'"
                "> 
                <img src="'.image_par_default('', '').'" alt="" class=" d-block border_indicator">
            </button>';


        $carousel_item .= '
            <div class="carousel-item watermark ';
        if ($i == 0) {
            $carousel_item .= 'active';
        }
        $carousel_item .= '">
                <img
                    src="'.image_par_default('', '').'"
                    class="w-100 d-block"
                    alt="slide '.($i+1).'"
                />
            </div>
            ';
    }
    $sortie = [$carousel_indicators,$carousel_item];
    return $sortie;
}
// récupération des couleurs d'un produits
function req_couleurs_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM customisations_couleur
                INNER JOIN couleurs ON couleurs.id_couleur = customisations_couleur.id_couleur
                WHERE customisations_couleur.id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// récupération des matières d'un produit
function req_matieres_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM customisations_matiere
                INNER JOIN matieres ON matieres.id_matiere = customisations_matiere.id_matiere
                WHERE customisations_matiere.id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// récupération des données de customisation pour les dimensions d'un produit
function req_tailles_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM customisations_taille
                INNER JOIN autres_tailles ON autres_tailles.id_autre_taille = customisations_taille.id_autre_taille
                WHERE customisations_taille.id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
function req_dimensions_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM tailles
                WHERE id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;
}
// récupération des autres customisations pour un produit
function req_customs_produit($bdd,$id_produit) {
    $requete = 'SELECT * FROM customisations_autres
                INNER JOIN customisations ON customisations.id_custom = customisations_autres.id_custom
                WHERE customisations_autres.id_produit = :id_produit';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $sortie = [$donnees,$nbr];
    return $sortie;   
}
// récupération des suggestions de produits 
function req_suggestion_produits($bdd,$id_cat) {
    $requete = "SELECT * FROM produits
                INNER JOIN images_produits ON produits.id_produit = images_produits.id_produit
                WHERE produits.id_cat = :id_cat AND images_produits.position_img_produit = 1
                ORDER BY RAND()
                LIMIT 3 
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_cat',$id_cat,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// compte le nombre de produit dans le panier en cours
function count_panier($bdd) {
    $requete = "SELECT COUNT(id_commande) AS test FROM paniers 
                WHERE id_commande = :id_commande";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_commande', $_SESSION['id_commande'], PDO::PARAM_INT);
    $req -> execute();  

    $test_panier = $req -> fetch();
    return $test_panier;
}
// met à jour le client du panier
function req_update_user_panier($bdd,$id_client) {
    $requete = "UPDATE `paniers` SET `id_user`= :id_client 
                WHERE id_commande = :id_commande";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_client', $id_client, PDO::PARAM_INT); 
    $req->bindValue(':id_commande', $_SESSION['id_commande'], PDO::PARAM_INT);
    $req -> execute(); 
}
// met à jour l'id commande d'un panier
function req_update_commande_panier($bdd,$id_commande) {
    $requete = "UPDATE `paniers` SET `id_commande`= :id_commande2 
                WHERE id_commande = :id_commande";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_commande', $id_commande, PDO::PARAM_INT); 
    $req->bindValue(':id_commande2', $_SESSION['id_commande'], PDO::PARAM_INT);
    $req -> execute(); 
}
// teste si le client a un panier en attente
function req_user_panier($bdd,$id_client) {
    $requete = "SELECT * FROM paniers
                WHERE id_user = :id_user";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_user', $id_client, PDO::PARAM_INT);
    $req -> execute();  

    $paniers = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $test_panier = [$paniers, $nbr];
    return $test_panier;
}
// teste si un produit est dans le panier en cours
function req_user_panier_produit($bdd,$id_produit) {
    $requete = "SELECT COUNT(id_panier) AS test FROM paniers
                WHERE id_produit = :id_produit AND id_commande = :id_commande";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req->bindValue(':id_commande', $_SESSION['id_commande'], PDO::PARAM_INT);
    $req -> execute();  

    $nbr = $req -> fetch();
    return $nbr;
}
// supprime une entré précise du paniers
function sup_id_panier($bdd,$id_panier) {
    $requete = "DELETE FROM paniers
                WHERE id_panier = :id_panier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_panier', $id_panier, PDO::PARAM_INT);
    $req -> execute(); 
}
// à la connexion update des paniers si ils existe déjà
function update_panier_si_existe($bdd,$id_client) {
    //---------------
    // panier vente
    //---------------
    $test_panier = count_panier($bdd);

    if ($test_panier['test'] > 0) {
        // si le panier n'est pas vide teste si le client a deja un panier
        $test_client = req_user_panier($bdd,$id_client);

        if ($test_client[1] > 0) {
            // teste si les produits de l'ancien panier sont dans le panier actuel 
            foreach ($test_client[0] as $lignes) {
                $test = req_user_panier_produit($bdd,$lignes['id_produit']);
                if ($test['test'] > 0) {
                    // si oui supprime le produit de l'ancien panier
                    sup_id_panier($bdd,$lignes['id_panier']);
                }
            }
            // met à jour l'id_commande de l'ancien panier
            req_update_commande_panier($bdd,$test_client[0][0]['id_commande']);
            // met à jour le client du panier en cours
            req_update_user_panier($bdd,$id_client);
        }
        else {
            // met à jour le client du panier en cours
            req_update_user_panier($bdd,$id_client);
        }
    }
    else {
        // si il n'y a pas de panier en cours vérifie si le client n'a pas un panier en attente
        $test_client = req_user_panier($bdd,$id_client);
        if ($test_client[1] > 0) {
            req_update_commande_panier($bdd,$test_client[0][0]['id_commande']);

        }
    }
    //----------------
    // panier location 
    //----------------
    $test_panier = count_panier_l($bdd);

    if ($test_panier['test'] > 0) {
        // si le panier n'est pas vide teste si le client a deja un panier
        $test_client = req_user_panier_l($bdd,$id_client);

        if ($test_client[1] > 0) {
            // teste si les produits de l'ancien panier sont dans le panier actuel 
            foreach ($test_client[0] as $lignes) {
                $test = req_user_panier_produit_l($bdd,$lignes['id_produit']);
                if ($test['test'] > 0) {
                    // si oui supprime le produit de l'ancien panier
                    sup_id_panier_l($bdd,$lignes['id_panier_loc']);
                }
            }
            // met à jour l'id_commande de l'ancien panier
            req_update_commande_panier_l($bdd,$test_client[0][0]['id_location']);
            // met à jour le client du panier en cours
            req_update_user_panier_l($bdd,$id_client);
        }
        else {
            // met à jour le client du panier en cours
            req_update_user_panier_l($bdd,$id_client);
        }
    }
    else {
        $test_client = req_user_panier_l($bdd,$id_client);
        if ($test_client[1] > 0) {
            req_update_commande_panier_l($bdd,$test_client[0][0]['id_location']);

        }
    }
}
// compte le nombre de produit dans le panier location en cours
function count_panier_l($bdd) {
    $requete = "SELECT COUNT(id_location) AS test FROM paniers_location 
                WHERE id_location = :id_location";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_location', $_SESSION['id_location'], PDO::PARAM_INT);
    $req -> execute();  

    $test_panier = $req -> fetch();
    return $test_panier;
}
// met à jour le client du panier location
function req_update_user_panier_l($bdd,$id_client) {
    $requete = "UPDATE `paniers_location` SET `id_user`= :id_client 
                WHERE id_location = :id_location";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_client', $id_client, PDO::PARAM_INT); 
    $req->bindValue(':id_location', $_SESSION['id_location'], PDO::PARAM_INT);
    $req -> execute(); 
}
// met à jour l'id commande d'un panier location
function req_update_commande_panier_l($bdd,$id_location) {
    $requete = "UPDATE `paniers_location` SET `id_location`= :id_location2 
                WHERE id_location = :id_location";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_location', $id_location, PDO::PARAM_INT); 
    $req->bindValue(':id_location2', $_SESSION['id_location'], PDO::PARAM_INT);
    $req -> execute(); 
}
// teste si le client a un panier location en attente
function req_user_panier_l($bdd,$id_client) {
    $requete = "SELECT * FROM paniers_location
                WHERE id_user = :id_user";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_user', $id_client, PDO::PARAM_INT);
    $req -> execute();  

    $paniers = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $test_panier = [$paniers, $nbr];
    return $test_panier;
}
// teste si un produit est dans le panier location en cours
function req_user_panier_produit_l($bdd,$id_produit) {
    $requete = "SELECT COUNT(id_panier_loc) AS test FROM paniers_location
                WHERE id_produit = :id_produit AND id_location = :id_location";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_produit', $id_produit, PDO::PARAM_INT);
    $req->bindValue(':id_location', $_SESSION['id_location'], PDO::PARAM_INT);
    $req -> execute();  

    $nbr = $req -> fetch();
    return $nbr;
}
// supprime une entrée précise du paniers location
function sup_id_panier_l($bdd,$id_panier) {
    $requete = "DELETE FROM paniers_location
                WHERE id_panier_loc = :id_panier";
    $req = $bdd->prepare($requete);
    $req->bindValue(':id_panier', $id_panier, PDO::PARAM_INT);
    $req -> execute(); 
}
// test si un produit est dans le panier
function req_produit_dans_panier($bdd,$id_produit,$id_panier,$id_section) {
    if ($id_section == 3) {
        $requete = "SELECT * FROM paniers_location
                    WHERE id_location = :id_commande AND id_produit = :id_produit
        ";
    }
    else {
        $requete = "SELECT * FROM paniers
                    WHERE id_produit = :id_produit AND id_commande = :id_commande
        ";
    }
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_produit',$id_produit,PDO::PARAM_INT);
    $req -> bindValue(':id_commande',$id_panier,PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    $nbr = $req -> rowCount();
    $sortie = [$donnees, $nbr];
    return $sortie;
}
// récupère les produits du panier
function req_panier_vente($bdd,$id_commande) {
    $requete = "SELECT * FROM paniers
                INNER JOIN images_produits ON paniers.id_produit = images_produits.id_produit
                INNER JOIN produits ON paniers.id_produit = produits.id_produit
                WHERE paniers.id_commande = :id_commande AND images_produits.position_img_produit = 1
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère tous les produits d'une commande
function req_commande_vente($bdd,$id_commande) {
    $requete = "SELECT * FROM commandes
                INNER JOIN images_produits ON commandes.id_produit = images_produits.id_produit
                INNER JOIN produits ON commandes.id_produit = produits.id_produit
                WHERE commandes.id_commande = :id_commande AND images_produits.position_img_produit = 1
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère les tailles du produit pour commande cas paniers
function req_produit_taille_select($bdd,$id_taille) {
    $requete = "SELECT * FROM paniers
                INNER JOIN tailles ON paniers.id_taille = tailles.id_taille
                WHERE paniers.id_taille = :id_taille 
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupère les tailles du produit pour commande cas commandes
function req_produit_taille_select2($bdd,$id_taille) {
    $requete = "SELECT * FROM commandes
                INNER JOIN tailles ON commandes.id_taille = tailles.id_taille
                WHERE commandes.id_taille = :id_taille 
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_taille', $id_taille, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// supprimer un produit du panier vente
function req_sup_produit_panier($bdd,$id_panier) {
    $requete = "DELETE FROM `paniers` 
                WHERE id_panier = :id_panier
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_panier', $id_panier, PDO::PARAM_INT);
    $req -> execute();
}
// récupère les produits du panier location
function req_panier_location($bdd,$id_commande) {
    $requete = "SELECT * FROM paniers_location
                INNER JOIN images_produits ON paniers_location.id_produit = images_produits.id_produit
                INNER JOIN produits ON paniers_location.id_produit = produits.id_produit
                WHERE paniers_location.id_location = :id_commande AND images_produits.position_img_produit = 1
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_commande', $id_commande, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// supprimer un produit du panier location
function req_sup_produit_panier_loc($bdd,$id_panier_loc) {
    $requete = "DELETE FROM `paniers_location` 
                WHERE id_panier_loc = :id_panier_loc
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_panier_loc', $id_panier_loc, PDO::PARAM_INT);
    $req -> execute();
}
//----------------------
// nettoyage
//----------------------
// supprimer les paniers sans clients vieux de plus de 24 heures
function req_purge_panier_sans_client($bdd) {
    $date = time() - 24*3600;
    // vente
    $requete = "DELETE FROM paniers WHERE id_commande < $date AND id_user IS NULL";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    // location
    $requete = "DELETE FROM paniers_location WHERE id_location < $date AND id_user IS NULL";
    $req = $bdd -> prepare($requete);
    $req -> execute();
}
// supprimer les panier clients de plus de 2 semaines
function req_purge_panier_avec_client($bdd) {
    $date = time() - 14*24*3600;
    // vente
    $requete = "DELETE FROM paniers WHERE id_commande < $date AND id_user IS NOT NULL";
    $req = $bdd -> prepare($requete);
    $req -> execute();
    // location
    $requete = "DELETE FROM paniers_location WHERE id_location < $date AND id_user IS NOT NULL";
    $req = $bdd -> prepare($requete);
    $req -> execute();
}
//-------------------------------------------------------------------
//                      événementiel et partenaires
//-------------------------------------------------------------------
// récupère la liste des partenaires
function req_partenaires($bdd) {
    $requete = "SELECT * FROM partenaires
                INNER JOIN images_sites ON partenaires.id_img = images_sites.id_img
                WHERE afficher_partenaire = 1
                ORDER BY partenaires.nom_partenaire";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// enregistre la demande de devis location
function req_insert_devis_location($bdd,$id_user,$date_evenement_devis,$nbr_invite,$type_evenement,$adresse_evenement,$panier_location,$message_devis) {
    $date = time();
    $requete = "INSERT INTO `devis_evenementiel`(`id_devis`, 
                                                `date_devis`, 
                                                `date_evenement_devis`, 
                                                `message_devis`, 
                                                `lu_devis`, 
                                                `repondu_devis`, 
                                                `nbr_invite`, 
                                                `type_evenement`, 
                                                `adresse_evenement`, 
                                                fichier_devis_location,
                                                `id_location`, 
                                                `id_etat`, 
                                                `id_user`) 
                VALUES (0,
                        :date_devis,
                        :date_evenement_devis,
                        :message_devis,
                        0,
                        0,
                        :nbr_invite,
                        :type_evenement,
                        :adresse_evenement,
                        NULL,
                        :panier_location,
                        1,
                        :id_user)
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':date_devis',$date,PDO::PARAM_INT);
    $req -> bindValue(':date_evenement_devis',$date_evenement_devis,PDO::PARAM_STR);
    $req -> bindValue(':message_devis',$message_devis,PDO::PARAM_STR);
    $req -> bindValue(':nbr_invite',$nbr_invite,PDO::PARAM_INT);
    $req -> bindValue(':type_evenement',$type_evenement,PDO::PARAM_STR);
    $req -> bindValue(':adresse_evenement',$adresse_evenement,PDO::PARAM_STR);
    $req -> bindValue(':panier_location',$panier_location,PDO::PARAM_INT);
    $req -> bindValue(':id_user',$id_user,PDO::PARAM_INT);
    $req -> execute();


}
// update un devis
function req_update_devis_location($bdd,$id_devis,$date_evenement_devis,$nbr_invite,$type_evenement,$adresse_evenement,$panier_location,$message_devis) {
    $requete = "UPDATE `devis_evenementiel` 
                SET `date_evenement_devis`=:date_evenement_devis,
                    `message_devis`=:message_devis,
                    `lu_devis`= 0,
                    `nbr_invite`=:nbr_invite,
                    `type_evenement`=:type_evenement,
                    `adresse_evenement`=:adresse_evenement,
                    `id_location`=:panier_location
                WHERE `id_devis`=:id_devis
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':date_evenement_devis',$date_evenement_devis,PDO::PARAM_STR);
    $req -> bindValue(':message_devis',$message_devis,PDO::PARAM_STR);
    $req -> bindValue(':nbr_invite',$nbr_invite,PDO::PARAM_INT);
    $req -> bindValue(':type_evenement',$type_evenement,PDO::PARAM_STR);
    $req -> bindValue(':adresse_evenement',$adresse_evenement,PDO::PARAM_STR);
    $req -> bindValue(':panier_location',$panier_location,PDO::PARAM_INT);
    $req -> bindValue(':id_devis',$id_devis,PDO::PARAM_INT);
    $req -> execute();
}
// test si le client a un devis en court 
function req_devis_client_existe($bdd,$id_user) {
    $requete = "SELECT * FROM devis_evenementiel
                WHERE id_user = :id_user AND id_etat = 1";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user',$id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}
// récupère les devis d'un client 
function req_devis_l_client($bdd,$id_user) {
    $requete = "SELECT * FROM devis_evenementiel
                INNER JOIN utilisateurs ON devis_evenementiel.id_user = utilisateurs.id_user
                INNER JOIN etat_devis ON devis_evenementiel.id_etat = etat_devis.id_etat
                WHERE devis_evenementiel.id_user = :id_user
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupère le devis en attente pour modification
function req_devis_l_client_m($bdd,$id_user) {
    $requete = "SELECT * FROM devis_evenementiel
    INNER JOIN utilisateurs ON devis_evenementiel.id_user = utilisateurs.id_user
    INNER JOIN etat_devis ON devis_evenementiel.id_etat = etat_devis.id_etat
    WHERE devis_evenementiel.id_user = :id_user AND devis_evenementiel.id_etat = 1
    ";
$req = $bdd -> prepare($requete);
$req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
$req -> execute();

$donnees = $req -> fetch();
return $donnees;
}
//-------------------------------------------------------------------
//                              ateliers
//-------------------------------------------------------------------
// récupération de tous les ateliers
function req_ateliers($bdd) {
    $requete = "SELECT * FROM ateliers
                WHERE afficher_atelier = 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupération d'un atelier précis
function req_atelier($bdd,$id_atelier) {
    $requete = "SELECT * FROM ateliers 
                WHERE id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetch();
    return $donnees;
}
// récupération des images d'un atelier
function req_ateliers_images($bdd,$id_atelier) {
    $requete = "SELECT * FROM images_sites
                INNER JOIN illustrations_ateliers ON  images_sites.id_img = illustrations_ateliers.id_img
                WHERE illustrations_ateliers.id_atelier = :id_atelier 
                ORDER BY illustrations_ateliers.position_image
                ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $image = $req -> fetchAll();
    return $image;
}
// carousel ateliers pour la page d'accueil
function carousel_atelier($bdd,$donnees,$id) {
    $carousel_indicators = "";
    $carousel_item = "";
    $i = 0;

    foreach ($donnees as $lignes) {
        $image = req_ateliers_images($bdd,$lignes['id_atelier']);
        if (isset($image[0]['nom_img'])) {
            $nom_img = $image[0]['nom_img'];
        }
        else {
            // si pas d'image (normalement au moins une)
            $nom_img = '';
        }

        $carousel_indicators .= '
            <li
                data-bs-target="#'.$id.'"
                data-bs-slide-to="'.$i.'"';
        if ($i == 0) {
            $carousel_indicators .= '
                class="active"
                aria-current="true"';
        }
        $carousel_indicators .= '
                aria-label="slide '.($i+1).'"
            ></li>
            ';

        $carousel_item .= '
            <div class="carousel-item watermark2 ';
        if ($i == 0) {
            $carousel_item .= 'active';
        }
        $carousel_item .= '">
                <img
                    src="'.image_par_default('public/assets/img/site/', $nom_img).'"
                    class="w-100 d-block"
                    alt="slide '.($i+1).'"
                />
            </div>
            ';
        $i++;
    }
    $sortie = [$carousel_indicators,$carousel_item];
    return $sortie;
}
// carousel atelier pour les pages ateliers participatifs
function carousel_atelier2($bdd,$donnees,$id) {
    $carousel_indicators = "";
    $carousel_item = "";
    $i = 0;

    $images = req_ateliers_images($bdd,$donnees);
    if (isset($images)) {
        foreach ($images as $lignes) {
            $carousel_indicators .= '
                <button type="button" 
                    data-bs-target="#'.$id.'" 
                    data-bs-slide-to="'.$i.'" ';
            if ($i == 0) {
                $carousel_indicators .= '
                    class="active watermark"
                    aria-current="true"';
            }
            else {
                $carousel_indicators .= '
                class="watermark "
                ';
            }
            $carousel_indicators .= '
                    aria-label="Slide '.($i+1).'"
                    "> 
                    <img src="public/assets/img/site/'.$lignes['nom_img'].'" alt="" class=" d-block border_indicator">
                </button>';
    
    
            $carousel_item .= '
                <div class="carousel-item watermark ';
            if ($i == 0) {
                $carousel_item .= 'active';
            }
            $carousel_item .= '">
                    <img
                        src="public/assets/img/site/'.$lignes['nom_img'].'"
                        class="w-100 d-block"
                        alt="slide '.($i+1).'"
                    />
                </div>
                ';
            $i++;
        }
    }
    else {
        // si il n'y a pas d'images
        $carousel_indicators .= '
            <button type="button" 
                data-bs-target="#'.$id.'" 
                data-bs-slide-to="'.$i.'" ';
        if ($i == 0) {
            $carousel_indicators .= '
                class="active "
                aria-current="true"';
        }
        $carousel_indicators .= '
                aria-label="Slide '.($i+1).'"
                "> 
                <img src="'.image_par_default($chemin, '').'" alt="" class=" d-block border_indicator">
            </button>';


        $carousel_item .= '
            <div class="carousel-item ';
        if ($i == 0) {
            $carousel_item .= 'active';
        }
        $carousel_item .= '">
                <img
                    src="'.image_par_default($chemin, '').'"
                    class="w-100 d-block"
                    alt="slide '.($i+1).'"
                />
            </div>
            ';
    }
    $sortie = [$carousel_indicators,$carousel_item];
    return $sortie;
}
// toutes les horaires pour un atelier précis
function req_horaires_atelier($bdd,$id_atelier) {
    $requete = "SELECT * FROM calendrier_ateliers 
                WHERE id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $horaire = $req -> fetchAll();
    return $horaire;
} 
// affichage de ces horaires
function dates_ateliers ($dates,$nbr_max,$duree) {
    $sortie = "";
    foreach ($dates as $lignes) {
        $sortie .= '<li>Le '.date('d-m-Y à H:i',$lignes['date_atelier']).', durée : '.$duree.' min, reste '.$nbr_max-$lignes['nbr_participant'].' places</li>
        ';
    }
    return $sortie;
}
// récupération du texte de la page team building
function req_txt_tb($bdd) {
    $requete = "SELECT * FROM `team_building_textes` 
                WHERE afficher_tb_txt = 1
                ORDER BY position_tb_txt";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $sortie = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $donnees = [$sortie,$nbr];
    return $donnees;
}
// récupération des logos pour la page team building
function req_logo_tb($bdd) {
    $requete = "SELECT * FROM team_building
                INNER JOIN images_sites ON team_building.id_img = images_sites.id_img
                WHERE team_building.logo = 1 AND  team_building.afficher_tb = 1
                ";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $sortie = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $donnees = [$sortie,$nbr];
    return $donnees;
}
// récupération des images pour la page team building
function req_img_tb($bdd) {
    $requete = "SELECT * FROM team_building
                INNER JOIN images_sites ON team_building.id_img = images_sites.id_img
                WHERE team_building.illustration = 1 AND  team_building.afficher_tb = 1
                ";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $sortie = $req -> fetchAll();
    $nbr = $req -> rowCount();
    $donnees = [$sortie,$nbr];
    return $donnees;
}
// carousel de la page team building
function carousel_tb($images,$debut,$fin,$id) {
    $carousel_indicators = "";
    $carousel_item = "";
    $i = 0;

    for ($j = $debut; $j <= $fin; $j++) {
        if (isset($images[$j]['nom_img'])) {
            $nom_img = $images[$j]['nom_img'];
        }
        else {
            $nom_img = '';
        }

        $carousel_indicators .= '
            <button type="button" 
                data-bs-target="#'.$id.'" 
                data-bs-slide-to="'.$i.'" ';
        if ($i == 0) {
            $carousel_indicators .= '
                class="active watermark"
                aria-current="true"';
        }
        else {
            $carousel_indicators .= '
            class="watermark "
            ';
        }
        $carousel_indicators .= '
                aria-label="Slide '.($i+1).'"
                "> 
                <img src="'.image_par_default('public/assets/img/site/', $nom_img).'" alt="" class=" d-block border_indicator">
            </button>';


        $carousel_item .= '
            <div class="carousel-item watermark ';
        if ($i == 0) {
            $carousel_item .= 'active';
        }
        $carousel_item .= '">
                <img
                    src="'.image_par_default('public/assets/img/site/', $nom_img).'"
                    class="w-100 d-block"
                    alt="slide '.($i+1).'"
                />
            </div>
            ';
        $i++;
    }
    $sortie = [$carousel_indicators,$carousel_item];
    return $sortie;
}
// récupération des ateliers où le client est déjà inscrit
    // toutes les horaires pour u natelier précis
function req_ateliers_client($bdd,$id_client,$id_atelier) {
    $requete = "SELECT * FROM inscriptions 
                INNER JOIN calendrier_ateliers ON inscriptions.id_date = calendrier_ateliers.id_date
                WHERE inscriptions.id_user = :id_client AND calendrier_ateliers.id_atelier = :id_atelier";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_client', $id_client, PDO::PARAM_INT);
    $req -> bindValue(':id_atelier', $id_atelier, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    $liste_inscriptions = array();

    foreach ($donnees as $key) {
        $liste_inscriptions[] = $key['id_date'];
    }
    return $liste_inscriptions;
}
    //tous les ateliers
function req_ts_ateliers_client($bdd) {
    $client = req_id_client($bdd);

    $requete = "SELECT * FROM inscriptions 
                INNER JOIN calendrier_ateliers ON inscriptions.id_date = calendrier_ateliers.id_date
                INNER JOIN ateliers ON calendrier_ateliers.id_atelier = ateliers.id_atelier
                INNER JOIN etats_commandes ON inscriptions.id_etat_commande = etats_commandes.id_etat_commande
                INNER JOIN numeros_factures ON inscriptions.id_facture = numeros_factures.id_facture
                WHERE inscriptions.id_user = :id_client ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_client', $client['id_user'], PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// inscription d'un client à un atelier
function req_inscription_atelier($bdd,$id_user,$id_atelier,$id_date,$nbr_inscrit,$token) {
    // crée un numero de facture
    $requete = "INSERT INTO numeros_factures (`id_facture`)  VALUES (0)";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $requete = "SELECT * FROM numeros_factures
                ORDER BY id_facture DESC
                LIMIT 1";
    $req = $bdd -> prepare($requete);
    $req -> execute();               
    $nbr = $req -> fetch();

    $requete = "INSERT INTO `inscriptions`(`id_user`, 
                                           `id_date`, 
                                           id_etat_commande,
                                           id_facture,
                                           `nbr_inscrit`,
                                           token) 
                VALUES (:id_user,
                        :id_date,
                        1,
                        :id_facture,
                        :nbr_inscrit,
                        :token)";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> bindValue(':nbr_inscrit', $nbr_inscrit, PDO::PARAM_INT);
    $req -> bindValue(':id_facture', $nbr['id_facture'], PDO::PARAM_INT);
    $req -> bindValue(':token', $token, PDO::PARAM_STR);
    $req -> execute();

    // mise à jour du nombre de participant
    $requete = "SELECT * FROM calendrier_ateliers 
                WHERE id_date = :id_date";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> execute();

    $nbr = $req -> fetch();

    $requete = "UPDATE calendrier_ateliers SET nbr_participant = :nbr_inscrit 
                WHERE id_date = :id_date";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_date', $id_date, PDO::PARAM_INT);
    $req -> bindValue(':nbr_inscrit', $nbr['nbr_participant']+$nbr_inscrit, PDO::PARAM_INT);
    $req -> execute();
}
// test si token pour payement est unique
function req_token_unique($bdd,$token,$table) {
    $requete = 'SELECT * FROM '.$table.' WHERE token = :token';
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':token', $token, PDO::PARAM_STR);
    $req -> execute();
    $test = $req -> rowCount();
    return $test;
}
//-------------------------------------------------------------------
//                          Sur mesure
//-------------------------------------------------------------------
// récupération des projets pour la galerie sur mesure
function req_projets($bdd,$offset,$nbr_entree_page) {
    $requete = 'SELECT * FROM projets_sur_mesure
                INNER JOIN galerie ON galerie.id_projet = projets_sur_mesure.id_projet
                INNER JOIN images_sites ON images_sites.id_img = galerie.id_img
                WHERE projets_sur_mesure.afficher_projet = 1 AND galerie.position_image = 1
                LIMIT  '.$offset.', '.$nbr_entree_page;
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
function req_nbr_entre_galerie($bdd) {
    $requete = 'SELECT * FROM projets_sur_mesure
                INNER JOIN galerie ON galerie.id_projet = projets_sur_mesure.id_projet
                INNER JOIN images_sites ON images_sites.id_img = galerie.id_img
                WHERE projets_sur_mesure.afficher_projet = 1 AND galerie.position_image = 1
                ';
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> rowCount();
    return $donnees;
}
// récupération d'un projet précis pour la page sur mesure
function req_projet($bdd, $id_projet) {
    $requete = "SELECT * FROM projets_sur_mesure
                INNER JOIN galerie ON galerie.id_projet = projets_sur_mesure.id_projet
                INNER JOIN images_sites ON images_sites.id_img = galerie.id_img
                WHERE projets_sur_mesure.id_projet = :id_projet 
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
//-------------------------------------------------------------------
//                             Contact 
//-------------------------------------------------------------------
// récupération des sujets contacts
function req_sujet_contacts($bdd) {
    $requete = 'SELECT * FROM sujets_contacts';
    $req = $bdd->prepare($requete);
    $req -> execute();
    $contacts = $req -> fetchAll();

    return $contacts;
}
// récupération d'un sujet précis'
function req_sujet_contact($bdd,$id_sujet) {
    $requete = 'SELECT * FROM sujets_contacts
                WHERE id_sujet = :id_sujet';
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_sujet',$id_sujet,PDO::PARAM_INT);
    $req -> execute();
    $contacts = $req -> fetch();

    return $contacts;
}
// enregistrement d'un message de contact
function req_save_contact($bdd,$date_message,$nom_contact,$mail_contact,$tel_contact,$sujet,$message_contact) {
    $requete = "INSERT INTO `contacts`(`id_contact`, 
                                        `message_contact`, 
                                        `mail_contact`, 
                                        `date_contact`, 
                                        `lu_contact`, 
                                        `repondu_contact`, 
                                        `id_sujet`, 
                                        `nom_contact`, 
                                        `tel_contact`) 
                VALUES (0,
                        :message_contact,
                        :mail_contact,
                        :date_message,
                        0,
                        0,
                        :sujet,
                        :nom_contact,
                        :tel_contact)
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':message_contact', $message_contact, PDO::PARAM_STR);
    $req -> bindValue(':mail_contact', $mail_contact, PDO::PARAM_STR);
    $req -> bindValue(':date_message', $date_message, PDO::PARAM_STR);
    $req -> bindValue(':sujet', $sujet, PDO::PARAM_INT);
    $req -> bindValue(':nom_contact', $nom_contact, PDO::PARAM_STR);
    $req -> bindValue(':tel_contact', $tel_contact, PDO::PARAM_STR);
    $req -> execute();

    // récupère l'id du message juste créer
    $requete = "SELECT * FROM contacts
                ORDER BY id_contact DESC
                LIMIT 1";
    $req = $bdd->prepare($requete);
    $req -> execute();
    $sortie = $req -> fetch();

    return $sortie['id_contact'];
}
// si le contact est une demande de devis 
function req_save_devis_sm($bdd,$id_contact) {
    $requete = "INSERT INTO devis_sur_mesure (`id_devis_sm`, 
                                              `id_contact`, 
                                              `id_etat`)
                VALUES (0,
                        :id_contact,
                        1)
    ";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':id_contact', $id_contact, PDO::PARAM_INT);
    $req -> execute();
}
// recherche les demandes de devis sur mesure d'un client
function req_devis_sm($bdd) {
    $adresse = req_id_client($bdd);

    $requete = "SELECT * FROM contacts
                INNER JOIN devis_sur_mesure ON contacts.id_contact = devis_sur_mesure.id_contact
                INNER JOIN etat_devis ON devis_sur_mesure.id_etat = etat_devis.id_etat
                WHERE contacts.mail_contact = :mail_client";
    $req = $bdd->prepare($requete);
    $req -> bindValue(':mail_client', $adresse['mail_utilisateur'], PDO::PARAM_STR);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
//------------------------------------------------------------------------
//                                 FAQ
//------------------------------------------------------------------------

// sélectionne toutes les questions
function req_all_faq($bdd) {
    $requete = "SELECT * FROM faq
                WHERE afficher_faq = 1
                ORDER BY position_faq
                ";
    $req = $bdd -> prepare($requete);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
//------------------------------------------------------------------------
//                           QUI sommes nous
//------------------------------------------------------------------------
// récupère tous les paragraphes d'une page fixe
function req_pages_fixes_all_txt($bdd,$id_pf) {
    $requete = "SELECT * FROM textes_pages_fixes
                WHERE id_pf = :id_pf";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
// récupères les images d'une page fixe 
function req_img_pf($bdd,$id_pf) {
    $requete = "SELECT * FROM img_pages_fixes
                INNER JOIN images_sites ON img_pages_fixes.id_img = images_sites.id_img
                WHERE id_pf = :id_pf
    ";
    $req = $bdd -> prepare($requete);
    $req -> bindValue(':id_pf', $id_pf, PDO::PARAM_INT);
    $req -> execute();

    $donnees = $req -> fetchAll();
    return $donnees;
}
?>