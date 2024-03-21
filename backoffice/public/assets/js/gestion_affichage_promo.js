//-----------------------------------------------------------------
//    gestion de l'affichage ou non d'un produit 
//           dans la promotion du jumbotron
//-----------------------------------------------------------------

function gestionAfficherPromo(id_produit, promo_produit) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_promo.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('promo'+id_produit); 
        
        for (let data in myobj) {
            
            resultat.value = myobj[data].promo_produit;

            if (myobj[data].promo_produit == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('promo_produit='+ promo_produit +'&id_produit='+ id_produit);
    xmlhttp.send(data);
}

let allPromo = document.querySelectorAll('.btn_promo');
allPromo.forEach(prom => {
    let id = prom.id.replace('promo', '');
    prom.addEventListener('click', function() {
        let aff = prom.value;
        gestionAfficherPromo(id,aff);
    });
});