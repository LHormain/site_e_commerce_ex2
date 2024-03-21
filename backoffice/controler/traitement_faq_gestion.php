<?php
// suppression
if (isset($_GET['sup']) && $_GET['sup'] != NULL) {
    $id_faq = intval($_GET['sup']);
    req_sup_faq($bdd,$id_faq);
}

// affichage
$faq = req_all_faq($bdd);
$table = "";
foreach ($faq[0] as $lignes) {
    if ($lignes['afficher_faq'] == 1) {
        $afficher = '<td><button type="button" class="btn btn-link btn_aff_txt" id="txt'.$lignes['id_faq'].'" value="'.$lignes['afficher_faq'].'"><img src="public/assets/img/verifier.png" class="icones_table afficher" alt=""></button></td>';
    }
    else {
        $afficher = '<td><button type="button" class="btn btn-link btn_aff_txt" id="txt'.$lignes['id_faq'].'" value="'.$lignes['afficher_faq'].'"><img src="public/assets/img/verifier.png" class="icones_table non_afficher" alt=""></button></td>';
    }
    $table .= '
    <tr class="table-anticbeige" >
        <td scope="row">'.$lignes['question_faq'].'</td>
        <td  id="'.$lignes['id_faq'].'"><input type="text" id="position'.$lignes['id_faq'].'" value="'.$lignes['position_faq'].'" class="input_dispo"></td>
        '.$afficher.'
        <td><a href="index.php?page=840&c=2&id='.$lignes['id_faq'].'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
        <td><a href="index.php?page=840&c=1&sup='.$lignes['id_faq'].'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt="" ></a></td>
    </tr>
    ';
}
?>