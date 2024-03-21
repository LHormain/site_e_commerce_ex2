//----------------------------------------------------------
//    gestion : a t on répondus au devis
//----------------------------------------------------------

function gestionAfficher(id_devis) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_btn_repondre.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        
        for (let data in myobj) {
            
        }
    }
    
    data = ('id_devis='+ id_devis);
    xmlhttp.send(data);
}

let btn_repondre = document.querySelector('.btn_repondre');
let id = btn_repondre.id;
btn_repondre.addEventListener('click', function() {
    gestionAfficher(id);
});

//----------------------------------------------------------
//     gestion : select de l'état du devis
//----------------------------------------------------------
function chargementSelectEtat(selection,id_devis) {
    
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_select_etat_devis.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        
            window.location.assign(window.location.href);
    }
    
    data = ('id_etat='+ selection + '&id_devis=' + id_devis);
    xmlhttp.send(data);

}
// addEventListener sur le select. utilise le btn repondre pour récupérer l'id
let sections = document.getElementById('select_etat');
sections.addEventListener('change', function() {
    let selection =sections.options[sections.selectedIndex].value;
    chargementSelectEtat(selection,id);
});