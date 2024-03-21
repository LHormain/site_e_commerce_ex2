//----------------------------------------------------------
//    gestion de l'affichage ou non d'une cat
//----------------------------------------------------------

function gestionAfficher(id_partenaire, afficher_partenaire) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_partenaires.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_partenaire); 
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_partenaire;

            if (myobj[data].afficher_partenaire == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_partenaire='+ afficher_partenaire +'&id_partenaire='+ id_partenaire);
    xmlhttp.send(data);
}

let allPartenaires = document.querySelectorAll('.btn_aff');
allPartenaires.forEach(partenaire => {
    let id = partenaire.id;
    partenaire.addEventListener('click', function() {
        let aff = partenaire.value;
        gestionAfficher(id,aff);
    });
});