<?php
// création du plan de la boutique
$sections = req_sections($bdd);
$liens_boutiques = "";

foreach ($sections as $lignes) {
    $sous_cat = req_sous_categories($bdd,$lignes['id_section']);

    $liens_boutiques .= '<li>
                            <a href="index.php?page=201&s='.$lignes['id_section'].'" class="fs-5">'.$lignes['nom_section'].'</a>
                            <ul>';
    foreach ($sous_cat as $key) {
        $liens_boutiques .= '<li><a href="index.php?page=202&s='.$lignes['id_section'].'&c='.$key['id_filtre'].'" class="fs-5">'.$key['nom_filtre'].'</a></li>
        ';
    }
    $liens_boutiques .= '
                            </ul>
                        </li>
    ';
}
?>