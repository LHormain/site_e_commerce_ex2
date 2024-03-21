//--------------------------------------------------------------
//    mise en valeur du texte pour le référencement du site
//    remplace certains mots ou certaines expression par 
//    eux même mais en gras
//--------------------------------------------------------------

// mise en valeur du texte placé dans des paragraphes <p>
let texte = document.querySelectorAll('p');

// liste des chaines de caractères à traiter (mots clefs)
let liste_mot_clef = ['Qualis arma', 'Qualis Arma', 'qualis arma', 'qualis Arma', 'vos rêves', 'votre vision', 'vos envies', 'sur mesure', 'à la demande', 'pièce unique','pièces uniques', 'vos attentes', 'réductions exceptionnelles', 'pièce de qualité', 'nos offres exclusives', 'prix irrésistibles','réservez','reproductions historiques', 'fidèles', 'histoire','authenticité', 'intemporelle','nos fournisseurs de confiance','location','grands événements', 'expérience mémorable', 'personnaliser l\'expérience', 'salle de réunion', 'créativité','réalisations uniques','ébénisterie', 'ébéniste ','menuisier','artisanal ', 'espace client personnalisé' ];

texte.forEach(element => {
    liste_mot_clef.forEach(mot => {
        
        element.innerHTML = element.innerHTML.replaceAll(mot, '<strong>'+mot+'</strong>');
    });
});