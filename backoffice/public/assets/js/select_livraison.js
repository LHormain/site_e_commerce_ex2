//------------------------------------------------------------------
//     change l'état de livraisons
//------------------------------------------------------------------

function chargementSelect(id_commande) {
    
    // création de l'objet XHLHttpRequest
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_select_livraison.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        window.location.assign(window.location.href);
        const myobj = JSON.parse(this.responseText);
    }
    
    let liste = document.getElementById(id_commande);
    let selection = liste.options[liste.selectedIndex].value;
    data = ('id_etat_livraison='+ selection +'&id_commande='+ id_commande);
    xmlhttp.send(data);

}
let AllStock = document.querySelectorAll('.select_livrer');
AllStock.forEach(stock => {
    let id = stock.id;
    stock.addEventListener('change', function() {
        chargementSelect(id);
    });
});