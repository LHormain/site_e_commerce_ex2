//------------------------------------------------------------
//      pour changer l'ordre des images pour l'affichage
//------------------------------------------------------------

function chargementPosition(id_tb_txt, position) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_input_position_txt_tb.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
    }
    
    let selection = document.getElementById(position).value;
    data = ('position_tb_txt='+ selection +'&id_tb_txt='+ id_tb_txt);
    xmlhttp.send(data);
}

let allPos = document.querySelectorAll('.input_dispo');
allPos.forEach(stock => {
    let id = stock.id.replace('position', '');
    let aff = stock.id;
    stock.addEventListener('change', function() {
        chargementPosition(id,aff);
    });
});