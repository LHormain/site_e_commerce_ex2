<?php
include_once('controler/traitement_ateliers_gestion_texte_entreprises.php');
?>

<div class="col-6 text-start">
    <h4 class="mt-5">Texte de présentation</h4>
    <a
        class="btn btn-camel text-light mb-3  mt-5"
        href="index.php?page=320&c=3"
        role="button"
        >Ajouter un paragraphe de description</a
    >
    <div class="d-flex justify-content-end">
        <?php table_legend();?>
    </div>
    <div
        class="table-responsive "
    >
        <table
            class="table table-anticbeige table-striped"
        >
            <caption>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Position</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Afficher</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    echo $table_texte;
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-6 align-self-center mt-5">
    <h4>Aperçu du texte</h4>
    <div class="border">
        <?php
            echo $sortie;
        ?>
    </div>
</div>

<script src="public/assets/js/gestion_affichage_teambuilding.js"></script>
<script src="public/assets/js/input_position_txt_teambuilding.js"></script>