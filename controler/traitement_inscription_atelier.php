<?php
// récupération du client
$client = req_id_client($bdd);

// récupération des données de l'atelier
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_atelier = intval($_GET['id']);

    $atelier = req_atelier($bdd,$id_atelier);
    $horaires = req_horaires_atelier($bdd,$id_atelier);

    //liste des ateliers auquel le client est déjà inscrit
    $liste = req_ateliers_client($bdd,$client['id_user'],$id_atelier);

    // liste des créneaux disponible pour cet atelier
    $crenaux = "";
    foreach ($horaires as $lignes) {

        $nbr_places = $atelier['nbr_participant_max'] - $lignes['nbr_participant'];
        if ($nbr_places == 0) {
            $etat = 'disabled';
            $message='Plus de places disponible';
        }
        elseif(in_array($lignes['id_date'],$liste)) {
            $etat = 'disabled';
            $message = 'Vous êtes déjà inscrit.';
        }
        else {
            $etat = '';
            $message = '';
        }

        $crenaux .= '
        <div class="form-check">
            <input class="form-check-input" type="radio" name="date_atelier" id="'.$lignes['id_date'].'" value="'.$lignes['id_date'].' "'.$etat.' />
            <label class="form-check-label" for="'.$lignes['id_date'].'"> Le '.date('d-m-Y à H:i',$lignes['date_atelier']).', reste '.$nbr_places.' places. '.$message.'</label>
        </div>
        ';
    }
}

?>