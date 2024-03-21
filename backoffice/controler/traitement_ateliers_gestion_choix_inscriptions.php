<?php
// récupération des ateliers dans la BDD
$ateliers = req_tous_ateliers($bdd);
 
$select_atelier = '';
foreach ($ateliers as $donnees) {
    $select_atelier .= '
    <option value="'.$donnees['id_atelier'].'">'.$donnees['nom_atelier'].'</option>
    ';  
}
?>