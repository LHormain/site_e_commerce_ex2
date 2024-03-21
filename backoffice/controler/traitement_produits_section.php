<?php


//---------------------------------------------------------------------
//                           affichage
//---------------------------------------------------------------------
// récupération des section 
$sections = req_sections($bdd);
$select = select_sections($sections,0);

?>