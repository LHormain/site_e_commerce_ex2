//---------------------------------------------------------------
// update l'état d'un devis
//---------------------------------------------------------------
function updateSelect(id_devis) {
    // création de l'objet XHLHttpRequest
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_update_etat_devis.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('message'); 
        
        resultat.innerHTML = `État du devis modifié.`;
        if (selection == 3){
            window.location.assign(window.location.href);
        }
    }
    
    let liste = document.getElementById('select_etat');
    let selection = liste.options[liste.selectedIndex].value;
    data = ('id_devis='+ id_devis + '&id_etat=' + selection);
    xmlhttp.send(data);

}

let select = document.getElementById('select_etat');

select.addEventListener('change', function() {
    let id_devis = select.name;
    updateSelect(id_devis);
});