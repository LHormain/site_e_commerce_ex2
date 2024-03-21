//-----------------------------------------------------------------
//    gestion de l'affichage ou non d'un produit 
//           dans la promotion du jumbotron
//-----------------------------------------------------------------

function gestionAfficherUni(id_produit, piece_unique) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_pu.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('uni'+id_produit); 
        
        for (let data in myobj) {
            
            resultat.value = myobj[data].piece_unique;

            if (myobj[data].piece_unique == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('piece_unique='+ piece_unique +'&id_produit='+ id_produit);
    xmlhttp.send(data);
}

let allPU = document.querySelectorAll('.btn_uni');
allPU.forEach(prom => {
    let id = prom.id.replace('uni', '');
    prom.addEventListener('click', function() {
        let aff = prom.value;
        gestionAfficherUni(id,aff);
    });
});