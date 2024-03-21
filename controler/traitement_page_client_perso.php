<?php
//--------------------------------------------------
// création de la page contenant les informations 
// personnelles du clients connecté
//--------------------------------------------------
// récupération des adresses
$facturation = req_adresses_client($bdd,$client['id_user'], 1);
$livraison = req_adresses_client($bdd,$client['id_user'], 2);

$adresses_fac = '<div class="row">';
$i = 1;
foreach ($facturation as $ligne) {
    $adresses_fac .= '
        <div class="col-1">'.$i.'</div>
        <div class="col-4">
            '.$ligne['numero_adresse'].' '.$ligne['rue_adresse'].' '.$ligne['complement_adresse'].'<br>'.$ligne['code_postal_adresse'].' '.$ligne['ville_adresse'].'<br>'.$ligne['nom_fr_fr'].'
        </div>
        <div class="col-7">
            <a class="btn btn-gris-souris rounded-pill my-3" href="index.php?page=311&id='.$client['id_user'].'&fac='.$ligne['id_adresse'].'&liv='.$livraison[0]['id_adresse'].'">Modifier</a>
        </div>
    ';
    $i++;
}
$adresses_fac .= '</div>';

$adresses_liv = '<div class="row">';
$i = 1;
foreach ($livraison as $ligne) {
    $adresses_liv .= '
        <div class="col-1">'.$i.'</div>
        <div class="col-4">
            '.$ligne['numero_adresse'].' '.$ligne['rue_adresse'].' '.$ligne['complement_adresse'].'<br>'.$ligne['code_postal_adresse'].' '.$ligne['ville_adresse'].'<br>'.$ligne['nom_fr_fr'].'
        </div>
        <div class="col-7">
            <a class="btn btn-gris-souris rounded-pill my-3" href="index.php?page=311&id='.$client['id_user'].'&fac='.$facturation[0]['id_adresse'].'&liv='.$ligne['id_adresse'].'">Modifier</a>
        </div>
    ';
    $i++;
}
$adresses_liv .= '</div>';

$page_courante = '
<div class="row">
    <div class="col-lg-7 offset-lg-1" id="top">
        <div class="row ">
            <h2 class="fs-5 text-center text-md-start" >Information personnelles</h2>
            <div class="col-6 ">
                <strong>Prénom : </strong>'.$client['prenom_utilisateur'].'
            </div>
            <div class="col-6">
                <strong>Nom : </strong>'.$client['nom_utilisateur'].'
            </div>                    
            <div class="col-6 ">
                <strong>Téléphone : </strong>'.$client['tel_utilisateur'].'
            </div>                    
            <div class="col-6">
                <strong>e-mail : </strong>'.$client['mail_utilisateur'].'
            </div>
            <div class="text-center text-md-start ">
                <a class="btn btn-gris-souris rounded-pill my-3" href="index.php?page=311&id='.$client['id_user'].'&fac='.$facturation[0]['id_adresse'].'&liv='.$livraison[0]['id_adresse'].'">Modifier</a>
            </div>
        </div>
    </div>
    <aside class="col-lg-4 bg-anticbeige text-center">
        <h2 class="fs-6 mx-5 my-3">Une question?<br> Une demande de devis?</h2>
        <a class="btn btn-gris-souris rounded-pill my-3" href="index.php?page=300">Contact</a>
        <p class="mb-3">Pour les questions fréquentes <a href="index.php?page=6">consulter notre FAQ.</a> </p>
    </aside>
    <div class="offset-1 col-10 text-center text-md-start">
        <h2 class="fs-6  mt-3 mt-md-0">Adresses de facturations</h2>
        '.$adresses_fac.'
        <a class="btn btn-gris-souris rounded-pill my-3 mb-lg-5" href="index.php?page=311&id='.$client['id_user'].'&fac=0&liv='.$livraison[0]['id_adresse'].'">Ajouter une adresse</a>
        <h2 class="fs-6">Adresses de livraisons</h2>
        '.$adresses_liv.'
        <a class="btn btn-gris-souris rounded-pill my-3 mb-lg-5" href="index.php?page=311&id='.$client['id_user'].'&fac='.$facturation[0]['id_adresse'].'&liv=0">Ajouter une adresse</a>
    </div>
</div>
';

?>