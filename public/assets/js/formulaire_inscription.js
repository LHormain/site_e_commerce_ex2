//--------------------------------------------------------------
//             validation de l'inscription à un atelier
//--------------------------------------------------------------
let nom = document.getElementById('nom_utilisateur');
let prenom = document.getElementById('prenom_utilisateur');
let tel = document.getElementById('tel_utilisateur');
let email = document.getElementById('mail_utilisateur');

let numero = document.getElementById('numero_adresse_f');
let rue = document.getElementById('rue_adresse_f');
let code_p = document.getElementById('code_postal_adresse_f');
let ville = document.getElementById('ville_adresse_f');

let condition = document.getElementById('condition');
let conditionLabel = document.getElementById('condition_label');
let codeTest = document.getElementById('captcha');
let envoyer = document.querySelector('input[type=submit]');
let mdp1 = document.getElementById('mdp_utilisateur');
let mdp2 = document.getElementById('mdp_check');
let test = document.getElementById('test');

if (typeof nom.value != 'undefined') {
    var validationNom = true;
}
else {
    var validationNom = false;
}
if (typeof prenom.value != 'undefined') {
    var validationPrenom = true;
}
else {
    var validationPrenom = false;
}
if (typeof tel.value != 'undefined') {
    var validationTel = true;
}
else {
    var validationTel = false;
}
if (typeof email.value != 'undefined') {
    var validationMail = true;
}
else {
    var validationMail = false;
}

if (typeof numero.value != 'undefined') {
    var validationNum = true;
}
else {
    var validationNum = false;
}
if (typeof rue.value != 'undefined') {
    var validationRue = true;
}
else {
    var validationRue = false;
}
if (typeof code_p.value != 'undefined') {
    var validationCodeP = true;
}
else {
    var validationCodeP = false;
}
if (typeof ville.value != 'undefined') {
    var validationVille = true;
}
else {
    var validationVille = false;
}


let validationCaptcha = false;
let validationCondition = false;
let validation = false;

if (test.value == 2) {
    var validationMdp = true;
}
else {
    var validationMdp = false;
}

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
        elementTester.style.backgroundColor = "var(--rouge25)";
        validation = false;
    }
    else {
        validation = true;
        elementTester.style.backgroundColor = "transparent";
    }
    return validation;
}
// mail
function validateEmail(email) {
    let res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    return res.test(email);
}
function mailTest(email) {
    if (validateEmail(email.value)) {
        validationMail = true;
        email.style.backgroundColor = "transparent";
    }
    else {
        email.placeholder = email.value + " adresse non valide";
        email.value = '';
        email.style.backgroundColor = "var(--rouge25)";
        validationMail = false;
    }
    return validationMail;
}
// test checkbox condition
function boxcheck(elementTester) {
    if (elementTester.checked) {
        validationCondition = true;
        conditionLabel.style.backgroundColor = "transparent";
    }
    else {
        validationCondition = false;
        conditionLabel.style.backgroundColor = "var(--rouge25)";
    }
    return validationCondition;
}
function mdpCheck(elementTester,elementControl, minimum) {
    // 1 majuscule, 1 minucule, 1 chiffre, 1 caractère spécial, et un minimum de caractère
    // plus l'élément est égal au control
   if (elementTester.value.length >= minimum 
       && elementTester.value.match(/[0-9]/g) 
       && elementTester.value.match(/[A-Z]/g)
       && elementTester.value.match(/[a-z]/g)
       && elementTester.value.match(/[^a-zA-Z\d]/g)
       && elementTester.value == elementControl.value) {
       validation = true;
       elementTester.style.backgroundColor = "transparent";
       elementControl.style.backgroundColor = "transparent";
   }
   else  {
       elementTester.value = '';
       elementControl.value = '';
       elementTester.placeholder = minimum + ' caractères minimum';
       elementTester.style.backgroundColor = "var(--rouge25)";
       elementControl.style.backgroundColor = "var(--rouge25)";
       validation = false;
   }
   return validation;
}
// -----------------------------------------------------
//                 addEventListeners
// -----------------------------------------------------
nom.addEventListener('blur', function() {
    // nom
    lengthcheck(nom, 3);
    validationNom = validation;
});

prenom.addEventListener('blur', function() {
    // prénom
    lengthcheck(prenom, 3);
    validationPrenom = validation;
});

tel.addEventListener('blur', function() {
    // telephone
    lengthcheck(tel, 8);
    validationTel = validation;
});

email.addEventListener('blur', function() {
    mailTest(email);
});

numero.addEventListener('blur', function() {
    // numero
    lengthcheck(numero, 1);
    validationNum = validation;
});
rue.addEventListener('blur', function() {
    // rue
    lengthcheck(rue, 3);
    validationRue = validation;
});
code_p.addEventListener('blur', function() {
    // code postal
    lengthcheck(code_p, 3);
    validationCodeP = validation;
});
ville.addEventListener('blur', function() {
    // ville
    lengthcheck(ville, 3);
    validationVille = validation;
});


codeTest.addEventListener('blur', function() {
    //captcha
    captchaTest(codeTest);
});

mdp2.addEventListener('blur', function() {
    mdpCheck(mdp1, mdp2, 5);
    validationMdp = validation;

});
if (test.value == 2) {
    mdp1.addEventListener('blur', function() {
        mdpCheck(mdp1, mdp1, 5);
        validationMdp = validation;
    });
}

document.addEventListener('click', function() {

    boxcheck(condition);

    if (validationCaptcha === true 
        && validationNom === true 
        && validationTel === true 
        && validationMail === true
        && validationNum === true
        && validationRue === true
        && validationCodeP === true
        && validationVille === true
        && validationCondition === true
        && validationMdp === true
        ) {
            envoyer.disabled = false;

    }
    else {
        envoyer.disabled = true;
    }
});

