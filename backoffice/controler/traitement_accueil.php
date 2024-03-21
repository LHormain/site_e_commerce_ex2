<?php
// récupère le nombre de demande de devis sur mesure non lu
$nbr_devis_sm = req_aff_nbr_messages($bdd,' = 1 ');

// récupère le nombre d'autre message non lu
$nbr_contact = req_aff_nbr_messages($bdd,' > 1 ');

//récupère le nombre de demande de devis location non lu
$nbr_devis_loc = req_aff_nbr_devis_loc($bdd);

// récupère le nombre de demande de devis livraison non lu
$nbr_devis_liv = req_aff_nbr_devis_liv($bdd);

// récupère le nombre de commande en attente de livraison
$nbr_livraison = req_aff_nbr_livraison($bdd);
?>