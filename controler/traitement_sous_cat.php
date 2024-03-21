<?php
//----------------------------
// Page sous catégorie
//----------------------------
if (isset($_GET['s']) && $_GET['s'] != NULL) {
    $id_section = intval($_GET['s']);
    // section
    $section = req_section($bdd,$id_section);

    //filtres/sous catégories
    if (isset($_GET['f']) && $_GET['f'] != NULL) {
        $id_sous_cat = intval($_GET['f']);
    }
    else {
        $id_sous_cat = 0;
    }
    $sous_cat = req_sous_categories($bdd,$id_section);

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
            <input class="form-check-input" type="radio" name="theme" id="'.$lignes['id_filtre'].'" value="'.$id_section.'" '.$etat_sc.'/>
            <label class="form-check-label" for="'.$lignes['id_filtre'].'"> '.$lignes['nom_filtre'].' </label>
        </div>
        ';
    }

    // catégorie
    $categories = req_categories($bdd,$id_section,$id_sous_cat);

    $card_cat = "";
    $liste_cat = "";
    foreach ($categories as $lignes) {
        $liste_cat .= '
        <li>
            <a href="index.php?page=202&s='.$id_section.'&c='.$lignes['id_cat'].'&f='.$id_sous_cat.'" class="fs-6 fw-bold">
                '.$lignes['nom_categorie'].'
            </a>
        </li>
        ';

        $card_cat .= '
        <div class="offset-lg-1 col-lg-4 card_cat_filtre">
            <a href="index.php?page=202&s='.$id_section.'&f='.$id_sous_cat.'&c='.$lignes['id_cat'].'" class="card text-start  text-center">
                <img class="card-img-top rounded-3" src="public/assets/img/site/'.$lignes['nom_img'].'" alt="'.$lignes['nom_categorie'].'" />
                <div class="card-body">
                    <h4 class="card-title">'.$lignes['nom_categorie'].'</h4>
                </div>
            </a>
        </div>
        ';
    }


}
?>