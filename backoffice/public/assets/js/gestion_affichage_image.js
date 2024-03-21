//-------------------------------------------------------------------
//  gestion de l'affichage ou non d'une image
//-------------------------------------------------------------------

function gestionAfficher(id_img_produit, afficher_img_produit) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_gestion_affichage_image.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 

        const myobj = JSON.parse(this.responseText);
        let resultat = document.getElementById('aff'+id_img_produit); 
        
        for (let data in myobj) {

            resultat.value = myobj[data].afficher_img_produit;
            
            if (myobj[data].afficher_img_produit == 1) {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table afficher">`;
            }
            else {
                resultat.innerHTML = `<img src="public/assets/img/verifier.png" alt="" class="icones_table non_afficher">`;
            }
        }
    }
    
    data = ('afficher_img_produit='+ afficher_img_produit +'&id_img_produit='+ id_img_produit);
    xmlhttp.send(data);

}

let AllCat = document.querySelectorAll('.btn_aff');
AllCat.forEach(categorie => {
    let id = categorie.id.replace('aff', '');
    categorie.addEventListener('click', function() {
        let aff = categorie.value;
        gestionAfficher(id,aff);
    });
});