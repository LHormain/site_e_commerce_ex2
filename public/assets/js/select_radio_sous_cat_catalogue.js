
// restreindre les résultats au promo et/ou au pièces uniques
let promo = document.getElementById('promo');
let unique = document.getElementById('unique');

function promoIsChecked(promo) {
    if (promo.checked) {
        p = '&p=' + 1;
    }
    else {
        p = '';
    }
    return p;
}

function uniqueIsChecked(unique) {
    if (unique.checked) {
        u = '&u=' + 1;
    }
    else {
        u = '';
    }
    return u;
}

promo.addEventListener('click', function() {
    let myarray = promo.value.split("-");
    let section = myarray[0];
    let cat = myarray[1];
    let theme = myarray[2];

    let u = uniqueIsChecked(unique);
    let p = promoIsChecked(promo);
    window.location.assign('index.php?page=202&s=' + section + '&f=' + theme + '&c=' + cat + p + u);
});
unique.addEventListener('click', function() {
    let myarray = unique.value.split("-");
    let section = myarray[0];
    let cat = myarray[1];
    let theme = myarray[2];


    let u = uniqueIsChecked(unique);
    let p = promoIsChecked(promo);
    window.location.assign('index.php?page=202&s=' + section + '&f=' + theme + '&c=' + cat + p + u );
});

// permet de choisir la sous cat proposer dans le menu du coté de la page sous cat
let allSousCat = document.getElementsByName('theme');

allSousCat.forEach(sousCat => {
    sousCat.addEventListener('click', function() {
        if (sousCat.checked) {
            let theme = sousCat.id;
            let myarray = sousCat.value.split("-");
            let section = myarray[0];
            let cat = myarray[1];
            let u = uniqueIsChecked(unique);
            let p = promoIsChecked(promo);
            window.location.assign('index.php?page=202&s=' + section + '&f=' + theme + '&c=' + cat+ p + u );
        }
    });
});