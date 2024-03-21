//---------------------------------------------------------------------------
// sélectionne le btn imprimer et imprime la page courante. 
// les partie à ne pas imprimer sont spécifier dans le css media query print
//---------------------------------------------------------------------------

imprimer = document.getElementById('imprimer');
imprimer.addEventListener('click', function() {
    window.print(); 
    return false;
});