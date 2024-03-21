<?php
// suppression de données
    // paragraphe
    if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
        $id_txt_pf = intval($_GET['sup']);

        req_sup_txt_pf($bdd,$id_txt_pf);
    }
    //image


// récupération des données
    //paragraphe
$textes = req_pages_fixes_all_txt($bdd,5);
$table_texte = "";
foreach ($textes as $lignes) {
    $table_texte .= '
    <tr
        class="table-anticbeige"
    >
        <td scope="row">'.substr($lignes['texte_pf'], 0, 50).'...</td>
        <td><a href="index.php?page=830&c=5&sc=5&id='.$lignes['id_txt_pf'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=300&c=7&sup='.$lignes['id_txt_pf'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}

    // aperçu
$simulation = "";
foreach ($textes as $lignes) {

    $simulation .= '
    <div class=" pe-lg-5 mt-3">';

    $simulation .= '
        <h2 class="text-center fs-5">'.$lignes['titre_pf'].'</h2>
        <p class="">'.nl2br($lignes['texte_pf']).'</p>
        ';
    

}
?>