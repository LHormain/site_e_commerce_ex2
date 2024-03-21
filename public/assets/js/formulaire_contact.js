//--------------------------------------------------------------
//             validation de l'inscription à un atelier
//--------------------------------------------------------------
let nom = document.getElementById('nom_contact');
let tel = document.getElementById('tel_contact');
let email = document.getElementById('mail_contact');
let message = document.getElementById('message_contact');
let condition = document.getElementById('condition');
let conditionLabel = document.getElementById('condition_label');
let codeTest = document.getElementById('captcha');
let envoyer = document.querySelector('input[type=submit]');

let validationCaptcha = false;
let validationNom = false;
let validationMail = false;
let validationTel = false;
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
// -----------------------------------------------------
//                 addEventListeners
// -----------------------------------------------------
nom.addEventListener('input', function() {
    // nom
    lengthcheck(nom, 3);
    validationNom = validation;
});

tel.addEventListener('input', function() {
    // telephone
    lengthcheck(tel, 8);
    validationTel = validation;
});

email.addEventListener('blur', function() {
    mailTest(email);
});

codeTest.addEventListener('blur', function() {
    //captcha
    captchaTest(codeTest);
});

document.addEventListener('click', function() {
    lengthcheck(nom, 2);
    validationNom = validation;
    lengthcheck(tel, 2);
    validationTel = validation;
    mailTest(email);
    captchaTest(codeTest);
    boxcheck(condition);

    if (validationCaptcha === true 
        && validationNom === true 
        && validationTel === true 
        && validationMail === true
        && validationCondition === true
        ) {
            envoyer.disabled = false;

    }
    else {
        envoyer.disabled = true;
    }
});

