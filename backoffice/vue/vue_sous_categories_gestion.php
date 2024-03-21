<?php
    include_once('controler/traitement_sous_categories_gestion.php');
?>
<h3 class="mt-5">Sous catégories</h3>
<div class="offset-1 col-10 mt-5">
    <form action="#" method="post" class="row align-items-center">
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
    
    <?php
        if (isset($_POST['section']) && $_POST['section'] != NULL) {
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
                            <th>Nom sous catégorie</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php echo $table; ?>
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>
            </div>
            <?php
        }
    ?>
    
</div>