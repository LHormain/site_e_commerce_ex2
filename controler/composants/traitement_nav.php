<?php
$sections = req_sections($bdd);

$navigation = "";
$i = 0;

//--------------------------------------------------------------------
// création de la barre nav de la boutique à partir de la bdd
// chaque section a des liens vers les sous catégories
//--------------------------------------------------------------------
foreach ($sections as $lignes) {
    $sous_cat = req_sous_categories($bdd,$lignes['id_section']);

    $navigation .= '
    <li class="nav-item dropdown">
        <a
            class="nav-link dropdown-toggle"
            href="index.php?page=201&s='.$lignes['id_section'].'"
            id="dropdownId'.$lignes['id_section'].'"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            >'.$lignes['nom_section'].'</a
        >
        <div
            class="dropdown-menu"
            aria-labelledby="dropdownId'.$lignes['id_section'].'"
        >';
    foreach ($sous_cat as $ligne) {
        $navigation .= '
                <a class="dropdown-item" href="index.php?page=201&s='.$lignes['id_section'].'&f='.$ligne['id_filtre'].'"
                    >'.$ligne['nom_filtre'].'</a
                >
                ';
    }
    if ($lignes['id_section'] == 3) {
        $navigation .= '
                <a class="dropdown-item" href="index.php?page=211"
                    >Décorations sur mesure</a
                >
                <a class="dropdown-item" href="index.php?page=210"
                    >Partenaires</a
                >
                ';
    }
    $navigation .= '
        </div>
    </li>';
}
?>