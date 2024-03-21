//------------------------------------------------------------
//      pour changer l'ordre des images pour l'affichage
//------------------------------------------------------------

function chargementPosition(id_img_produit, position) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_input_position_img_produit.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
    }
    
    let selection = document.getElementById(position).value;
    data = ('position_img_produit='+ selection +'&id_img_produit='+ id_img_produit);
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