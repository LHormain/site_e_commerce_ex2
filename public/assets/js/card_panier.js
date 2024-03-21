
// ----------------------------------------------------------
//                        addEventListener
// ----------------------------------------------------------
let allProduits = document.querySelectorAll('.add_fav');
allProduits.forEach(produit => {
    let id = produit.id.replace('btn_add', '');
    let client = produit.value;
    produit.addEventListener('click', function() {
        addFavoris(id,client);
    });
});

// ----------------------------------------------------------
//                            ajout aux favoris
// ----------------------------------------------------------

function addFavoris(id_produit, identifiant_client) {
    const xmlhttp = new XMLHttpRequest();
    
    xmlhttp.open("POST", "controler/requete_add_favoris.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() {
        const myobj = this.responseText;
        let resultat = document.getElementById('btn_add'+id_produit);

        if (myobj == 'add') {
            resultat.innerHTML = '<img src="public/assets/img/icones/coeur1.png" alt="" class=" img-fluid icones ">';
        }
        else {
            resultat.innerHTML = '<img src="public/assets/img/icones/coeur.png" alt="" class=" img-fluid icones ">';
        }
    }
    
    data = ('identifiant_client='+ identifiant_client +'&id_produit='+ id_produit);
    xmlhttp.send(data);
}