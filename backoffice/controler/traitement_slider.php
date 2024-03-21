<?php
// suppression de données
    // paragraphe
    if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
        $id_txt_pf = intval($_GET['sup']);

        req_sup_txt_pf($bdd,$id_txt_pf);
    }
    //image
    if (isset($_GET['supi']) && $_GET['supi'] != NULL) {
        $id_img_pf = intval($_GET['supi']);

        req_sup_img_pf($bdd,$id_img_pf,1);
    }

// récupération des données
    //paragraphe
$textes = req_pages_fixes_all_txt($bdd,4);
$table_texte = "";
foreach ($textes as $lignes) {
    $table_texte .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row">'.$lignes['titre_pf'].'</td>
        <td><a href="index.php?page=830&c=5&sc=4&id='.$lignes['id_txt_pf'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=830&c=1&sup='.$lignes['id_txt_pf'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}
    //images

$images = req_img_pf($bdd,4);
$table_image = "";
foreach ($images as $lignes) {
    $table_image .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table" ></td>
        <td><a href="index.php?page=830&c=6&sc=4&id='.$lignes['id_img'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=830&c=1&supi='.$lignes['id_img'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}

    // aperçu
$carousel_indicator = "";
$carousel_inner = "";
$i = 0;
foreach ($textes as $lignes) {
    if (isset($images[$i])) {
        $nom_img = $images[$i]['nom_img'];
        $chemin = '../public/assets/img/site/';
    }
    else {
        $nom_img = '';
        $chemin = '';
    }

    $carousel_indicator .= '
    <li
        data-bs-target="#carouselAccueil"
        data-bs-slide-to="'.$i.'"';
    if ($i == 0) {
        $carousel_indicator .= '
            class="active"
            aria-current="true"';
    }
    $carousel_indicator .= '
        aria-label="slide '.($i+1).'"
    ></li>
    ';

    $carousel_inner .= '
    <div class="carousel-item ';
    if ($i == 0) {
        $carousel_inner .= 'active';
    }
    $carousel_inner .= '">
        <img
            src="'.image_par_default($chemin, $nom_img).'"
            class="w-100 d-block position-relative"
            alt="slide '.($i+1).'"
            title="'.$lignes['titre_pf'].'"
        />
        <div class="carousel-caption d-block">
            <h3>'.$lignes['titre_pf'].'</h3>
            <p>'.$lignes['texte_pf'].'</p>
        </div>
    </div>
    ';


    $i++;
}
?>