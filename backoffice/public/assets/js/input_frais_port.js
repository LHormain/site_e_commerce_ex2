///---------------------------------------------------------------------
//            Modification des frais de port pour les petits colis
///---------------------------------------------------------------------
function changementPrix(poids, zone, valeur) {
    const xmlhttp = new XMLHttpRequest(); 
    
    xmlhttp.open("POST", "controler/requete_frais_port.php", true); 
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    xmlhttp.onload = function() { 
        window.location.assign(window.location.href);
    }
    
    data = ('poids='+ poids +'&zone='+ zone + '&valeur=' + valeur);
    xmlhttp.send(data);
}
    let allInput = document.querySelectorAll('.w-55');
    allInput.forEach(box => {
        let poids = box.id;
        let zone = box.name;
        
        box.addEventListener('change', function () {
            let valeur = box.value;
            changementPrix(poids,zone,valeur);
        });
    });