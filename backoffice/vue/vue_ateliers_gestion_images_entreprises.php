<?php
include_once('controler/traitement_ateliers_gestion_images_entreprises.php');
?>
<!-- pour la partie il nous ont fait confiance -->
<div class="col-6 mt-5">
    <h4>Listes des entreprises clientes</h4>
    <div class="mt-5 text-start">
        <a
            class="btn btn-camel text-light   mb-3"
            href="index.php?page=320&c=2&l=1"
            role="button"
            >Ajouter une entreprise</a
        >
    </div>
    <div class="d-flex justify-content-end">
        <?php table_legend();?>
    </div>
    <div
        class="table-responsive "
    >
        <table
            class="table table-anticbeige table-striped"
        >
            <thead>
                <caption>
                </caption>
                <tr>
                    <th scope="col">Logo</th>
                    <th scope="col">Afficher</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    echo $table_logo;
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- pour les sliders -->
<div class="col-6 mt-5">
    <h4>Liste des images pour illustrer la page</h4>
    <div class="text-start mt-5">

        <a
            class="btn btn-camel text-light  mb-3"
            href="index.php?page=320&c=2&l=0"
            role="button"
            >Ajouter une Image</a
        >
    </div>
    <div class="d-flex justify-content-end">
    <?php table_legend();?>
</div>
    <div
        class="table-responsive "
    >
        <table
            class="table table-anticbeige table-striped"
        >
            <thead>
                <caption>
                </caption>
                <tr>
                    <th scope="col">Images</th>
                    <th scope="col">Afficher</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    echo $table_image;
                ?>
            </tbody>
        </table>
    </div>
    
</div>

<script src="public/assets/js/gestion_affichage_teambuilding.js"></script>
<script src="public/assets/js/input_position_txt_teambuilding.js"></script>