<?php
// supprimer un paragraphe
if (isset($_GET['supt']) && $_GET['supt'] != NULL) {
    $id_tb_txt = intval($_GET['supt']);

    req_sup_tb_txt($bdd,$id_tb_txt);
}

// affichage
$texte = req_tb_txt($bdd);

$table_texte = table_tb_txt($texte);
$sortie = appecu_tb_txt($texte);

?>