//----------------------------------------------------------
//    gestion de l'affichage ou non d'une cat
//----------------------------------------------------------
// images
function gestionAfficher(id_atelier, afficher_atelier) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_teambuilding.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_atelier); 
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_tb;

            if (myobj[data].afficher_tb == 1) {
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
//texte
function gestionAfficherTexte(id_tb_txt, afficher_tb_txt) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_teambuilding_txt.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('txt'+id_tb_txt); 
        
        for (let data in myobj) {
                                    
            resultat.value = myobj[data].afficher_tb_txt;

            if (myobj[data].afficher_tb_txt == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_tb_txt='+ afficher_tb_txt +'&id_tb_txt='+ id_tb_txt);
    xmlhttp.send(data);
}

let allCat = document.querySelectorAll('.btn_aff');
allCat.forEach(categorie => {
    let id = categorie.id;
    categorie.addEventListener('click', function() {
        let aff = categorie.value;
        gestionAfficher(id,aff);
    });
});

let allTxt = document.querySelectorAll('.btn_aff_txt');
allTxt.forEach(texte => {
    let id = texte.id.replace('txt', '');
    texte.addEventListener('click', function() {
        let aff = texte.value;
        gestionAfficherTexte(id,aff);
    });
});