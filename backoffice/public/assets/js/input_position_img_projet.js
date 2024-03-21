//------------------------------------------------------------
//      pour changer l'ordre des images pour l'affichage
//------------------------------------------------------------

function chargementPosition(id_img, position) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_input_position_img_projet.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
    }
    
    let selection = document.getElementById(position).value;
    data = ('position_image='+ selection +'&id_img='+ id_img);
    xmlhttp.send(data);
}

let allImg = document.querySelectorAll('.input_dispo');
allImg.forEach(stock => {
    let id = stock.id.replace('position', '');
    let aff = stock.id;
    stock.addEventListener('change', function() {
        chargementPosition(id,aff);
    });
});