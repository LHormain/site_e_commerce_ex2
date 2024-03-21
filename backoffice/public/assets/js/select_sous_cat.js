//------------------------------------------------------------------
//
//                    Gestion de la page 
//                    Saisie d'un produit
//
//------------------------------------------------------------------
//------------------------------------------------------------------
// génère les sous cat et cat en fonction de la section sélectionnée
//------------------------------------------------------------------

// catégories
function chargementSelectCat(selection) {
    
    // création de l'objet XHLHttpRequest
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_select_cat.php", true); // il va chercher le fichier et l'ouvre
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // obligatoire pour post
    xmlhttp.onload = function() { // peut aussi utiliser onreadystatechange ou autre chose
        
        const myobj = JSON.parse(this.responseText);
        let resultat1 = document.getElementById('id_cat'); //le select à remplacer
        
        resultat1.innerHTML = '';
        for (let data in myobj) {
                resultat1.innerHTML += `<option value=" ${myobj[data].id_cat}">${myobj[data].nom_categorie}</option>`;
            
        }
    }
    
    data = ('section='+ selection );
    xmlhttp.send(data);

}
// sous catégories
function chargementSelectFiltre(selection) {
    
    // création de l'objet XHLHttpRequest
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_select_sscat.php", true); // il va chercher le fichier et l'ouvre
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // obligatoire pour post
    xmlhttp.onload = function() { // peut aussi utiliser onreadystatechange ou autre chose
        
        const myobj = JSON.parse(this.responseText);
        let resultat2 = document.getElementById('id_filtre'); //le select à remplacer
        
        resultat2.innerHTML = '';
        for (let data in myobj) {
                resultat2.innerHTML += `<option value=" ${myobj[data].id_filtre}">${myobj[data].nom_filtre}</option>`;
            
        }
    }
    
    data = ('section='+ selection );
    xmlhttp.send(data);

}

// écoute sur le select section 
let sections = document.getElementById('section');
sections.addEventListener('change', function() {
    let selection =sections.options[sections.selectedIndex].value;
    chargementSelectCat(selection);
    chargementSelectFiltre(selection);
});

// ---------------------------------------------
//   calcul du prix TTC
// ---------------------------------------------
let prixHT = document.getElementById('prix_ht_produit');
let prixTTC = document.getElementById('prixTTC');

prixHT.addEventListener('input', function () {
    prixTTC.value =  (prixHT.value*(1+20/100)).toFixed(2);
});
prixTTC.addEventListener('input', function() {
    prixHT.value = (prixTTC.value*(1-20/120)).toFixed(2);
});


//----------------------------------------------
// affichage des options si customisable ou non
//----------------------------------------------

let customisable = document.getElementById('custo');
let noCustomisable = document.getElementById('no_custo');

let couleur_radio = document.getElementById('couleur_radio');
let couleur_checkbox = document.getElementById('couleur_checkbox');

let matiere_radio = document.getElementById('matiere_radio');
let matiere_checkbox = document.getElementById('matiere_checkbox');

let tailles = document.getElementById('taille_custo');
let autre = document.getElementById('autre_custo');

// test si customisable check au chargement de la page lors update
if (customisable.checked) {
    couleur_checkbox.classList.remove('visually-hidden');
    couleur_radio.classList.add('visually-hidden');

    matiere_checkbox.classList.remove('visually-hidden');
    matiere_radio.classList.add('visually-hidden');

    tailles.classList.remove('visually-hidden');
    autre.classList.remove('visually-hidden');
}

// cache ou affiche les partie pour la customisation en fonction de l'option cochée
customisable.addEventListener('click', function () {
    if (customisable.checked) {
        couleur_checkbox.classList.remove('visually-hidden');
        couleur_radio.classList.add('visually-hidden');

        matiere_checkbox.classList.remove('visually-hidden');
        matiere_radio.classList.add('visually-hidden');

        tailles.classList.remove('visually-hidden');
        autre.classList.remove('visually-hidden');
    }
});

noCustomisable.addEventListener('click', function() {
    if (noCustomisable.checked) {
        couleur_checkbox.classList.add('visually-hidden');
        couleur_radio.classList.remove('visually-hidden');

        matiere_checkbox.classList.add('visually-hidden');
        matiere_radio.classList.remove('visually-hidden');

        tailles.classList.add('visually-hidden');
        autre.classList.add('visually-hidden');
    }
});

// clean l'input prix si la checkbox correspondante n'est pas cochée
// couleur
let cb_c = document.querySelectorAll('#couleur_checkbox .cb_c input');

cb_c.forEach(box => {
    box.addEventListener('click', function() {
        id_box = box.id;
        let p_c = document.getElementById('prix_'+id_box);
        if (box.checked == false) {
            p_c.value = '';
        }
    });
});

// matiere
let cb_m = document.querySelectorAll('#matiere_checkbox .cb_c input');

cb_m.forEach(box => {
    box.addEventListener('click', function() {
        id_box = box.id;
        let p_c = document.getElementById('prix_'+id_box);
        if (box.checked == false) {
            p_c.value = '';
        }
    });
});
// autre customisations
let cb_a = document.querySelectorAll('#autre_custo .cb_c input');

cb_a.forEach(box => {
    box.addEventListener('click', function() {
        id_box = box.id;
        let p_c = document.getElementById('prix_'+id_box);
        if (box.checked == false) {
            p_c.value = '';
        }
    });
});