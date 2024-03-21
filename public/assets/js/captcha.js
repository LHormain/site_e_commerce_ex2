// --------------------------------------------------------------------------------
//                           CAPTCHA
// --------------------------------------------------------------------------------

// création du code aléatoire
function randomNumber() { // de 1 à 9
    let number = Math.floor(Math.random()*9)+1;
    return number;
}

function randomChainNumber(length) {
    let result = '';
    let chiffre = 0;

    for (let i = 0; i < length; i++) {
        chiffre = randomNumber();
        result += chiffre.toString();
    }
    return result;
}

function randomString(length) {
    let result = '';
    const characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.random()*characters.length);
    }

    return result;
}

function afficheCode(stringChaine, numberChaine) {
    result = '';

    let partOfString = Math.floor(Math.random()*stringChaine.length);
    let partOfNumber = Math.floor(Math.random()*numberChaine.length);

    for (let i = 0; i < partOfString; i++) {
        result += stringChaine.charAt(i);
    }
    for (let i = 0; i < partOfNumber; i++) {
        result += numberChaine.charAt(i);
    }
    for (let i = partOfString; i < stringChaine.length; i++) {
        result += stringChaine.charAt(i); 
    }
    for (let i = partOfNumber; i < numberChaine.length; i++) {
        result += numberChaine.charAt(i);
    }
    return result;
}

let chaineMaxlenght = 15;
let chaineNumber = randomNumber();
let chaineNumberCode = randomChainNumber(chaineNumber);
let chaineStringCode = randomString(chaineMaxlenght - chaineNumber);

let code = document.getElementById('code');

code.innerHTML = afficheCode(chaineStringCode, chaineNumberCode);
    
    
