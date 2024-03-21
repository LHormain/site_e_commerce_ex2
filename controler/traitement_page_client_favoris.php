<?php
//-----------------------------------------------------------------------
// création de la page contenant les favoris du 
// client connecté
//-----------------------------------------------------------------------
$id_user = req_id_client($bdd);

// récupération de la catégorie de favoris à afficher
if (isset($_GET['s']) && $_GET['s'] != NULL) {
    $id_section = intval($_GET['s']);
}
else {
    $id_section = 2;
}
//------------------
// pagination
//------------------
// récupération du nombre de page
$routeur = '';

$nbr_entree = req_nbr_entre_favoris($bdd,$id_user['id_user'],$id_section);

$nbr_entree_page =  6; // nombre de produit affiché par page
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

//-----------------------------------
//   récupération des favoris
//-----------------------------------
    $produits = req_produits_fav($bdd,$id_user['id_user'],$offset,$nbr_entree_page,$id_section);
    $cards_produits = cards_produits($bdd,$produits);

    // écriture de la page
        $page_courante = '
        <div class="row">
            <h2 class="fs-5 offset-1 col-10 mb-lg-5 mb-3 text-center text-md-start" id="top">Mes favoris</h2>
            <div class="offset-1 col-10 d-flex flex-column flex-md-row justify-content-between mb-3">
                <a href="index.php?page=400&c=5&s=1" class="btn btn-gris-souris rounded-pill mb-3 mb-md-0">Reproductions historiques</a>
                <a href="index.php?page=400&c=5&s=2" class="btn btn-gris-souris rounded-pill mb-3 mb-md-0">Mobilier et décoration d\'intérieur</a>
                <a href="index.php?page=400&c=5&s=3" class="btn btn-gris-souris rounded-pill mb-3 mb-md-0">Évènementiel</a>
            </div>
            '.$cards_produits.'
            <nav aria-label="Page navigation " class="d-flex justify-content-center my-5">
                <ul class="pagination ">
                    '.$pagination.'
                </ul>
            </nav>
        </div>
        ';

?>
