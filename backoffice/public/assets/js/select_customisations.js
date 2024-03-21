//------------------------------------------------------------------------------------------
// affiche ou non le téléchargement d'une image en fonction de la customisation saisie. 
//------------------------------------------------------------------------------------------


let liste = document.getElementById('table');
let image = document.getElementById('image');
let selection =liste.options[liste.selectedIndex].value;


liste.addEventListener('change', function() {
    let selection =liste.options[liste.selectedIndex].value;
    if (selection == 'couleurs' || selection == 'matieres') {
        image.classList.remove('visually-hidden');
    }
    else {
        image.classList.add('visually-hidden');
    }
});

if (selection == 'couleurs' || selection == 'matieres') {
    image.classList.remove('visually-hidden');
}
else {
    image.classList.add('visually-hidden');
}

