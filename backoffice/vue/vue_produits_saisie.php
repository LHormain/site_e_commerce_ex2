<?php
include_once('controler/traitement_produits_saisie.php');
?>
<div class="offset-2 col-8 mt-5">
    <h3><?php echo $titre; ?></h3>
    <form action="#" method="post" class="mt-3 text-start row" enctype="multipart/form-data">
        <h4><?php echo $texte_page_courante; ?> </h4>
        <p class="text-center mb-3">Tous les champs n'appartenant pas à la partie customisation sont obligatoires</p>
            <!-- nom -->
            <div class="mb-3">
                <label for="nom_produit" class="form-label">Nom du produit</label>
                <input
                    type="text"
                    class="form-control"
                    name="nom_produit"
                    id="nom_produit"
                    aria-describedby="helpId1"
                    value="<?php echo $nom_produit; ?>"
                    placeholder=""
                />
                <small id="helpId1" class="form-text text-muted">Désignation du produit</small>
            </div>
            
            <!-- description  -->
            <div class="mb-3">
                <label for="description_produit" class="form-label">Description du produit</label>
                <textarea class="form-control" name="description_produit" id="description_produit" rows="3"><?php echo $description_produit; ?></textarea>
            </div>
            <!-- produit en promotion -->
            <div class="d-flex mb-3">
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="promo_produit" 
                        id="promo" 
                        value="1"
                        <?php if ($promo_produit == 1) { echo 'checked';} ?>
                    />
                    <label class="form-check-label me-5" for="promo"> Produit en promo </label>
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="promo_produit"
                        id="no_promo"
                        value="0"
                        <?php if ($promo_produit == 0) { echo 'checked';} ?>
                    />
                    <label class="form-check-label" for="no_promo">
                        Ce produit n'est pas en promo
                    </label>
                </div>
            </div>
            <!-- section -->
            <div class="mb-3 col-6">
                <label for="section" class="form-label">Section de la boutique à laquelle appartient le produit</label>
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
            <div class="">
                <div class="row">
                    <!-- catégorie -->
                    <div class="mb-3 col-6 ">
                        <label for="id_cat" class="form-label">Catégorie à laquelle appartient le produit</label>
                        <select
                            class="form-select form-select-lg"
                            name="id_cat"
                            id="id_cat"
                        >
                            <?php
                            echo $select_cat;
                            ?>
                        </select>
                    </div>
                    <!-- filtre -->
                    <div class="mb-3 col-6">
                        <label for="id_filtre" class="form-label">Sous catégorie à laquelle appartient le produit</label>
                        <select
                            class="form-select form-select-lg"
                            name="id_filtre"
                            id="id_filtre"
                        >
                            <?php
                            echo $select_filtre;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- prix  -->
            <div class="mb-3 col-6">
                <label for="prix_ht_produit" class="form-label">Prix HT</label>
                <input
                    type="text"
                    class="form-control"
                    name="prix_ht_produit"
                    id="prix_ht_produit"
                    aria-describedby="helpId2"
                    placeholder=""
                    value="<?php echo $prix_ht_produit; ?>"
                />
                <small id="helpId2" class="form-text text-muted">Prix hors taxe en euro</small>
            </div>
            <div class="mb-3 col-6">
                <label for="prixTTC" class="form-label">Prix TTC</label>
                <input
                    type="text"
                    class="form-control"
                    name="prixTTC"
                    id="prixTTC"
                    aria-describedby="helpId2"
                    placeholder=""
                    value="<?php echo $prix_ht_produit*(1+20/100); ?>"
                />
                <small id="helpId2" class="form-text text-muted">Prix toute taxes comprises en euro</small>
            </div>
            <!-- origine -->
            <div class="mb-3 col-6">
                <label for="origine_produit" class="form-label">Origine du produit</label>
                <input
                    type="text"
                    class="form-control"
                    name="origine_produit"
                    id="origine_produit"
                    aria-describedby="helpId9"
                    value="<?php echo $origine_produit; ?>"
                    placeholder=""
                />
                <small id="helpId9" class="form-text text-muted">Pays d'origine du produit</small>
            </div>
            <div class="mb-3 col-6">
                <label for="estim_tps_livraison" class="form-label">Estimation du temps de livraison</label>
                <input
                    type="text"
                    class="form-control"
                    name="estim_tps_livraison"
                    id="estim_tps_livraison"
                    aria-describedby="helpId10"
                    placeholder="ex : de 2 à 3 semaines"
                    value="<?php echo $estim_tps_livraison; ?>"
                />
                <small id="helpId10" class="form-text text-muted">Estimation du temps de livraison à afficher sur la page produit</small>
            </div>
            
            <!-- devis livraison ou non -->
            <div class="d-flex ">

                <div class="form-check me-3">
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="devis_obligatoire" 
                        id="no_devis" 
                        value="0"
                        <?php if ($devis == 0) { echo 'checked'; } ?>
                        />
                    <label class="form-check-label" for="no_devis"> Ne nécessite pas un devis livraison </label>
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="devis_obligatoire"
                        id="devis"
                        value="1"
                        <?php if ($devis == 1) {echo 'checked';} ?>
                        
                    />
                    <label class="form-check-label" for="devis">
                        Nécessite obligatoirement un devis livraison
                    </label>
                </div>
            </div>
            
        <!-- dimensions -->
        <fieldset class="mt-5">
            <legend>Dimensions du produit</legend>
            <div class="row">
                <input type="hidden" name="id_taille_ref" value="<?php echo $id_taille_ref; ?>">
                <div class="mb-3 col-6">
                    <label for="longueur_ref_produit" class="form-label">Longeur</label>
                    <input
                        type="text"
                        class="form-control"
                        name="longueur_ref_produit"
                        id="longueur_ref_produit"
                        aria-describedby="helpId3"
                        placeholder=""
                        value="<?php echo $longueur_ref_produit; ?>"
                    />
                    <small id="helpId3" class="form-text text-muted">Longueur du produit en cm. Si customisable, longueur par défaut donnée par le fournisseur</small>
                </div>
                <div class="mb-3 col-6">
                    <label for="largeur_ref_produit" class="form-label">Largeur</label>
                    <input
                        type="text"
                        class="form-control"
                        name="largeur_ref_produit"
                        id="largeur_ref_produit"
                        aria-describedby="helpId4"
                        placeholder=""
                        value="<?php echo $largeur_ref_produit;?>"
                    />
                    <small id="helpId4" class="form-text text-muted">Largeur du produit en cm. Si customisable, largeur par défaut donnée par le fournisseur</small>
                </div>
                <div class="mb-3 col-6">
                    <label for="hauteur_ref_produit" class="form-label">Hauteur</label>
                    <input
                        type="text"
                        class="form-control"
                        name="hauteur_ref_produit"
                        id="hauteur_ref_produit"
                        aria-describedby="helpId5"
                        placeholder=""
                        value="<?php echo $hauteur_ref_produit; ?>"
                    />
                    <small id="helpId5" class="form-text text-muted">Hauteur du produit en cm. Si customisable, hauteur par défaut donnée par le fournisseur</small>
                </div>
                <!-- poids -->
                <div class="mb-3 col-6">
                    <label for="poids_produit" class="form-label">Poids</label>
                    <input
                        type="text"
                        class="form-control"
                        name="poids_produit"
                        id="poids_produit"
                        aria-describedby="helpId6"
                        placeholder=""
                        value="<?php echo $poids_produit; ?>"
                    />
                    <small id="helpId6" class="form-text text-muted">Poids en gramme du produit pour le calcul du tarif de livraison</small>
                </div>
            </div>
        </fieldset>
        
        <!-- customisable -->
        <fieldset class="mt-5">
            <legend>Customization</legend>
            <p class="text-muted">Pour les produits customizable : si une option est coché le champs contenant le prix de cette customisation est obligatoire. Si l'augmentation du prix est nulle mettre 0. </p>
            <div class="row">
                <div class="d-flex">
                    <div class="form-check">
                        <input 
                            class="form-check-input " 
                            type="radio" 
                            name="customisable" 
                            id="custo" 
                            value="1"
                            <?php if ($customisable == 1) {echo 'checked';} ?>
                        />
                        <label class="form-check-label me-5" for="custo"> customisable </label>
                    </div>
                    <div class="form-check ">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="customisable"
                            id="no_custo"
                            value="0"
                            <?php if ($customisable == 0) {echo 'checked';} ?>
                        />
                        <label class="form-check-label" for="no_custo">
                            Non customisable
                        </label>
                    </div>
                </div>
                <!-- couleur -->
                <h5 class="mt-3">Couleurs disponibles</h5>
                <!-- checkbox pour plusieurs choix customisable -->
                <div class="d-flex flex-wrap visually-hidden" id="couleur_checkbox">
                    <?php echo $select_couleurs[0]; ?>
                </div>
                <!-- radio pour une seule couleur non customisable -->
                <div class="d-flex flex-wrap" id="couleur_radio">
                    <?php echo $select_couleurs[1]; ?>
                </div>
                <!-- matière -->
                <h5 class="mt-3">Matière</h5>
                <div class="d-flex flex-wrap visually-hidden" id="matiere_checkbox">
                    <?php echo $select_matieres[0]; ?>
                </div>
                <div class="d-flex flex-wrap" id="matiere_radio">
                    <?php echo $select_matieres[1]; ?>
                </div>
                <!-- taille  -->
                <div class="visually-hidden" id="taille_custo">
                    <h5 class="mt-3">Autres tailles disponibles</h5>
                    <div>
                        <?php echo $select_jeux_tailles; ?>
                        <h6>Ajouter une taille</h6>
                        <div class="d-flex justify-content-between" >
                            <div class="mb-3 w-20">
                                <label for="longueur_new" class="form-label">Longueur</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="longueur_new"
                                    id="longueur_new"
                                    aria-describedby="longueur_new"
                                    placeholder=""
                                    value=""
                                />
                                <small id="longueur_new" class="form-text text-muted">longueur disponible</small>
                            </div>
                            <div class="mb-3 w-20">
                                <label for="largeur_new" class="form-label">Largeur</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="largeur_new"
                                    id="largeur_new"
                                    aria-describedby="largeur_new"
                                    placeholder=""
                                    value=""
                                />
                                <small id="largeur_new" class="form-text text-muted">Largeur disponible</small>
                            </div>
                            <div class="mb-3 w-20">
                                <label for="hauteur_new" class="form-label">Hauteur</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="hauteur_new"
                                    id="hauteur_new"
                                    aria-describedby="hauteur_new"
                                    placeholder=""
                                    value=""
                                />
                                <small id="hauteur_new" class="form-text text-muted">Hauteur disponible</small>
                            </div>
                            <div class="mb-3 w-20">
                                <label for="prix_dimensions_new" class="form-label">Incrément prix</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="prix_dimensions_new"
                                    id="prix_dimensions_new"
                                    aria-describedby="prix_dimensions_new"
                                    placeholder=""
                                    value=""
                                />
                                <small id="prix_dimensions_new" class="form-text text-muted">Pour le calcul du nouveau prix après choix des dimensions de l\'objet</small>
                            </div>
                        </div>
                    </div>
                    <h5 class="mt-3">Autres dimensions modifiable</h5>
                    <div id="taille_custo_inner">
                        <?php echo $select_tailles; ?>
                    </div>
                </div>
                <!-- autre customisation  -->
                <div class="visually-hidden" id="autre_custo">
                    <h5 class="mt-3">Autre customisation</h5>
                    <div class="d-flex flex-wrap">
                        <?php echo $select_custom[0]; ?>
                    </div>
                </div>
            </div>
        </fieldset>
        <input type="submit" value="Enregistrer" class="btn btn-camel text-light  col-3 mb-3 ms-auto align-self-end rounded-pill">
    </form>
</div>

<script src="public/assets/js/select_sous_cat.js"></script>