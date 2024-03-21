<?php
$ateliers = req_txt_tb($bdd);
$images = req_img_tb($bdd);
$logos = req_logo_tb($bdd);
$sortie = "";
$partenaires = "";
$i = 0;

// création du texte de présentation avec ses illustrations
if ($images[1]%$ateliers[1] == 0) {
    $nbr_img_slider = floor($images[1]/$ateliers[1]);
}
else {
    $nbr_img_slider = floor($images[1]/$ateliers[1])+1;
}

foreach ($ateliers[0] as $lignes) {
    $carousel = carousel_tb($images[0],($i)*$nbr_img_slider,($i+1)*$nbr_img_slider-1,'carouselAteliers'.$i);
    $carousel_indicator = $carousel[0];
    $carousel_item = $carousel[1];

    if ($i%2 == 0) {
        $sens = 'flex-row';
    }
    else {
        $sens = 'flex-row-reverse';
    }

    $sortie .= '
    <section class="row my-lg-5 '.$sens.' align-items-center carousel_atelier px-5">
        <div class=" col-md-6 mb-md-5 ">
            <div id="carouselAteliers'.$i.'" class="carousel slide  carousel-dark" data-bs-ride="carousel" >
                <div class="carousel-indicators ">
                    '.$carousel_indicator.'
                </div>
                <div class="carousel-inner" role="listbox">
                    '.$carousel_item.'
                </div>
                <button
                    class="carousel-control-prev "
                    type="button"
                    data-bs-target="#carouselAteliers'.$i.'"
                    data-bs-slide="prev"
                >
                    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselAteliers'.$i.'"
                    data-bs-slide="next"
                >
                    <span class="carousel-control-next-icon " aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </div>
        <div class=" col-md-6 mt-3 mt-md-0 ">
            <h2>'.$lignes['titre_tb_txt'].'</h2>
            <p>'.nl2br($lignes['descriptif_tb_txt']).'</p>
        </div>
    </section>
    ';

    $i++;
}

// liste des entreprises clientes
foreach ($logos[0] as $lignes) {
    $partenaires .= '<img src="'.image_par_default('public/assets/img/site/', $lignes['nom_img']).'" alt="" class="img-fluid w-15">';
}
?>