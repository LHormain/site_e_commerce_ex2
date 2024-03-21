<?php
include_once('controler/traitement_filtres_gestion.php');
?>
<div class="offset-1 col-10 mt-5">
    <form action="#" method="post" class="row align-items-center">
        <div class="mb-3 col-10 text-start">
            <label for="section" class="form-label">Choisir la catégorie de caractéristique à customiser</label>
            <select
                class="form-select form-select-lg"
                name="table"
                id="table"
                >
                <option value="couleurs" <?php if($table == 'couleurs') {echo 'selected';} ?>>Couleur</option>
                <option value="matieres" <?php if($table == 'matieres') {echo 'selected';} ?>>Matière</option>
                <option value="autres_tailles" <?php if($table == 'autres_tailles') {echo 'selected';} ?>>Dimension modifiable</option>
                <option value="customisations" <?php if($table == 'customisations') {echo 'selected';} ?>>Autre customisation</option>
            </select>
        </div>
        <div class="col-2">
            <input type="submit" value="Choisir" class="btn btn-camel text-light ">
        </div>
    </form>

    <?php
        if ((isset($_POST['table']) && $_POST['table'] != NULL) || (isset($_GET['table']) && $_GET['table'] != NULL)) {
            ?>
            <div
                class="table-responsive mt-3"
            >
                <table
                    class="table table-striped table-hover table-borderless table-anticbeige align-middle"
                >
                    <thead class="table-light">
                        <caption>
                        </caption>
                        <tr>
                            <th><a href="index.php?page=510&c=1&table=<?php echo $table; ?>&ordre=1">Nom</a> </th>
                            <th><a href="index.php?page=510&c=1&table=<?php echo $table; ?>&ordre=2">Ordre d'affichage</a></th>
                            <?php if ($table == 'couleurs' || $table == 'matieres') { ?><th>Illustration</th> <?php } ?>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    </tbody>
                        <?php echo $table_gestion; ?>
                    <tfoot>
                        
                    </tfoot>
                </table>
            </div>
            <?php
        }
    ?>
    
</div>

<script src="public/assets/js/input_position_custom.js"></script>