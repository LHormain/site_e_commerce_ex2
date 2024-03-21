<?php
//--------------------------------------------------------------
// barre de navigation latérale
//--------------------------------------------------------------
if (isset($_GET['s']) && $_GET['s'] != NULL) {
    $id_section = intval($_GET['s']);
    // section
    if ($id_section != 4) {
        $section = req_section($bdd,$id_section);
    }
    else {
        $section = array ("nom_section" => '');
    }

    //filtres/sous catégories
    if (isset($_GET['f']) && $_GET['f'] != NULL) {
        $id_sous_cat = intval($_GET['f']);
    }
    else {
        $id_sous_cat = 0;
    }
    $sous_cat = req_sous_categories($bdd,$id_section);

    // catégorie sélectionnée

    if (isset($_GET['c']) && $_GET['c'] != NULL) {
        $id_categorie = intval($_GET['c']);
        if ($id_categorie != 0) {
            $categorie = req_categorie($bdd,$id_categorie);
        }
        else {
            $promotion = req_promo($bdd);
            $categorie = array('nom_categorie' => 'Promotions', 'descriptif_categorie' => nl2br($promotion['texte_promo']).'<br> Réduction de <strong>- '.$promotion['taux_promo'].'%</strong> sur tous les produits présentés sur cette page du <strong>'.date('d-m-Y',$promotion['debut_promo']).'</strong> au <strong>'.date('d-m-Y',$promotion['fin_promo']).'</strong>');
        }

    }

    $liste_sous_cat = "";
    foreach ($sous_cat as $lignes) {
        if ($lignes['id_filtre'] == $id_sous_cat) {
            $etat_sc = 'checked';
        }
        else {
            $etat_sc = '';
        }
        $liste_sous_cat .= '
        <div class="form-check col-lg-6">
            <input class="form-check-input" type="radio" name="theme" id="'.$lignes['id_filtre'].'" value="'.$id_section.'-'.$id_categorie.'" '.$etat_sc.'/>
            <label class="form-check-label" for="'.$lignes['id_filtre'].'"> '.$lignes['nom_filtre'].' </label>
        </div>
        ';
    }

    // catégories pour la nav du coté
    $categories = req_categories($bdd,$id_section,$id_sous_cat);

    $liste_cat = "";
    foreach ($categories as $lignes) {
        $liste_cat .= '
        <li>
            <a href="index.php?page=202&s='.$id_section.'&c='.$lignes['id_cat'].'&f='.$id_sous_cat.'" class="fs-6 fw-bold">
                '.$lignes['nom_categorie'].'
            </a>
        </li>
        ';
    }
// restrictions sur le nombre de résultats
    // promotions
    if (isset($_GET['p']) && $_GET['p'] != NULL) {
        $p = intval($_GET['p']);
        $p_r = '&p='.$p;
    }
    else {
        $p = '';
        $p_r = '';
    }

    // pièces uniques
    if (isset($_GET['u']) && $_GET['u'] != NULL) {
        $u = intval($_GET['u']);
        $u_r = '&u='.$u;
    }
    else {
        $u = '';
        $u_r = '';
    }


//----------------------------------------------------------------------
//                                  pagination
//----------------------------------------------------------------------
// récupération du nombre de page
$routeur = 'c='.$id_categorie.'&f='.$id_sous_cat.'&s='.$id_section.$p_r.$u_r;

$nbr_entree = req_nbr_entre_catalogue($bdd,$id_sous_cat,$id_categorie,$p,$u);

$nbr_entree_page =  12; // nombre de produit affiché par page
if ($nbr_entree != '') {
    $calcul = $nbr_entree/$nbr_entree_page;
    $nbr_pages = ceil($calcul);
}
else {
    $nbr_pages = 0;
}

if (isset($_GET['ep']) && $_GET['ep'] != NULL) {
    $page_courante = htmlspecialchars($_GET['ep']);
}
else
{
    $page_courante = 1;
}

// page précédente
$pagination = '
            <li class="page-item "';
    if ($page_courante <= 1) {
        $pagination .= 'disabled';
    }
$pagination .= '>
                <a class="page-link rounded-pill border-gris-souris text-gris-souris m-1" href=';
    if ($page_courante <= 1) { $pagination .= '"#"';} else { $pagination .= '"index.php?page=202&'.$routeur.'&ep='.($page_courante-1).'"';} // la page courante moins 1
$pagination .= ' >Précédent</a>
            </li>
';
// boucle sur i = 1 à nbr total de page avec lien vers la page i , ep = numero de la page d'entrees
for ($i = 1; $i <= $nbr_pages; $i++ ){
    $pagination .= '
        <li class="page-item "';
    if ($page_courante == $i) {
        $pagination .= 'active';
    }
    $pagination .= '>
                <a class="page-link rounded-pill border-gris-souris ';
    if ($page_courante == $i) {
        $pagination .= 'text-white bg-gris-souris ';
    }
    else {
        $pagination .= 'text-gris-souris ';
    }
    $pagination .= 'm-1" href="index.php?page=202&'.$routeur.'&ep='.$i.'" ';
    if ($page_courante == $i) { $pagination .= 'active';}  
        $pagination .= ' >'.$i.'</a>
            </li>
';
}
// page suivante
$pagination .= '
            <li class="page-item "';
    if ($page_courante >= $nbr_pages) {
        $pagination .= 'disabled';
    }
$pagination .= '>
                <a class="page-link rounded-pill border-gris-souris text-gris-souris m-1" href=';
    if ($page_courante >= $nbr_pages) { $pagination .= '"#"';} else { $pagination .= '"index.php?page=202&'.$routeur.'&ep='.($page_courante+1).'"';} // la page courante plus 1
$pagination .= ' >Suivante</a>
            </li>
';

$offset = ($page_courante-1)*$nbr_entree_page;
//--------------------------------------------------------
// récupération des produits
//--------------------------------------------------------
    $produits = req_produits($bdd,$id_categorie,$id_sous_cat,$offset,$nbr_entree_page,$p,$u);
    $cards_produits = cards_produits($bdd,$produits);
}
?>