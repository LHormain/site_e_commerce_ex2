//------------------------------------------------------------
//      pour changer l'ordre des customisations pour l'affichage
//------------------------------------------------------------

function chargementPosition(id_custom, position) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_input_position_custom.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
    }
    
    let selection = document.getElementById(position).value;
    let table = document.getElementById(position).name;
    
    data = ('ordre_affichage='+ selection +'&id_custom='+ id_custom + '&table=' + table);
    xmlhttp.send(data);
}

let AllStock = document.querySelectorAll('.input_dispo');
AllStock.forEach(stock => {
    let id = stock.id.replace('position', '');
    let aff = stock.id;
    stock.addEventListener('change', function() {
        chargementPosition(id,aff);
    });
});