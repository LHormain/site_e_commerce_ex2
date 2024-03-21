<?php
//----------------------------------------------------------------------
//                                  pagination
//----------------------------------------------------------------------
// récupération du nombre de page
$nbr_entree = req_nbr_entre_galerie($bdd);

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
    if ($page_courante <= 1) { $pagination .= '"#"';} else { $pagination .= '"index.php?page=220&ep='.($page_courante-1).'"';} // la page courante moins 1
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
    $pagination .= 'm-1" href="index.php?page=220&ep='.$i.'" ';
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
    if ($page_courante >= $nbr_pages) { $pagination .= '"#"';} else { $pagination .= '"index.php?page=220&ep='.($page_courante+1).'"';} // la page courante plus 1
$pagination .= ' >Suivante</a>
            </li>
';

$offset = ($page_courante-1)*$nbr_entree_page;

//------------------------------------------------------------
// récupération des projets finis exposés
//------------------------------------------------------------
$images = req_projets($bdd,$offset,$nbr_entree_page);
$sortie = "";

foreach ($images as $lignes) {
    $sortie .= '
    <a href="index.php?page=221&id='.$lignes['id_projet'].'" class="col-12 col-md-6 col-lg-3 brique position-relative p-3">
        <img src="public/assets/img/site/'.$lignes['nom_img'].'" alt="" class="w-100 h-100 d-block"/>
        <p class="titre text-noir fs-5 m-3  py-1 ps-3 pe-5 w-100 position-absolute">'.$lignes['nom_projet'].'</p>
    </a>
    ';
}

// récupération du texte en haut de la page
$textes = req_pages_fixes_all_txt($bdd,3);
foreach ($textes as $lignes) {
    $texte = $lignes['texte_pf'];
}
?>