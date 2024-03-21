//----------------------------------------------------------
//    gestion de l'affichage ou non d'une cat
//----------------------------------------------------------

function gestionAfficher(id_categorie, afficher_categorie) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_categories.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_categorie);
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_categorie;

            if (myobj[data].afficher_categorie == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_categorie='+ afficher_categorie +'&id_categorie='+ id_categorie);
    xmlhttp.send(data);
}

let allCategories = document.querySelectorAll('.btn_aff');
allCategories.forEach(categorie => {
    let id = categorie.id;
    categorie.addEventListener('click', function() {
        let aff = categorie.value;
        gestionAfficher(id,aff);
    });
});