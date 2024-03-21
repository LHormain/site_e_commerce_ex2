<?php
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_commande = intval($_GET['id']);

    if (isset($_GET['c']) && $_GET['c'] != NULL) {
        $c = intval($_GET['c']);

        if (isset($_GET['table']) && $_GET['table'] != NULL) {
            $table = intval($_GET['table']);
            // en fonction de la table où le panier est rangé
            if ($table == 0) {
                $panier = req_panier_location($bdd,$id_commande);
            }
            else {
                $panier = req_commande_location($bdd,$id_commande);
            }

        }
        $titre = 'Panier';

        if ($c == 1) {
            // renvoie aux paniers
            if ($table = 0) {
                $page = 700;
            }
            else {
                // renvoie aux commandes
                $page = 730;
            }
        }
        elseif ($c == 2) {
            // renvoie à la gestion des devis
            $page = 720;
        }
        elseif ($c == 3) {
            // renvoie au devis precis
            $devis = req_devis_avec_panier($bdd,$id_commande);
            $page = '721&id='.$devis['id_devis'];
        }

        $table = '';
        $prix = 0;
        foreach ($panier[0] as $ligne) {
            $sous_total = $ligne['quantite_produit']*$ligne['prix_unitaire'];
            $prix += $sous_total;

            $table .= '
            <tr class="table-anticbeige">
                <td>'.$ligne['id_produit'].'</td>
                <td>'.$ligne['nom_produit'].'</td>
                <td>'.$ligne['quantite_produit'].'</td>
                <td>'.$ligne['prix_unitaire'].'</td>
                <td>'.number_format($sous_total,2,'.', ' ').'</td>
                <td>'.number_format($sous_total*(1+20/100),2,'.',' ').'</td>
            </tr>
            ';
        }
    }
}
?>