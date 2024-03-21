//--------------------------------------------------------------
//             validation de l'inscription à un atelier
//--------------------------------------------------------------
let horaire = document.getElementsByName('date_atelier');
let horaireBox = document.getElementById('horaireBox');
let nbrInscrit = document.getElementById('nbr_inscrit');
let codeTest = document.getElementById('captcha');
let envoyer = document.querySelector('input[type=submit]');

let validationCaptcha = false;
let validationHoraire = false;
let validationInscrit = false;
let validation = false;

// -----------------------------------------------------
// fonctions
// -----------------------------------------------------
// identification du résultat captcha
function captchaTest(codeTest) {
    if (codeTest.value === chaineNumberCode) {
        validationCaptcha = true;
        codeTest.style.backgroundColor = "white";
    }
    else {
        validationCaptcha = false;
        codeTest.style.backgroundColor = "var(--rouge25)";
    }
    return validationCaptcha;
}
// test longueur input 
function lengthcheck(elementTester, minimum) {
    if (elementTester.value.length < minimum) {
        elementTester.value = '';
        elementTester.placeholder = minimum + ' 1 personne minimum';
        elementTester.style.backgroundColor = "var(--rouge25)";
        validation = false;
    }
    else {
        validation = true;
        elementTester.style.backgroundColor = "transparent";
    }
    return validation;
}
// test checkbox et radio
function boxcheck(elementTester) {
    if (elementTester.checked) {
        validation = true;
    }
    else {
        validation = false;
    }
    return validation;
}

// -----------------------------------------------------
//                 addEventListeners
// -----------------------------------------------------
nbrInscrit.addEventListener('input', function() {
    // nombre
    lengthcheck(nbrInscrit, 1);
    validationInscrit = validation;
});

codeTest.addEventListener('blur', function() {
    //captcha
    captchaTest(codeTest);
});

document.addEventListener('click', function() {
    // horaire
    for (let i = 0; i < horaire.length; i++) {
        boxcheck(horaire[i]);
        if (validation === true) {
            validationHoraire = validation;
            break;
        }
        else {
            horaireBox.style.backgroundColor = "var(--rouge25)";
        }
    }
    if (validationHoraire === true) {
        horaireBox.style.backgroundColor = "transparent";
    }
    if (validationCaptcha === true 
        && validationHoraire === true
        // && validationInscrit === true // inutile mini force à 1 en html
        ) {
            envoyer.disabled = false;

    }
    else {
        envoyer.disabled = true;
    }
});

//--------------------------------------------------
//             prix de la prestation
//--------------------------------------------------

function getPrixTotal() {
    let prixUnitaire = parseFloat(document.getElementById('prix_unitaire').innerHTML);
    let prix = document.getElementById('prix');
    
    nbrInscrit.addEventListener('input', function() {
        let prix_total = (prixUnitaire*parseFloat(nbrInscrit.value)).toFixed(2);
        if (isNaN(prix_total) ) {
            prix.innerHTML = '0';
        }
        else {
            prix.innerHTML = prix_total;
        }
    });
}