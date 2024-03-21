<?php
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $c = intval($_GET['c']);
    if ($c == 1) {
        //---------------------------------
        // panier vente
        //---------------------------------
        $id_commande = $_SESSION['id_commande'];

        // en tête page
        $titre = "Mon panier";
        $breadcrumb = '
        <li class="breadcrumb-item active fw-bold" aria-current="page">Mon panier</li>
        <li class="breadcrumb-item">Commander</li>
        <li class="breadcrumb-item " >Commande complétée</li>
        ';

        // encart coté
        $sous_titre = "Total panier";
        $sous_sous_titre = "Sans frais de port";
        $txt_btn = '<a href="index.php?page=205" class="btn btn-gris-souris rounded-pill mt-3" role="button">Commander</a>';

        // supprimer un produit du panier
        if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
            $id_panier = intval($_GET['sup']);

            req_sup_produit_panier($bdd,$id_panier);
        }
        // tableau
        $tableau = "";
        $total_HT = 0;
        $total_TTC = 0;
        $TVA = 0;

        $produits = req_panier_vente($bdd,$id_commande);

        foreach ($produits as $lignes) {
            $total_HT += $lignes['prix_unitaire']*$lignes['quantite_produit'];
            $total_TTC += $lignes['prix_unitaire']*$lignes['quantite_produit']*(1+20/100);
            $tableau .= '
            <tr class="table-taupe corps_table_md">
                <td scope="row" class="text-start ps-5"><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table me-3"></a>'.$lignes['nom_produit'].'</td>
                <td>'.$lignes['quantite_produit'].'</td>
                <td>'.$lignes['prix_unitaire'].'</td>
                <td>'.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'</td>
                <td><a href="index.php?page=204&c=1&sup='.$lignes['id_panier'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
            </tr>
            <tr class="table-taupe corps_table_sm">
                <td scope="row" class="text-start p-0 "><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table rounded-pill"></a></td>
                <td>'.$lignes['nom_produit'].'<br>Prix unitaire :'.$lignes['prix_unitaire'].' €<br>Sous total TTC : '.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'<br>Quantité :'.$lignes['quantite_produit'].'</td>
                <td><a href="index.php?page=204&c=1&sup='.$lignes['id_panier'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
            </tr>
            ';
        }
        $TVA = $total_TTC-$total_HT;
    }
    elseif ($c == 2) {
        //------------------------------
        // panier location
        //------------------------------
        $id_commande = $_SESSION['id_location'];

        // en tête page
        $titre = "Ma liste de souhait";
        $breadcrumb = '
        <li class="breadcrumb-item active fw-bold" aria-current="page">Ma liste de souhait</li>
        <li class="breadcrumb-item">Demander un devis</li>
        <li class="breadcrumb-item " >Demande envoyée</li>
        ';

        // encart coté
        $sous_titre = "Estimation provisoire";
        $sous_sous_titre = "";
        $txt_btn = '<a href="index.php?page=212&id='.$id_commande.'" class="btn btn-gris-souris rounded-pill mt-3" role="button">Demander un devis</a>';

        // supprimer un produit du panier
        if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
            $id_panier_loc = intval($_GET['sup']);

            req_sup_produit_panier_loc($bdd,$id_panier_loc);
        }
        // tableau
        $tableau = "";
        $total_HT = 0;
        $total_TTC = 0;
        $TVA = 0;

        $produits = req_panier_location($bdd,$id_commande);

        foreach ($produits as $lignes) {
            $total_HT += $lignes['prix_unitaire']*$lignes['quantite_produit'];
            $total_TTC += $lignes['prix_unitaire']*$lignes['quantite_produit']*(1+20/100);
            $tableau .= '
            <tr class="table-taupe corps_table_md">
                <td scope="row" class="text-start ps-5"><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table me-3"></a>'.$lignes['nom_produit'].'</td>
                <td>'.$lignes['quantite_produit'].'</td>
                <td>'.$lignes['prix_unitaire'].'</td>
                <td>'.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'</td>
                <td><a href="index.php?page=204&c=2&sup='.$lignes['id_panier_loc'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
            </tr>
            <tr class="table-taupe corps_table_sm">
            <td scope="row" class="text-start p-0"><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table  rounded-pill"></a></td>
            <td>'.$lignes['nom_produit'].'<br>Quantité : '.$lignes['quantite_produit'].'<br>Prix unitaire HT : '.$lignes['prix_unitaire'].'€<br>Prix total TTC : '.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'€</td>
            <td><a href="index.php?page=204&c=2&sup='.$lignes['id_panier_loc'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
        </tr>
            ';
        }
        $TVA = $total_TTC-$total_HT;
    }
}

?>