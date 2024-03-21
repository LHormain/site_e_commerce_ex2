let livraison = document.getElementById('livraison');
livraison.addEventListener('click', function() {
    let id_livraison = document.getElementById('id_livraison');
    let choix = livraison.options[livraison.selectedIndex].value;
    id_livraison.value = choix;
});

let facturation = document.getElementById('facturation');
facturation.addEventListener('click', function() {
    let id_facturation = document.getElementById('id_facturation');
    let choix = facturation.options[facturation.selectedIndex].value;
    id_facturation.value = choix;
});