<?php
include_once('controler/traitement_galerie_txt.php');
?>
<h3 class="mt-5">Sur mesure : nos réalisations</h3>
<div class="row">
    <div class="offset-1 col-4 mt-3">
        <!-- gestion des paragraphes -->
        <h4>Paragraphes</h4>
        <p>Texte d'accueil de la section sur mesure du site</p>
        <div class="text-start">
            <a
                class="btn btn-camel text-light  my-3"
                href="index.php?page=830&c=5&sc=3"
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
                        <th scope="col">Texte</th>
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
        
    </div>
    <!-- aperçu de la page finale -->
    <div class="col-6 mt-3">
        <h4>Aperçu</h4>
        <div class="row mt-3 border py-3 mx-3">
            <?php echo $simulation;?>
        </div>
    </div>
</div>