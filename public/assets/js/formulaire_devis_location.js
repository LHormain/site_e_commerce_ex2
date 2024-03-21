//--------------------------------------------------------------
//             validation de l'inscription à un atelier
//--------------------------------------------------------------
let date = document.getElementById('date_evenement_devis');
let nbr = document.getElementById('nbr_invite');
let type = document.getElementById('type_evenement');
let adresse = document.getElementById('adresse_evenement');

let condition = document.getElementById('condition');
let conditionLabel = document.getElementById('condition_label');
let codeTest = document.getElementById('captcha');
let envoyer = document.querySelector('input[type=submit]');
let test = document.getElementById('test');

if (typeof date.value != 'undefined') {
    var validationDate = true;
}
else {
    var validationDate = false;
}
if (typeof nbr.value != 'undefined') {
    var validationNbr = true;
}
else {
    var validationNbr = false;
}
if (typeof type.value != 'undefined') {
    var validationType = true;
}
else {
    var validationType = false;
}
if (typeof adresse.value != 'undefined') {
    var validationAdresse = true;
}
else {
    var validationAdresse = false;
}


let validationCaptcha = false;
let validationCondition = false;
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
        elementTester.style.backgroundColor = "var(--rouge25)";
        validation = false;
    }
    else {
        validation = true;
        elementTester.style.backgroundColor = "transparent";
    }
    return validation;
}
// test input number
function numberCheck(elementTester, minimum) {
    if (elementTester.value < minimum) {
        elementTester.style.backgroundColor = "var(--rouge25)";
        validation = false;
    }
    else {
        validation = true;
        elementTester.style.backgroundColor = "transparent";
    }
    return validation;
}
// test select
function selectCheck(elementTester) {
    if (elementTester.options[elementTester.selectedIndex].value != '-') {
        validation = true;
        elementTester.style.backgroundColor = "transparent";
    }
    else {
        validation = false;
        elementTester.style.backgroundColor = "var(--rouge25)";
    }
    return validation;
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

// -----------------------------------------------------
//                 addEventListeners
// -----------------------------------------------------
date.addEventListener('blur', function() {
    // 
    lengthcheck(date, 3);
    validationDate = validation;
});

nbr.addEventListener('blur', function() {
    // 
    numberCheck(nbr, 1);
    validationNbr = validation;
});

type.addEventListener('blur', function() {
    // 
    selectCheck(type);
    validationType = validation;
});

adresse.addEventListener('blur', function() {
    lengthcheck(adresse, 8);
    validationAdresse = validation;
});



codeTest.addEventListener('blur', function() {
    //captcha
    captchaTest(codeTest);
});

document.addEventListener('click', function() {

    boxcheck(condition);

    if (validationCaptcha === true 
        && validationDate === true 
        && validationNbr === true 
        && validationType === true
        && validationAdresse === true
        && validationCondition === true
        ) {
            envoyer.disabled = false;

    }
    else {
        envoyer.disabled = true;
    }
});

