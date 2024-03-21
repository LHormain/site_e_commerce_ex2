//----------------------------------------------------------
//    gestion bouton répondre au devis
//----------------------------------------------------------

function gestionAfficher(id_devis) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_btn_repondre.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById(id_devis); 
        
        for (let data in myobj) {
                                    

            if (myobj[data].repondu_devis == 1) {
                resultat.innerHTML = `<a href="mailto:${myobj[data].mail_utilisateur}?subject=Qualis%20Arma%20votre%20devis"><img src="public/assets/img/feather-pen.png" alt="" class="icones_table afficher"></a>`;
            }
            
        }
    }
    
    data = ('id_devis='+ id_devis);
    xmlhttp.send(data);
}

let AllCat = document.querySelectorAll('.btn_repondre');
AllCat.forEach(categorie => {
    let id = categorie.id;
    categorie.addEventListener('click', function() {
        gestionAfficher(id);
    });
});