<?php
$texte_page_courante = '';

// récupération des section 
$sections = req_sections($bdd);

// récupération des données pour une update
if (isset($_GET['id']) && $_GET['id'] != NULL) {
    $id_filtre = intval($_GET['id']);

    $titre = "Modifier une sous catégorie";
    $categorie = req_sous_categorie($bdd, $id_filtre);
    $nom_filtre = $categorie['nom_filtre'];

    $select = select_sections($sections,$categorie['id_section']);

}
else {
    $titre = "Saisir une nouvelle sous catégorie";
    $nom_filtre = "";

    $select = select_sections($sections,0);

}

//traitement
if (isset($_POST['nom_filtre'],
$_POST['section']
)
&& $_POST['nom_filtre'] != NULL
&& $_POST['section'] != NULL
) {
    $nom_filtre = htmlspecialchars($_POST['nom_filtre']);
    $id_section = htmlspecialchars($_POST['section']);


    // enregistre la sous cat
    if (isset($_GET['id'])
    && $_GET['id'] != NULL
    ) {
        //update
        $id_filtre = intval($_GET['id']);

        req_sous_categorie_update($bdd,$nom_filtre,$id_section,$id_filtre);

        $texte_page_courante = 'La modification a été enregistré';
    }
    else {
        //insert
        req_sous_categorie_insert($bdd,$nom_filtre,$id_section);
        $texte_page_courante = 'La sous catégorie a été enregistré';
    }


}
?>