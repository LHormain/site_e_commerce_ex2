<?php
//------------------------------------------------------
// création de la page affichant les paniers du client
// connecté
//------------------------------------------------------
// suppression d'un produit
// supprimer un produit du panier
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_panier = intval($_GET['sup']);

    req_sup_produit_panier($bdd,$id_panier);
}
// supprimer un produit du panier location
if (isset($_GET['sup_l']) && $_GET['sup_l'] != NULL) {
    $id_panier_loc = intval($_GET['sup_l']);

    req_sup_produit_panier_loc($bdd,$id_panier_loc);
}

// récupération des paniers ventes et location
$id_commande = $_SESSION['id_commande'];
$id_location = $_SESSION['id_location'];

$panier_v = req_panier_vente($bdd,$id_commande);
$panier_l = req_panier_location($bdd,$id_location);

//    panier vente
        $page_courante = '
        <div class="row">
            <h2 class="fs-5 offset-1 col-10 mb-lg-5 mb-3 text-center text-md-start" id="top">Mes paniers</h2>
            <div class=" offset-1 col-10">
                <h3 class="fs-5">Boutique mobilier, décoration d\'intérieur et reproductions historiques</h3>
                <div
                    class="table-responsive"
                >
                    <table
                        class="table  table-hover table-borderless  align-start"
                    >
                        <thead class="table-light">
                            <caption>
                            </caption>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire HT (€)</th>
                                <th>Sous total TTC (€)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            ';
        $total_HT = 0;
        $total_TTC = 0;
        $TVA = 0;
        foreach ($panier_v as $lignes) {
            $total_HT += $lignes['prix_unitaire']*$lignes['quantite_produit'];
            $total_TTC += $lignes['prix_unitaire']*$lignes['quantite_produit']*(1+20/100);
            $page_courante .= '
            <tr class="">
                <td scope="row" class="text-start ps-5"><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table me-3"></a>'.$lignes['nom_produit'].'</td>
                <td>'.$lignes['quantite_produit'].'</td>
                <td>'.$lignes['prix_unitaire'].'</td>
                <td>'.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'</td>
                <td><a href="index.php?page=400&c=2&sup='.$lignes['id_panier'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
            </tr>
            ';
        }
        // panier location
        $page_courante .= '
                        </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class=" offset-1 col-10">
                <h3 class="fs-5">Boutique location événementiel</h3>
                <div
                    class="table-responsive"
                >
                    <table
                        class="table  table-hover table-borderless  align-start"
                    >
                        <thead class="table-light">
                            <caption>
                            </caption>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire HT (€)</th>
                                <th>Sous total TTC (€)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            ';
        $total_HT = 0;
        $total_TTC = 0;
        $TVA = 0;
        foreach ($panier_l as $lignes) {
            $total_HT += $lignes['prix_unitaire']*$lignes['quantite_produit'];
            $total_TTC += $lignes['prix_unitaire']*$lignes['quantite_produit']*(1+20/100);
            $page_courante .= '
            <tr class="">
                <td scope="row" class="text-start ps-5"><a href="index.php?page=203&c='.$lignes['id_produit'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="modifier"> <img src="public/assets/img/produits/'.$lignes['nom_img_produit'].'" class="img_table me-3"></a>'.$lignes['nom_produit'].'</td>
                <td>'.$lignes['quantite_produit'].'</td>
                <td>'.$lignes['prix_unitaire'].'</td>
                <td>'.number_format($lignes['quantite_produit']*$lignes['prix_unitaire']*(1+20/100),2,'.', ' ').'</td>
                <td><a href="index.php?page=400&c=2&sup_l='.$lignes['id_panier_loc'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="supprimer"><img src="public/assets/img/icones/poubelle.png" class="img-fluid icones" alt="" ></a></td>
            </tr>
            ';
        }
        $page_courante .= '
                        </tbody>
                        <tfoot>
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        ';

?>

