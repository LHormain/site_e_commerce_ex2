<?php
include_once('controler/traitement_ateliers_gestion_choix_inscriptions.php');
?>


<form action="index.php?page=310&c=2" method="post"  class="col-10  text-start" >
    <div class="row">
        <h3 class="text-center">Choisir un atelier</h3>
        <small id="helpId" class="form-text text-muted mt-5 pt-5 offset-1">Choisir une option</small>
        <!-- ateliers -->
        <div class="mb-3 offset-1">
            <select class="form-select form-select-lg" name="id_atelier" id="id_atelier" > 
                <?php 
                    
                    echo $select_atelier;
                ?>
            </select>
        </div>
    </div>
    <div class="text-end">
        <input type="submit" value="Choisir" class="btn btn-camel text-light  col-3 mb-3 ms-auto align-self-end">
    </div>
</form>
