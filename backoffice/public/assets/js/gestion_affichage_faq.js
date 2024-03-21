//-----------------------------------------------------------------
//    gestion de l'affichage de la faq
//-----------------------------------------------------------------

function gestionAfficherTxt(id_faq, afficher_faq) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_faq.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('txt'+id_faq); 
        
        for (let data in myobj) {
            
            resultat.value = myobj[data].afficher_faq;

            if (myobj[data].afficher_faq == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_faq='+ afficher_faq +'&id_faq='+ id_faq);
    xmlhttp.send(data);
}

let allFaq = document.querySelectorAll('.btn_aff_txt');
allFaq.forEach(faq => {
    let id = faq.id.replace('txt', '');
    faq.addEventListener('click', function() {
        let aff = faq.value;
        gestionAfficherTxt(id,aff);
    });
});