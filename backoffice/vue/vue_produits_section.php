<?php
include_once('controler/traitement_produits_section.php');
?>
<h3 class="mt-5">Gestion</h3>
<div class="offset-1 col-10 mt-5">
    <form action="index.php?page=520&c=1" method="post" class="row align-items-center">
        <div class="mb-3 col-10 text-start">
            <label for="section" class="form-label">Choisir une Section de la boutique</label>
            <select
            class="form-select form-select-lg"
            name="section"
            id="section"
            >
                <?php
                    echo $select;
                    ?>
            </select>
        </div>
        <div class="col-2">
            <input type="submit" value="Choisir" class="btn btn-camel text-light ">
        </div>
    </form>
    
</div>