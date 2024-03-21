//----------------------------------------------------------
//    gestion de l'affichage ou non d'une cat
//----------------------------------------------------------

function gestionAfficher(id_atelier, afficher_atelier) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_ateliers.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_atelier); 
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_atelier;

            if (myobj[data].afficher_atelier == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_atelier='+ afficher_atelier +'&id_atelier='+ id_atelier);
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