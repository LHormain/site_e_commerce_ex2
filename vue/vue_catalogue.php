<?php
include_once('controler/traitement_catalogue.php');
?>
<div class="container ht_page ">
    <div class="row my-3 my-lg-5 mx-3">
        <!-- fils d'Ariane -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=201&s=<?php echo $id_section;?>&f=<?php echo $id_sous_cat;?>"><?php echo $section['nom_section']; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $categorie['nom_categorie']; ?></li>
            </ol>
        </nav>
        <!-- titre de la page -->
        <section class="offset-md-1 col-md-10">
            <h1 class="text-center"><?php echo $categorie['nom_categorie']; ?></h1>
            <p class="text-justify">
                <?php echo $categorie['descriptif_categorie']; ?>
            </p>
        </section>
        <!-- navigation dans la section - PC et tablette -->
        <nav class="offset-md-1 offset-lg-0 col-md-3 col-lg-3 mt-lg-5 mt-3 d-none d-md-block">
            <h2 class="fs-5"><?php echo $section['nom_section'];?></h2>
            <!-- categories -->
            <ul class="p-0">
                <?php echo $liste_cat; ?>
            </ul>
            <!-- sous catégories -->
            <h2 class="fs-5">Thèmes</h2>
            <div class="row">
                <div class="form-check col-lg-6">
                    <input class="form-check-input" type="radio" name="theme" id="0" value="<?php echo $id_section.'-'.$id_categorie; ?>"checked/>
                    <label class="form-check-label" for="0"> Tous </label>
                </div>
                <?php echo $liste_sous_cat; ?>
            </div>
            <!-- test partenaire marge -->
            <?php if ($id_section == 3) {
                ?>
            <a href="index.php?page=211" class="btn btn-link rounded-pill mt-3 ps-0 fs-5 link_catalogue text-dark text-start ">Décorations sur mesure</a>
            <a href="index.php?page=210" class="btn btn-link rounded-pill mt-3 ps-0 fs-5 link_catalogue text-dark text-start ">Découvrez nos partenaires</a>
                <?php
            }
            ?>
        </nav>
        <!-- navigation dans la section - telephone -->
        <div class="accordion accordion-flush d-md-none" id="accordionNavTel">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne"
                        aria-expanded="true"
                        aria-controls="flush-collapseOne"
                    >
                        <h2 class="fs-5">Catégories</h2>
                    </button>
                </h2>
                <div
                    id="flush-collapseOne"
                    class="accordion-collapse collapse"
                    aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionNavTel"
                >
                    <div class="accordion-body">
                        <!-- categories -->
                        <ul class="p-0">
                            <?php echo $liste_cat; ?>
                        </ul>
                        <!-- sous catégories -->
                        <h2 class="fs-5">Thèmes</h2>
                        <div class="row">
                            <div class="form-check col-lg-6">
                                <input class="form-check-input" type="radio" name="theme" id="0" value="<?php echo $id_section; ?> "checked/>
                                <label class="form-check-label" for="0"> Tous </label>
                            </div>
                            <?php echo $liste_sous_cat; ?>
                        </div>
                        <!-- test partenaire marge -->
                        <?php if ($id_section == 3) {
                            ?>
                        <a href="index.php?page=211" class="btn btn-link rounded-pill mt-3 ps-0 fs-5 link_catalogue text-dark text-start ">Décorations sur mesure</a>
                        <a href="index.php?page=210" class="btn btn-link rounded-pill mt-3 ps-0 fs-5 link_catalogue text-dark text-start ">Découvrez nos partenaires</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- affichage des produits de la catégorie -->
        <section class="col-md-7 col-lg-9 mt-lg-5 mt-3">
            <div class="row">
                <!-- filtres supplémentaire et nombre de produit -->
                <div class="d-flex justify-content-between">
                    <div>
                        Produit <?php echo $offset+1;?> à <?php if($offset+$nbr_entree_page > $nbr_entree) {echo $nbr_entree;} else {echo $offset+$nbr_entree_page;} ;?> sur <?php echo $nbr_entree;?>
                    </div>
                    <div class="d-flex flex-nowrap">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="promo" 
                                id="promo" 
                                value="<?php echo $id_section.'-'.$id_categorie.'-'.$id_sous_cat; ?>"
                                <?php if ($p == 1) {echo 'checked';} ?>
                            />
                            <label class="form-check-label me-3" for="promo"> Promotions </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="unique"
                                id="unique"
                                value="<?php echo $id_section.'-'.$id_categorie.'-'.$id_sous_cat; ?>"
                                <?php if ($u == 1) {echo 'checked';} ?>
                            />
                            <label class="form-check-label me-3" for="unique">
                                Pièce unique
                            </label>
                        </div>
                        
                    </div>

                </div>
                <!-- produits -->
                <?php echo $cards_produits; ?>

            </div>
            
            <!-- pagination -->
            <nav aria-label="Page navigation " class="d-flex justify-content-center my-5">
                <ul class="pagination ">
                    <?php
                        echo $pagination;
                    ?>
                </ul>
            </nav>
            
        </section>
    </div>
</div>
<script src="public/assets/js/select_radio_sous_cat_catalogue.js"></script>
<script src="public/assets/js/card_panier.js"></script>