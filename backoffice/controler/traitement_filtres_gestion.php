<?php

$table = 'couleurs';
$table_gestion = '';
// supprimer
if (isset($_GET['sup'],
        $_GET['t'])
&& $_GET['sup'] != NULL
&& $_GET['t'] != NULL
) {
    $id_custom = intval($_GET['sup']);
    $table = htmlspecialchars($_GET['t']);

    if ($table == 'couleurs') {
        // efface la ligne
        req_couleur_sup($bdd,$id_custom);
        // récupère toutes les lignes restante ordonner par ordre d'affichage
        $donnees = req_couleurs($bdd,' ORDER BY ordre_affichage ');
        // mise à jour des ordres d'affichage pour pas de trou
        req_couleurs_update_ordre($bdd,$donnees);
    }
    elseif ($table == 'matieres') {
        // efface la ligne
        req_matiere_sup($bdd,$id_custom);
        // récupère toutes les lignes restante ordonner par ordre d'affichage
        $donnees = req_matieres($bdd,' ORDER BY ordre_affichage ');
        // mise à jour des ordres d'affichage pour pas de trou
        req_matieres_update_ordre($bdd,$donnees);
    }
    elseif ($table == 'autres_tailles') {
        // efface la ligne
        req_taille_sup($bdd,$id_custom);
        // récupère toutes les lignes restante ordonner par ordre d'affichage
        $donnees = req_tailles($bdd,' ORDER BY ordre_affichage ');
        // mise à jour des ordres d'affichage pour pas de trou
        req_tailles_update_ordre($bdd,$donnees);
    }
    elseif ($table == 'customisations') {
        // efface la ligne
        req_customisation_sup($bdd,$id_custom);
        // récupère toutes les lignes restante ordonner par ordre d'affichage
        $donnees = req_customisations($bdd,' ORDER BY ordre_affichage ');
        // mise à jour des ordres d'affichage pour pas de trou
        req_customisations_update_ordre($bdd,$donnees);
    }
}

//-------------------------------------------------------------------------------
// traitement du select de la table de customisation qui va être consulté
//-------------------------------------------------------------------------------
if (isset($_POST['table']) && $_POST['table'] != NULL) {
    $table = htmlspecialchars($_POST['table']);
    $ordre_req = '';

    $donnees = req_filtres($bdd,$table,$ordre_req);

    foreach ($donnees as $lignes) {
        if ($table == 'couleurs' || $table == 'matieres') {
            $nom_img = '<td><img src="../public/assets/img/site/'.$lignes[2].'" class="mignature_table" ></td>';
            $position = $lignes[3];
        }
        else {
            $nom_img = '';
            $position = $lignes[2];
        }
        $table_gestion .= '
        <tr>
            <td>'.$lignes[1].'</td>
            <td id="'.$lignes[0].'"><input type="text" id="position'.$lignes[0].'" name="'.$table.'" value="'.$position.'" class="input_dispo"></td>
            '.$nom_img.'
            <td><a href="index.php?page=510&c=2&id='.$lignes[0].'&t='.$table.'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=510&c=1&sup='.$lignes[0].'&t='.$table.'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }

}
//-------------------------------------------------------------------------------
// affichage du tableau quand on réarrange l'ordre d'affichage
//-------------------------------------------------------------------------------
elseif (isset($_GET['table']) && $_GET['table']) {
    $table = htmlspecialchars($_GET['table']);
    
    // recuperation de l'ordre de classement
    if (isset($_GET['ordre']) && $_GET['ordre'] != NULL) {
        $ordre = intval($_GET['ordre']);

        if ($ordre == 1) {
            if ($table == 'couleurs') {
                $ordre_req = 'ORDER BY nom_couleur';
            }
            elseif ($table == 'matieres') {
                $ordre_req = 'ORDER BY nom_matiere';
            }
            elseif ($table == 'autres_tailles') {
                $ordre_req = 'ORDER BY nom_taille';
            }
            elseif ($table == 'customisations') {
                $ordre_req = 'ORDER BY nom_custom';
            }
            else {
                $ordre_req = '';
            }
        }
        elseif ($ordre == 2) {
            $ordre_req = 'ORDER BY ordre_affichage';
        }
        else {
            $ordre_req = '';
        }
    }
    else {
        $ordre_req = '';
    }
    $donnees = req_filtres($bdd,$table,$ordre_req);

    foreach ($donnees as $lignes) {
        if ($table == 'couleurs' || $table == 'matieres') {
            $nom_img = '<td><img src="../public/assets/img/site/'.$lignes[2].'" class="mignature_table" ></td>';
            $position = $lignes[3];
        }
        else {
            $nom_img = '';
            $position = $lignes[2];
        }
        $table_gestion .= '
        <tr>
            <td>'.$lignes[1].'</td>
            <td id="'.$lignes[0].'"><input type="text" id="position'.$lignes[0].'" name="'.$table.'" value="'.$position.'" class="input_dispo"></td>
            '.$nom_img.'
            <td><a href="index.php?page=510&c=2&id='.$lignes[0].'&t='.$table.'"><img src="public/assets/img/roue-dentee.png" class="icones_table modifier" alt=""></a></td>
            <td><a href="index.php?page=510&c=1&sup='.$lignes[0].'&t='.$table.'" onclick="return(confirm(\'Voulez vous supprimer cette entrée ?\'))"><img src="public/assets/img/poubelle.png" class="icones_table supprimer" alt=""></a></td>
        </tr>
        ';
    }
}
?>