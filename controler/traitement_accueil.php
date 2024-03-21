<?php


// affichage des catégories de la boutique
$donnees = req_sections($bdd);
$sections = affiche_sections($donnees);

// affichage des nouveautés
$produits = req_nouveautes($bdd);
$carousel_produit = carousel_produit($bdd,$produits);

// affichage de la présentation des ateliers
$ateliers = req_ateliers($bdd);
$carousel_atelier = carousel_atelier($bdd,$ateliers,'carouselAteliers');
$carousel_indicator = $carousel_atelier[0];
$carousel_item = $carousel_atelier[1];
$texte_ateliers = req_pages_fixes_all_txt($bdd,5);

// récupération de la promotion
$promotion = req_promo($bdd);

//carousel principal en haut de la page
$textes = req_pages_fixes_all_txt($bdd,4);
$images = req_img_pf($bdd,4);

$carousel_indicator_principal = "";
$carousel_inner_principal = "";
$i = 0;
foreach ($textes as $lignes) {
    if (isset($images[$i])) {
        $nom_img = $images[$i]['nom_img'];
        $chemin = 'public/assets/img/site/';
    }
    else {
        $nom_img = '';
        $chemin = '';
    }

    $carousel_indicator_principal .= '
    <li
        data-bs-target="#carouselAccueil"
        data-bs-slide-to="'.$i.'"';
    if ($i == 0) {
        $carousel_indicator_principal .= '
            class="active"
            aria-current="true"';
    }
    $carousel_indicator_principal .= '
        aria-label="slide '.($i+1).'"
    ></li>
    ';

    $carousel_inner_principal .= '
    <div class="carousel-item ';
    if ($i == 0) {
        $carousel_inner_principal .= 'active';
    }
    $carousel_inner_principal .= '">
        <img
            src="'.image_par_default($chemin, $nom_img).'"
            class="w-100 d-block position-relative"
            alt="slide '.($i+1).'"
            title="'.$lignes['titre_pf'].'"
        />
        <div class="carousel-caption d-block">
            <h3>'.$lignes['titre_pf'].'</h3>
            <div class="p">'.$lignes['texte_pf'].'</div>
        </div>
    </div>
    ';


    $i++;
}


?>