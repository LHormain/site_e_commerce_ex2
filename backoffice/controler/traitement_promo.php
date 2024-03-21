<?php
$texte_page_courante ='';
//-----------------------------------------------------------
// récupération des catégorie pouvant être mise en promo
//-----------------------------------------------------------
$table = "";

$section = req_section($bdd,1);
$categories = req_categories($bdd,1);
foreach ($categories as $lignes) {
    if ($lignes['promo_categorie'] == 1) {
        $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_section'].'" value="'.$lignes['promo_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button>';
    }
    else {
        $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_section'].'" value="'.$lignes['promo_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button>';
    }
    $table .= '
    <tr class="table-anticbeige">
        <td scope="row">'.$section['nom_section'].'</td>
        <td>'.$lignes['nom_categorie'].'</td>
        <td>'.$affichage.'</td>
    </tr>
    ';
}

$section = req_section($bdd, 2);
$categories = req_categories($bdd,2);
foreach ($categories as $lignes) {
    if ($lignes['promo_categorie'] == 1) {
        $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_cat'].'" value="'.$lignes['promo_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button>';
    }
    else {
        $affichage = '<button type="button" class="btn btn-link btn_aff" id="'.$lignes['id_cat'].'" value="'.$lignes['promo_categorie'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button>';
    }
    $table .= '
    <tr class="table-anticbeige">
        <td scope="row">'.$section['nom_section'].'</td>
        <td>'.$lignes['nom_categorie'].'</td>
        <td>'.$affichage.'</td>
    </tr>
    ';
}

//----------------------------------------------------------------
// traitement du formulaire
//----------------------------------------------------------------
if (isset($_POST['debut_promo'],
$_POST['fin_promo'],
$_POST['taux_promo'],
$_POST['texte_promo'],
$_POST['afficher_promo']
)
&& $_POST['debut_promo'] != NULL
&& $_POST['fin_promo'] != NULL
&& $_POST['taux_promo'] != NULL
&& $_POST['texte_promo'] != NULL
&& $_POST['afficher_promo'] != NULL
) {
    $debut_promo = strtotime(htmlspecialchars($_POST['debut_promo']));
    $fin_promo = strtotime(htmlspecialchars($_POST['fin_promo']));
    $taux_promo = htmlspecialchars($_POST['taux_promo']);
    $texte_promo = htmlspecialchars($_POST['texte_promo']);
    $afficher_promo = htmlspecialchars($_POST['afficher_promo']);

    // mise à jour de la promo
    req_update_promo($bdd,$debut_promo,$fin_promo,$taux_promo,$texte_promo,$afficher_promo);
    
    $texte_page_courante = 'Information enregistrées.';
}

//----------------------------------------------------------------
// récupération des données pour le formulaire
//----------------------------------------------------------------
$promotion = req_promo($bdd);
?>