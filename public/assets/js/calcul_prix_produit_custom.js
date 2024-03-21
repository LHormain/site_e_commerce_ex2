//-------------------------------------------------------------
//        calcul du nouveau prix après changement d'options
//        pour le produit
//-------------------------------------------------------------
function setPrixCustomizable() {
    // récupère le prix
    let prix_initial = document.getElementById('prix');

    // récupère les options
    let couleur = document.getElementById('couleur');
    let newCouleur = couleur.options[couleur.selectedIndex].value;
    let prixCouleur = parseFloat(document.getElementById('pc'+newCouleur).value);
    
    let matiere = document.getElementById('matiere');
    let newMatiere = matiere.options[matiere.selectedIndex].value;
    let prixMatiere = parseFloat(document.getElementById('pm'+newMatiere).value);
    
    let custom = document.getElementById('custom');
    let newCustom = custom.options[custom.selectedIndex].value;
    let prixCustom = parseFloat(document.getElementById('pac'+newCustom).value);
    
    let allDimension = document.getElementsByClassName('taille');
    let prixDimension = 0;
    for (let i = 0; i < allDimension.length; i++) {
        let newTaille = allDimension[i].id;
        let prixTaille = parseFloat(document.getElementById('pt'+newTaille).value);
        prixDimension += (parseFloat(allDimension[i].value)-parseFloat(allDimension[i].min))*prixTaille/parseFloat(allDimension[i].step);
    }

    let taille = document.getElementById('dimension');
    let newTaille = taille.options[taille.selectedIndex].value;
    let prixTaille = parseFloat(document.getElementById('ptd'+newTaille).value);

    // calcul
    let oldPrix = parseFloat(prix_initial.innerHTML);
    let newPrix = oldPrix + prixCouleur + prixMatiere + prixCustom + prixDimension + prixTaille;

    return newPrix;
}

// calcul au lancement de la page
let custo_etat = document.getElementById('custo_etat').value;
let prix_ht = document.getElementById('p_ht');
let prix_ttc = document.getElementById('p_ttc');

if (custo_etat == 1) { // uniquement si le produit est customizable 
    let qte = document.getElementById('quantite_produit');
    affichePrix(setPrixCustomizable()*qte.value);
}
else {
    let qte = document.getElementById('quantite_produit');
    affichePrix(parseFloat(document.getElementById('prix').innerHTML*qte.value));
}
// calcul quand changements options
let tableau = document.getElementById('table_produit');
tableau.addEventListener('click', function() {
    if (custo_etat == 1) {
        affichePrix(setPrixCustomizable());
        setOptionCustomizable();
    }
});

//---------------------------------------------------------
//                affichage des prix 
//---------------------------------------------------------
function affichePrix(prixHT) {
    let newPrix = setPrixPromo(prixHT);
    if (newPrix == prixHT) {
        prix_ht.innerHTML = newPrix.toFixed(2);
        prix_ttc.innerHTML = (newPrix*(1+20/100)).toFixed(2) ;
    }
    else {
        prix_ht.innerHTML = '<div class="d-inline text-decoration-line-through">' + prixHT.toFixed(2)+ '</div> ' + newPrix.toFixed(2);
        prix_ttc.innerHTML = '<div class="d-inline text-decoration-line-through">' +(prixHT*(1+20/100)).toFixed(2) + '</div> ' + (newPrix*(1+20/100)).toFixed(2);
    }

}
//---------------------------------------------------------
//        calcul du prix en fonction de la quantité
//---------------------------------------------------------
function setPrixQte(qte) {

    // calcul
    if (custo_etat == 1) { // si objet customizable
        var oldPrix = parseFloat(setPrixCustomizable());
    }
    else {
        var oldPrix = parseFloat(document.getElementById('prix').innerHTML);
    }
    affichePrix(qte*oldPrix);
}

// quantité
let qte = document.getElementById('quantite_produit');

qte.addEventListener('input', function() {
    setPrixQte(parseInt(qte.value));
});

//-------------------------------------------------------------
//               gestion des btn plus et moins
//-------------------------------------------------------------

function quantitePlus() {
    let produit = document.getElementById('quantite_produit');
    let max = parseInt(produit.getAttribute('max'));
    let value = produit.value;
    if (value < max) {
        produit.stepUp();
        let newValue = produit.value;
        produit.setAttribute('value', newValue);
        setPrixQte(parseInt(produit.value));
    }
}
function quantiteMoins() {
    let produit = document.getElementById('quantite_produit');
    let min = parseInt(produit.getAttribute('min'));
    let value = produit.value;
    
    if (value > min) {
        produit.stepDown();
        let newValue = produit.value;
        produit.setAttribute('value', newValue);
        setPrixQte(parseInt(produit.value));
    }
}

// gestion
let btnMoins = document.querySelector('.moins');
btnMoins.addEventListener('click', function() {
    quantiteMoins();
});

let btnPlus = document.querySelector('.plus');
btnPlus.addEventListener('click', function() {
    quantitePlus();
});

