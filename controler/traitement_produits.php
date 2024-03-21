<?php
//------------------------------------
//      récupération du produit
//------------------------------------
if (isset($_GET['c']) && $_GET['c'] != NULL) {
    $id_produit = intval($_GET['c']);

    $produit = req_produit($bdd,$id_produit);
    $images = req_images_produit($bdd,$id_produit);

    //images
    $carousel = carousel_produit2($bdd,$images,'carouselPageProduit');
    $carousel_indicator = $carousel[0];
    $carousel_item = $carousel[1];

    if (isset($_SESSION['id_client'])) {
        $img_fav = produit_dans_fav($bdd,$_SESSION['id_client'],$produit['id_produit']);
    }
    else {
        $img_fav['test'] = 0;
    }

    if ($img_fav['test'] == 1) {
        $img_coeur = 'coeur1.png';
    }
    else {
        $img_coeur = 'coeur.png';
    }

    // taux de la promo pour calcul prix après promo
    $promo = req_promo($bdd);
    $taux_promo = $promo['taux_promo'];

    // recuperation de la quantité si produit deja dans panier
    if ($produit['id_section'] == 3) {
        $id_panier = $_SESSION['id_location'];
    }
    else {
        $id_panier = $_SESSION['id_commande'];
    }
    $test_panier = req_produit_dans_panier($bdd,$id_produit,$id_panier,$produit['id_section']);

    if ($test_panier[1] != 0) {
        $qte_produit = $test_panier[0]['quantite_produit'];
    }
    else {
        $qte_produit = 1;
    }

    //couleurs
    $couleurs = req_couleurs_produit($bdd,$id_produit);
    $prix_couleur = '';
    $couleur_select = '';
    if ($couleurs[1] == 1 && $produit['customisable'] == 0) {
        // produit non customizable avec couleur
        $couleur = $couleurs[0][0]['nom_couleur'];
        $couleur_select = $couleurs[0][0]['id_couleur'];
    }
    elseif ($couleurs[1] == 0 && $produit['customisable'] == 0) {
        // produit non customizable sans couleur
        $couleur = '';
    }
    else {
        // produit customizable écriture du select
        $couleur = '<select class="form-select form-select-lg py-0 my-0 rounded-pill" name="couleur" id="couleur">';
        foreach ($couleurs[0] as $lignes) {
            if ($test_panier[1] != 0) {
                // si produit deja dans panier présélectionne les bonnes options
                if ($lignes['id_couleur'] == $test_panier[0]['id_couleur']) {
                    $option = 'selected';
                }
                else {
                    $option = '';
                }
            }
            else {
                $option = '';
            }

            $couleur .= '<option value="'.$lignes['id_couleur'].'" '.$option.'>'.$lignes['nom_couleur'].'</option>';
            $prix_couleur .= '<input type="hidden" id="pc'.$lignes['id_couleur'].'" value="'.$lignes['prix_customisation'].'">';
        }
        $couleur .= '</select>';
        // récupération de la valeur pour l'ajout au panier
        if ($test_panier[1] != 0) {
            $couleur_select = $test_panier[0]['id_couleur'];
        }
        else {
            $couleur_select = $couleurs[0][0]['id_couleur'];
        }
    }

    //matières
    $matieres = req_matieres_produit($bdd,$id_produit);
    $prix_matiere = '';
    $matiere_select = '';
    if ($matieres[1] == 1 && $produit['customisable'] == 0) {
        $matiere = $matieres[0][0]['nom_matiere'];
        $matiere_select = $matieres[0][0]['id_matiere'];
    }
    elseif ($matieres[1] == 0 && $produit['customisable'] == 0) {
        $matiere = '';
    }
    else {
        $matiere = '<select class="form-select form-select-lg py-0 my-0 rounded-pill" name="matiere" id="matiere">';
        foreach ($matieres[0] as $lignes) {
            if ($test_panier[1] != 0) {
                // si produit deja dans panier présélectionne les bonnes options
                if ($lignes['id_matiere'] == $test_panier[0]['id_matiere']) {
                    $option = 'selected';
                }
                else {
                    $option = '';
                }
            }
            else {
                $option = '';
            }
            $matiere .= '
            <option value="'.$lignes['id_matiere'].'" '.$option.'>'.$lignes['nom_matiere'].'</option>
            ';
            $prix_matiere .= '
            <input type="hidden" id="pm'.$lignes['id_matiere'].'" value="'.$lignes['prix_customisation'].'">
            ';
        }
        $matiere .= '</select>';
        // récupération de la valeur pour l'ajout au panier
        if ($test_panier[1] != 0) {
            $matiere_select = $test_panier[0]['id_matiere'];
        }
        else {
            $matiere_select = $matieres[0][0]['id_matiere'];
        }
    }

    //tailles
    $taille_produit = req_dimensions_produit($bdd,$id_produit);
    $prix_taille = '';
    $taille2 = '<td></td>';
    $taille_select = '';
    $autre_taille_select = '';
    $autre_taille_valeur = '';
    
    if ($produit['customisable'] == 1) {
        $tailles = req_tailles_produit($bdd,$id_produit);
        if ($tailles[1] != 0) {
            $taille2 = '';
            foreach ($tailles[0] as $lignes) {
                if ($test_panier[1] != 0) {
                    // si produit deja dans panier présélectionne les bonnes options
                    if ($lignes['id_autre_taille'] == $test_panier[0]['id_autre_taille']) {
                        $valeur = $test_panier[0]['autres_tailles_choix'];
                    }
                    else {
                        $valeur = $lignes['min_var_taille'];
                    }
                }
                else {
                    $valeur = $lignes['min_var_taille'];
                }
                $taille2 .= '
                <td>
                    '.$lignes['nom_taille'].' : 
                    <input type="number" id="'.$lignes['id_autre_taille'].'" name="'.$lignes['id_autre_taille'].'" min="'.$lignes['min_var_taille'].'" max="'.$lignes['max_var_taille'].'" step="'.$lignes['step_taille'].'" value="'.$valeur.'" class="taille">
                    <input type="hidden" id="pt'.$lignes['id_autre_taille'].'" value="'.$lignes['prix_customisation'].'">
                </td>
                ';
            }
            // récupération de la valeur pour l'ajout au panier
            if ($test_panier[1] != 0) {
                $autre_taille_select = $test_panier[0]['id_autre_taille'];
                $autre_taille_valeur = $test_panier[0]['autres_tailles_choix'];
            }
            else {
                $autre_taille_select = $tailles[0][0]['id_autre_taille'];
                $autre_taille_valeur = $tailles[0][0]['min_var_taille'];
            }
        }
        // récupération de la valeur pour l'ajout au panier
        if ($test_panier[1] != 0) {
            $taille_select = $test_panier[0]['id_taille'];
        }
        else {
            $taille_select = $taille_produit[0][0]['id_taille'];
        }
        $taille = '
        <td colspan=3>
            <select class="form-select form-select-lg py-0 my-0 rounded-pill" name="dimension" id="dimension">';
        foreach ($taille_produit[0] as $lignes) {
            if ($test_panier[1] != 0) {
                // si produit deja dans panier présélectionne les bonnes options
                if ($lignes['id_taille'] == $test_panier[0]['id_taille']) {
                    $option = 'selected';
                }
                else {
                    $option = '';
                }
            }
            else {
                $option = '';
            }
            $taille .= '
            <option value="'.$lignes['id_taille'].'" '.$option.'>'.$lignes['longueur'].' x '.$lignes['largeur'].' x '.$lignes['hauteur'].'</option>';
            $prix_taille .= '
            <input type="hidden" id="ptd'.$lignes['id_taille'].'" value="'.$lignes['prix_customisation'].'">
            ';
        }
        $taille .= '
            </select>
        </td>';
        

    }
    else {
        $tailles[1] = 0;
        if (isset($taille_produit[0][0]['longueur']) && isset($taille_produit[0][0]['largeur']) && isset($taille_produit[0][0]['hauteur'])) {
            $taille = '
            <td> '.$taille_produit[0][0]['longueur'].'</td>
            <td>x'.$taille_produit[0][0]['largeur'].'</td>
            <td>x'.$taille_produit[0][0]['hauteur'].'</td>
            ';
            // récupération de la valeur pour l'ajout au panier
            $taille_select = $taille_produit[0][0]['id_taille'];
        }
        else {
            $taille = '
            <td></td>
            <td></td>
            <td></td>
            ';
        }
    }

    // autre customisation 
    $prix_custom = '';
    $custom_select = '';
    if ($produit['customisable'] == 1) {
        $customs = req_customs_produit($bdd,$id_produit);
        if ($customs[1] != 0) {
            $custom = '<select class="form-select form-select-lg py-0 my-0 rounded-pill" name="custom" id="custom">';
            foreach ($customs[0] as $lignes) {
                if ($test_panier[1] != 0) {
                    // si produit deja dans panier présélectionne les bonnes options
                    if ($lignes['id_custom'] == $test_panier[0]['id_custom']) {
                        $option = 'selected';
                    }
                    else {
                        $option = '';
                    }
                }
                else {
                    $option = '';
                }
                $custom .= '<option value="'.$lignes['id_custom'].'" '.$option.'>'.$lignes['nom_custom'].'</option>';
                $prix_custom .= '<input type="hidden" id="pac'.$lignes['id_custom'].'" value="'.$lignes['prix_customisation'].'">';
            }
            $custom .= '</select>';
            // récupération de la valeur pour l'ajout au panier
            if ($test_panier[1] != 0) {
                $custom_select = $test_panier[0]['id_custom'];
            }
            else {
                $custom_select = $customs[0][0]['id_custom'];
            }
        }
        else {
            $custom = '
            <select class="form-select form-select-lg py-0 my-0 rounded-pill" name="custom" id="custom">
                <option value="0"></option>
            </select>';
            $prix_custom .= '<input type="hidden" id="pac0" value="0">';
        }
    }
    else {
        $customs[1]=0;
        $custom = '
        <select class="form-select form-select-lg py-0 my-0 rounded-pill" name="custom" id="custom">
            <option value="0"></option>
        </select>';
        $prix_custom .= '<input type="hidden" id="pac0" value="0">';
    }


    //----------------------------------------------------------------------
    //                      récupération des suggestions
    //----------------------------------------------------------------------
    $suggestions = req_suggestion_produits($bdd,$produit['id_cat']);
    $liste_produits = cards_produits($bdd,$suggestions);
}

?>