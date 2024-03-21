//----------------------------------------------------------
//    gestion de l'affichage ou non d'une cat
//----------------------------------------------------------

function gestionAfficher(id_projet, afficher_projet) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_projets.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_projet); 
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_projet;

            if (myobj[data].afficher_projet == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_projet='+ afficher_projet +'&id_projet='+ id_projet);
    xmlhttp.send(data);
}

let allProjets = document.querySelectorAll('.btn_aff');
allProjets.forEach(projet => {
    let id = projet.id;
    projet.addEventListener('click', function() {
        let aff = projet.value;
        gestionAfficher(id,aff);
    });
});