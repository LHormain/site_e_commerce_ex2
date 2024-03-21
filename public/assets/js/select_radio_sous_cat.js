// permet de choisir la sous cat proposer dans le menu du coté de la page sous cat
let allSousCat = document.getElementsByName('theme');

allSousCat.forEach(sousCat => {
    sousCat.addEventListener('click', function() {
        if (sousCat.checked) {
            let theme = sousCat.id;
            let section = sousCat.value;
            window.location.assign('index.php?page=201&s=' + section + '&f=' + theme);
        }
    });
});