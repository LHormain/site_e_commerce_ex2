<?php
// texte en tête
$texte_ateliers = req_pages_fixes_all_txt($bdd,5);
// contenu de la page
$ateliers = req_ateliers($bdd);
$sortie = "";
$i = 0;

foreach ($ateliers as $lignes) {
    $carousel = carousel_atelier2($bdd,$lignes['id_atelier'],'carouselAteliers'.$i);
    $carousel_indicator = $carousel[0];
    $carousel_item = $carousel[1];

    $dates = req_horaires_atelier($bdd,$lignes['id_atelier']);
    $liste_dates = dates_ateliers ($dates,$lignes['nbr_participant_max'],$lignes['duree_atelier']);

    if ($i%2 == 0) {
        $sens = 'flex-row';
    }
    else {
        $sens = 'flex-row-reverse';
    }

    // le client doit être connecté pour s'inscrire à un atelier
    if (isset($_SESSION['id_client'])) {
        $page = '320&id='.$lignes['id_atelier'];
        $txt_page = 'S\'inscrire';
    }
    else {
        $page = '310&ins=1';
        $txt_page = 'Connexion';
    }

    $sortie .= '
    <section class="row my-lg-5 '.$sens.' align-items-center carousel_atelier px-5">
        <div class="col-lg-6 mb-lg-5 mb-3">
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
        <div class="col-lg-6 mb-5 px-3 px-md-5 px-lg-0">
            <h2>'.$lignes['nom_atelier'].'</h2>
            <p>'.$lignes['descriptif_atelier'].'</p>
            <aside class="bg-taupe ">
                <h3 class="text-center mt-3 pt-3">Dates</h3>
                <div class="row">
                    <ul class="col-lg-8 text-center">'.$liste_dates.' </ul>
                    <div class="col-lg-4 py-2 text-center">
                        <a href="index.php?page='.$page.'" class="btn btn-gris-souris rounded-pill">'.$txt_page.'</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
    ';

    $i++;
}

if ($i == 0) {
    $sortie = '<p class="text-center py-3">Nous vous remercions de votre visite sur notre site ! Actuellement, la section que vous avez sélectionnée est en cours de construction et les ateliers ne sont pas encore disponibles. Nous travaillons activement pour ajouter de nouvelles dates et nous nous excusons pour tout inconvénient que cela pourrait causer. Restez à l\'écoute, car nous avons hâte de vous présenter nos nouveaux ateliers très bientôt !</p>';
}
?>