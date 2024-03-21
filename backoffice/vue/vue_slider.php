<?php
include_once('controler/traitement_slider.php');
?>
<h3 class="mt-3">Qui sommes-nous</h3>
<div class="row">
    <div class="offset-1 col-4">
        <!-- gestion des paragraphes -->
        <h4>Texte</h4>
        <p>Attention. L'ordre des textes correspond à l'ordre des images.</p>
        <div class="text-start">
            <a
                class="btn btn-camel text-light  my-3"
                href="index.php?page=830&c=5&sc=4"
                role="button"
                >Ajouter un slide</a
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
        <p>Important : Pour conserver un aspect régulier entre les slides il faut que toutes les images aient le même ratios (16x9 (large) ou 21x9 (ultra-large)). </p>
        <div class="text-start">
            <a
                class="btn btn-camel text-light  my-3"
                href="index.php?page=830&c=6&sc=4"
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
    <div class="col-6 mb-5">
        <h4>Aperçu</h4>
        <div class="row mt-3 border py-3 mx-3">
            <div id="carouselAccueil" class="carousel slide  position-relative" data-bs-ride="carousel">
                <h1 class="text-center m-lg-5 m-4 position-absolute text-white bg_accueil">Vente de mobiliers, décorations et reproductions historique</h1>
                <ol class="carousel-indicators">
                    <?php echo $carousel_indicator;?>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php echo $carousel_inner;?>
                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselAccueil"
                    data-bs-slide="prev"
                >
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselAccueil"
                    data-bs-slide="next"
                >
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            
        </div>
    </div>
</div>