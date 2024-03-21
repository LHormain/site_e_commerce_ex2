<?php
// definition des zones avec les id de la table
    $zone1 = [6,75,140];
    $zone2 = [91,136,76,180,50,188,243,244];
    $zone3 = [153,77,237,78];
    $zone4 = [12,18,31,84,57,55,60,203,68,73,88,101,107,109,123,127,128,135,150,174,175,58,181,197,199,209,210,228,126,190,98];
    $zone5 = [2,4,22,161,125,144,219,204,137,34,86,226,142,242,225];

    // liste des poids existant
    $poids = [250,500,750,1000,2000,5000,1000,15000];

    $table = '';
    for ($i = 0; $i < 8; $i++) {
    $table .= '
    <tr class="">
        <td scope="row">'.$poids[$i].'</td>
        <td><input class="w-55" name="1" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],1).'"></td>
        <td><input class="w-55" name="2" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],2).'"> </td>
        <td><input class="w-55" name="3" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],3).'"> </td>
        <td><input class="w-55" name="4" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],4).'"> </td>
        <td><input class="w-55" name="5" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],5).'"> </td>
        <td><input class="w-55" name="6" id="'.$poids[$i].'" value="'.req_tarif($bdd,$poids[$i],6).'"> </td>
    </tr>
    ';
    }

    $liste_z1 = '';
    for ($i = 0; $i < count($zone1); $i++) {
        $liste_z1 .= req_nom_pays($bdd,$zone1[$i]).' ';
    }

    $liste_z2 = '';
    for ($i = 0; $i < count($zone2); $i++) {
        $liste_z2 .= req_nom_pays($bdd,$zone2[$i]).' ';
    }

    $liste_z3 = '';
    for ($i = 0; $i < count($zone3); $i++) {
        $liste_z3 .= req_nom_pays($bdd,$zone3[$i]).' ';
    }

    $liste_z4 = '';
    for ($i = 0; $i < count($zone4); $i++) {
        $liste_z4 .= req_nom_pays($bdd,$zone4[$i]).' ';
    }

    $liste_z5 = '';
    for ($i = 0; $i < count($zone5); $i++) {
        $liste_z5 .= req_nom_pays($bdd,$zone5[$i]).' ';
    }
?>