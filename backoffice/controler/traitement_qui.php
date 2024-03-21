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
$textes = req_pages_fixes_all_txt($bdd,1);
$table_texte = "";
foreach ($textes as $lignes) {
    $table_texte .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row">'.$lignes['titre_pf'].'</td>
        <td><a href="index.php?page=830&c=5&sc=1&id='.$lignes['id_txt_pf'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=830&c=1&sup='.$lignes['id_txt_pf'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}
    //images

$images = req_img_pf($bdd,1);
$table_image = "";
foreach ($images as $lignes) {
    $table_image .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row"><img src="../public/assets/img/site/'.$lignes['nom_img'].'" class="mignature_table" ></td>
        <td><a href="index.php?page=830&c=6&sc=1&id='.$lignes['id_img'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=830&c=1&supi='.$lignes['id_img'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}

    // aperçu
$simulation = "";
$i = 0;
$j = 0;
foreach ($textes as $lignes) {
    if (isset($images[$j])) {
        $nom_img = $images[$j]['nom_img'];
        $chemin = '../public/assets/img/site/';
    }
    else {
        $nom_img = '';
        $chemin = '';
    }

    if ($i%2 == 0) {
        if ($j%2 == 1) {
            $simulation .= '
            <div class="col-lg-4 d-flex flex-column justify-content-evenly mt-3">
                <img src="'.image_par_default($chemin, $nom_img).'" class="img-fluid">
            </div>
            ';
        }
        $simulation .= '
        <div class="col-lg-8 d-flex flex-column justify-content-evenly pe-lg-5 mt-3">';
    }

    $simulation .= '
        <h2 class="text-center fs-5">'.$lignes['titre_pf'].'</h2>
        <p class="">'.$lignes['texte_pf'].'</p>
        ';
    
    if ($i%2 == 1) {
        $simulation .= '
        </div>';
        if ($j%2 == 0) {
            $simulation .= '
            <div class="col-lg-4 d-flex flex-column justify-content-evenly mt-3">
                <img src="'.image_par_default($chemin, $nom_img).'" class="img-fluid" >
            </div>
            ';
        }
        $j++;
    }

    $i++;
}
?>