//---------------------------------------------------------------
//                 calcul du prix si promo
//---------------------------------------------------------------
function setPrixPromo(prix_unitaire) {
    let promo = document.getElementById('promo').value;
    let taux = document.getElementById('taux_promo').value;

    if (promo == 1) {
        var newPrix = prix_unitaire*(1-taux/100);
    }
    else {
        var newPrix = prix_unitaire;
    }
    return newPrix;
}
//---------------------------------------------------------------
//                gestion des options du produit
//                    pour ajout au panier
//---------------------------------------------------------------
function setOptionCustomizable() {
    // récupération des id 
    let couleur = document.getElementById('couleur');
    let newCouleur = couleur.options[couleur.selectedIndex].value;
    
    let matiere = document.getElementById('matiere');
    let newMatiere = matiere.options[matiere.selectedIndex].value;
    
    let custom = document.getElementById('custom');
    let newCustom = custom.options[custom.selectedIndex].value;
    
    let allDimension = document.getElementsByClassName('taille');
    let newAutreTaille = '';
    let newTailleValue = '';
    for (let i = 0; i < allDimension.length; i++) { // pour le cas ou il y en a plusieurs
        newAutreTaille += allDimension[i].id + '-';
        newTailleValue += allDimension[i].value + '-';
    }

    let taille = document.getElementById('dimension');
    let newTaille = taille.options[taille.selectedIndex].value;

    // sortie 
    let couleurSelected = document.getElementById('couleur_select');
    let matiereSelected = document.getElementById('matiere_select');
    let tailleSelected = document.getElementById('taille_select');
    let autreTailleSelected = document.getElementById('autre_taille_select');
    let valeurAutreTaille = document.getElementById('autre_taille_v');
    let customSelected = document.getElementById('custom_select');

    // met a jour l'option choisie
    couleurSelected.setAttribute('value', newCouleur);
    matiereSelected.setAttribute('value',newMatiere); 
    tailleSelected.setAttribute('value',newTaille);
    autreTailleSelected.setAttribute('value',newAutreTaille);
    valeurAutreTaille.setAttribute('value',newTailleValue);
    customSelected.setAttribute('value',newCustom);    
}
//---------------------------------------------------------------
//                   Ajax sur panier
//---------------------------------------------------------------

// pour vente
function addPanier(id_panier, id_produit,couleurSelected,matiereSelected,tailleSelected,autreTailleSelected,valeurAutreTaille,customSelected,prix_ht,identifiant_client) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_ajout_panier.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        // const myobj = JSON.parse(this.responseText);
        // alert(this.responseText);
        alert('Votre produit à bien été ajouté au panier');

    }
    
    // 
    let produit = document.getElementById('quantite_produit');
    let selection = produit.value;
    data = ('quantite_produit='+ selection 
            +'&id_panier='+ id_panier
            +'&id_produit='+ id_produit
            +'&id_couleur='+ couleurSelected
            +'&id_matiere='+ matiereSelected
            +'&id_taille='+ tailleSelected
            +'&id_autre_taille='+ autreTailleSelected
            +'&autres_tailles_choix='+valeurAutreTaille
            +'&id_custom='+customSelected
            +'&prix_unitaire='+prix_ht
            +'&identifiant_client='+identifiant_client
            );
    xmlhttp.send(data);
 
}
// pour location 
function addWishlist(id_panier,id_produit,prix_unitaire,identifiant_client) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_ajout_panier_location.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        
        // const myobj = JSON.parse(this.responseText);
        alert('Le produit à bien été ajouté à votre liste de souhait')

    }
    
    let produit = document.getElementById('quantite_produit');
    let selection = produit.value;
    data = ('quantite_produit='+ selection 
            +'&id_panier='+ id_panier
            +'&id_produit='+ id_produit
            +'&prix_unitaire='+prix_unitaire
            +'&identifiant_client='+identifiant_client
            );
    xmlhttp.send(data);
}

// gestion du btn ajout au panier
let panier = document.querySelector('.panier')
panier.addEventListener('click', function() {
    let id = panier.id;
    let id_panier = document.getElementById('panier').value;

    let couleurSelected = document.getElementById('couleur_select').value;
    let matiereSelected = document.getElementById('matiere_select').value;
    let tailleSelected = document.getElementById('taille_select').value;
    let autreTailleSelected = document.getElementById('autre_taille_select').value;
    let valeurAutreTaille = document.getElementById('autre_taille_v').value;
    let customSelected = document.getElementById('custom_select').value;

    if (custo_etat == 1) { // si objet customizable
        var prix_unitaire = setPrixPromo(setPrixCustomizable());
    }
    else {
        var prix_unitaire = parseFloat(setPrixPromo(document.getElementById('prix').innerHTML));
    }

    let identifiant_client= document.getElementById('identifiant_client').value;

    let cas = document.getElementById('panier').name;

    if (cas == 'vente') {
        addPanier(id_panier, id, couleurSelected,matiereSelected,tailleSelected,autreTailleSelected,valeurAutreTaille,customSelected,prix_unitaire.toFixed(2),identifiant_client);
    }
    else if (cas == 'location') {
        addWishlist(id_panier, id, prix_unitaire.toFixed(2),identifiant_client);
    }
});

