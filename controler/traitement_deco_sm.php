<?php
//---------------------------------------------------------
// traitement de la page decoration sur mesure
//---------------------------------------------------------
$textes = req_pages_fixes_all_txt($bdd,2);
$images = req_img_pf($bdd,2);
$simulation = "";
$i = 0;
$j = 0;
foreach ($textes as $lignes) {
    if (isset($images[$j])) {
        $nom_img = $images[$j]['nom_img'];
        $chemin = 'public/assets/img/site/';
    }
    else {
        $nom_img = '';
        $chemin = '';
    }

    if ($i%2 == 0) {
        if ($j%2 == 1) {
            $simulation .= '
            <div class="col-md-4 d-none d-md-flex flex-column justify-content-center align-items-center mt-3">
                <img src="'.image_par_default($chemin, $nom_img).'" class="img-fluid w-75">
            </div>
            ';
        }
        $simulation .= '
        <div class="col-md-8 d-flex flex-column justify-content-evenly pe-lg-5 mt-3">';
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
            <div class="col-md-4 d-flex flex-column justify-content-center align-items-center mt-3">
                <img src="'.image_par_default($chemin, $nom_img).'" class="img-fluid w-75" >
            </div>
            ';
        }
        $j++;
    }

    $i++;
}

?>