// -------------------------------------------------------
//      pour changer le statut répondu dans le tableau
// -------------------------------------------------------

function gestionAfficher(id_contact, repondu_message) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_repondu.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
         
        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_contact); 
        
        for (let data in myobj) {
            
            if (myobj[data].repondu_contact == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        } 
    }
    
    data = ('repondu_message='+ repondu_message +'&id_contact='+ id_contact);
    xmlhttp.send(data);
}

let AllCat = document.querySelectorAll('.btn_aff');
AllCat.forEach(categorie => {
    let id = categorie.name;
    categorie.addEventListener('click', function() {
        let aff = categorie.value;
        gestionAfficher(id,aff);
    });
});