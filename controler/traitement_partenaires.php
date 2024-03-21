<?php
$partenaires = req_partenaires($bdd);

$card_partenaires = "";
foreach ($partenaires as $lignes) {
    $card_partenaires .= '
    <div class="card mb-3 col-lg-6 m-0" >
        <div class="row g-0">
            <div class="offset-1 offset-md-0 col-10 col-md-4">
            <img src="public/assets/img/site/'.$lignes['nom_img'].'" class="img-fluid rounded-3" alt="'.$lignes['nom_partenaire'].'">
            </div>
            <div class="offset-1 offset-md-0 col-10 col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><a href="'.$lignes['adresse_site_partenaire'].'" >'.$lignes['nom_partenaire'].'</a></h5>
                    <p class="card-text text-justify">'.$lignes['description_partenaire'].'</p>
                    <p class="card-text">Tel : '.$lignes['tel_partenaire'].'</p>
                    <p class="card-text">Mail : '.$lignes['mail_partenaire'].'</p>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>