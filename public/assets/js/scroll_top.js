    // gestion du bouton "scroll to the top"
    let boutonTop = document.getElementById("btnTop");

    window.onscroll = function() {scrollFunction()};
    window.onload = function() {boutonTop.style.display = "none";}

    function scrollFunction() {
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            boutonTop.style.display = "block";
        }
        else {
            boutonTop.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    