// gestion de l'affichage du bouton recherche
let recherche = document.getElementById('recherche');
let btnRecherche = document.querySelector('#recherche + button');
let icone = document.getElementById('icone_recherche');

icone.addEventListener('click', function() {
    if (recherche.className == "d-none") {
        recherche.setAttribute("class", "d-inline-block");
    }
    else {
        recherche.setAttribute("class", "d-none");
    }
    
});