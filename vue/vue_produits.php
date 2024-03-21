<?php
include_once('controler/traitement_produits.php');
?>
<div class="container ht_page ">
    <div class="row">
        <!-- fils d'Ariane -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?page=201&s=<?php echo $produit['id_section'];?>&f=<?php echo $produit['id_filtre'];?>"><?php echo $produit['nom_section']; ?></a></li>
                <li class="breadcrumb-item"><a href="index.php?page=202&s=<?php echo $produit['id_section'];?>&f=<?php echo $produit['id_filtre'];?>&c=<?php echo $produit['id_cat']; ?>"><?php echo $produit['nom_categorie']; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $produit['nom_produit']; ?></li>
            </ol>
        </nav>
        <section>
            <div class="row mt-3 mt-lg-5">
                <!-- carousel images du produit -->
                <div class="col-lg-6 ">
                    <div id="carouselPageProduit" class="carousel slide mb-lg-5 mb-3 carousel-dark" data-bs-ride="carousel" >
                        <div class="carousel-indicators ">
                            <?php echo $carousel_indicator; ?>
                        </div>
                        <div class="carousel-inner" role="listbox">
                            <?php echo $carousel_item; ?>
                        </div>
                        <button
                            class="carousel-control-prev "
                            type="button"
                            data-bs-target="#carouselPageProduit"
                            data-bs-slide="prev"
                        >
                            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carouselPageProduit"
                            data-bs-slide="next"
                        >
                            <span class="carousel-control-next-icon " aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                </div>
                <!-- caractéristiques du produit -->
                <div class="col-lg-6">
                    <!-- promo -->
                    <div class="text-end mb-3">
                        <input type="hidden" id="promo" value="<?php echo $produit['promo_produit'];?>">
                        <input type="hidden" id="taux_promo" value="<?php echo $taux_promo; ?>">
                    <?php if (($produit['promo_produit']) == 1) { ?>
                        <span class=" rounded-pill bg-anticbeige p-2 m-3 fs-6 "><?php echo 'Promo'; ?></span>
                        <?php } ?>
                    </div>
                    <!-- nom du produit -->
                    <h1 class="text-center"><?php echo $produit['nom_produit']; ?></h1>
                    <!-- description -->
                    <p class="px-3 px-md-5">
                        <?php echo $produit['description_produit']; ?>
                    </p>
                    <!-- estimation du temps de livraison  -->
                    <p class="px-3 px-md-5">
                        Estimation du temps de livraison : <?php echo $produit['estim_tps_livraison']; ?>
                    </p>
                    <!-- configurable et ou unique -->
                    <input type="hidden" id="custo_etat" value="<?php echo $produit['customisable']; ?>">
                    <p class="px-3 px-md-5"><?php if ($produit['customisable'] == 1) { echo 'configurable ';} ?><?php if ($produit['piece_unique'] == 1) {echo ' pièce unique ';} ?></p>
                    <!-- prix -->
                    <div class="px-3 px-md-5">
                        <div class="visually-hidden" id="prix">
                            <?php echo number_format($produit['prix_ht_produit'],2,'.',' ');?>
                        </div>
                        <Strong class="fs-3" id="p_ttc"><?php echo number_format($produit['prix_ht_produit']*(1+20/100),2,'.',' '); ?> </Strong><strong class="fs-3"> € TTC </strong>
                        <div class="ms-5 d-inline">
                            (<strong id="p_ht" ><?php echo number_format($produit['prix_ht_produit'],2,'.',' ');?></strong>€ HT)
                        </div> 
                    </div>
                    <div
                        class="table-responsive px-3 px-md-5"
                    >
                        <table
                            class="table table-striped table-hover table-borderless table-taupe align-middle table_produit"
                            id="table_produit"
                        >
                            <tbody class="table-group-divider">
                                <!-- couleur -->
                                <?php
                                    if (!($couleurs[1] == 0 && $produit['customisable'] == 0)) {
                                        ?>
                                        <tr
                                            class="table-taupe <?php  ?>"
                                        >
                                            <td scope="row">Couleur</td>
                                            <td colspan=3><?php echo $couleur;?></td>
                                        </tr>
                                        <?php 
                                        echo $prix_couleur;
                                    }
                                    if (!($matieres[1] == 0 && $produit['customisable'] == 0)) {
                                        ?>
                                        <!-- matériaux -->
                                        <tr
                                            class="table-taupe "
                                        >
                                            <td scope="row">Materiel</td>
                                            <td colspan=3><?php echo $matiere;?></td>
                                        </tr>
                                        <?php 
                                        echo $prix_matiere;
                                    }
                                ?>
                                <!-- dimensions (longueur, largeur, hauteur) -->
                                <tr
                                    class="table-taupe "
                                >
                                    <td scope="row">Taille (cm)</td>
                                    <?php echo $taille;?>
                                </tr>
                                <?php 
                                    echo $prix_taille;
                                    if ($tailles[1] != 0) {
                                        ?>
                                        <!-- autres dimensions (diamètre, volume,...) -->
                                        <tr class="table-taupe ">
                                            <td scope="row">Autres dimensions</td>
                                            <?php echo $taille2;?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr class="table-taupe <?php if ($customs[1] == 0) {echo 'visually-hidden';}?>">
                                            <td scope="row">Autres caractéristique</td>
                                            <td colspan=3><?php echo $custom; ?></td>
                                        </tr>
                                        <?php echo $prix_custom;?>
                                        <?php
                                    if ($produit['origine_produit'] != NULL) {
                                        ?>
                                        <tr class="table-taupe ">
                                            <td scope="row">Origine</td>
                                            <td colspan=3><?php echo $produit['origine_produit'];?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- ajout au panier -->
                    <div class="quantite row justify-content-end">
                        <!-- identifiant du panier -->
                        <input type="hidden" id="panier" value="<?php if ($produit['id_section'] == 3) {echo $_SESSION['id_location'];} else {echo $_SESSION['id_commande'];} ?>" name="<?php if ($produit['id_section'] == 3) {echo 'location';} else {echo 'vente';} ?>">
                        <!-- identifiant client -->
                        <input type="hidden" id="identifiant_client" value="<?php if (isset($_SESSION['id_client'])) {echo $_SESSION['id_client'];} ?>">
                        <!-- caractéristique important pour produit custom -->
                        <input type="hidden" id="couleur_select" value="<?php echo $couleur_select; ?>">
                        <input type="hidden" id="matiere_select" value="<?php echo $matiere_select; ?>">
                        <input type="hidden" id="taille_select" value="<?php echo $taille_select; ?>">
                        <input type="hidden" id="autre_taille_select" value="<?php echo $autre_taille_select; ?>">
                        <input type="hidden" id="autre_taille_v" value="<?php echo $autre_taille_valeur; ?>">
                        <input type="hidden" id="custom_select" value="<?php echo $custom_select; ?>">
                        <!-- quantitée -->
                        <div class="d-flex flex-row col-3 align-items-center">
                            <button type="button" class="btn btn-button-light moins p-0 " id="btn_moins<?php echo $produit['id_produit']; ?>"><i class="fa-solid fa-minus" style="color: #fff;"></i></button>
                            <input type="number" name="quantite_produit" id="quantite_produit" min="1" max="<?php echo $produit['stock_produit']; ?>" value="<?php echo $qte_produit;?>" class="form-control input_quantite p-0">
                            <button type="button" class="btn btn-button-light plus p-0" id="btn_plus<?php echo $produit['id_produit']; ?>"><i class="fa-solid fa-plus" style="color: #fff;"></i></button>
                        </div>
                        <!-- ajout panier -->
                        <button type="button"  class="btn btn-button-light panier col-md-1 col-3" id="<?php echo $produit['id_produit']; ?>" value="<?php echo $produit['id_produit']; ?>"><img src="public/assets/img/icones/trolley.png" alt="" class="img-fluid icones"></button>
                        <!-- ajout favoris seulement si connecté -->
                        <?php  
                            if (isset($_SESSION['id_client'])) {
                                ?>
                                <button type="button"  class="btn btn-button-light add_fav col-md-1 col-3" id="btn_add<?php echo $produit['id_produit']; ?>" value="<?php echo $_SESSION['id_client']; ?>"><img src="public/assets/img/icones/<?php echo $img_coeur; ?>" alt="" class="img-fluid icones"></button>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2 class="my-lg-5 my-3 fs-3 text-center">Vous aimerez aussi </h2>
            <div class="row mb-lg-5 mb-3">
                <?php echo $liste_produits; ?>
            </div>
        </section>
    </div>
</div>

<script src="public/assets/js/calcul_prix_produit_custom.js"></script>
<script src="public/assets/js/card_panier.js"></script>
