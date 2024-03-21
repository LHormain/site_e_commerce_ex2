//-------------------------------------------------------------------
//  gestion de l'ajout ou non d'une catégorie à la promo du moment
//-------------------------------------------------------------------

function gestionAfficher(id_cat, promo_categorie) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_cat_promo.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_cat); 
        
        for (let data in myobj) {

            resultat.value = myobj[data].promo_categorie;
            
            if (myobj[data].promo_categorie == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('promo_categorie='+ promo_categorie +'&id_cat='+ id_cat);
    xmlhttp.send(data);

}

let AllCat = document.querySelectorAll('.btn_aff');
AllCat.forEach(categorie => {
    let id = categorie.id;
    categorie.addEventListener('click', function() {
        let aff = categorie.value;
        gestionAfficher(id,aff);
    });
});