//------------------------------------------------------------
//      pour changer l'ordre des questions pour l'affichage
//------------------------------------------------------------

function chargementPosition(id_faq, position) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_input_position_faq.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
    }
    
    let selection = document.getElementById(position).value;
    
    data = ('position_faq='+ selection +'&id_faq='+ id_faq);
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