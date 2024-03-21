<?php
include_once('controler/traitement_deco.php');
?>
<h3 class="mt-3">Décoration sur mesure</h3>
<div class="row">
    <div class="offset-1 col-4">
        <!-- gestion des paragraphes -->
        <h4>Paragraphes</h4>
        <div class="text-start">
            <a
                class="btn btn-camel text-light  my-3"
                href="index.php?page=830&c=5&sc=2"
                role="button"
                >Ajouter un paragraphe</a
            >
        </div>
        <div
            class="table-responsive"
        >
            <table
                class="table table-striped table-hover table-borderless table-anticbeige align-middle"
            >
                <thead class="table-light">
                    <caption>
                    </caption>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php echo $table_texte;?>
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>

        <!-- gestion des images -->
        <h4 class="mt-5">Images</h4>
        <div class="text-start">
            <a
                class="btn btn-camel text-light  my-3"
                href="index.php?page=830&c=6&sc=2"
                role="button"
                >Ajouter une image</a
            >
        </div>
        <div
            class="table-responsive"
        >
            <table
                class="table table-striped table-hover table-borderless table-anticbeige align-middle"
            >
                <thead class="table-light">
                    <caption>
                    </caption>
                    <tr>
                        <th>Image</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php echo $table_image; ?>
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
        
    </div>
    <!-- aperçu de la page finale -->
    <div class="col-6 ">
        <h4>Aperçu</h4>
        <div class="row mt-3 border py-3 mx-3">
            <h1 class="fs-4 mb-3">Décoration sur mesure</h1>
            <?php echo $simulation;?>
            <div class="text-center mt-3 col-12">
                <button class="btn btn-gris-souris rounded-pill">Contactez-nous</button>
            </div>
        </div>
    </div>
</div>