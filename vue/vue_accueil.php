<?php
include_once('controler/traitement_accueil.php');
?>
<div class="container ht_page">
    <div class="row">

        <!-- ------------------------------------------------------------------ -->
        <!--                          carousel accueil                          -->
        <!-- ------------------------------------------------------------------ -->
        <section id="carouselAccueil" class="carousel slide position-relative" data-bs-ride="carousel">
            <h1 class="text-center m-lg-5 m-4 position-absolute text-white bg_accueil">Vente de mobiliers, décorations et reproductions historique</h1>
            <ol class="carousel-indicators">
                <?php echo $carousel_indicator_principal;?>
            </ol>
            <div class="carousel-inner" role="listbox">
            <?php echo $carousel_inner_principal;?>
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

        </section>
        <!-- ------------------------------------------------------------------ -->
        <!--                 section du e-commerces                             -->
        <!-- ------------------------------------------------------------------ -->

        <section class=" col-12">
            <h2 class="m-lg-5 my-3 text-center">Collections</h2>
            <div class="d-flex flex-lg-wrap justify-content-lg-center card_cat_grp mx-0 ">
                <?php
                    echo $sections;
                ?>
            </div>
        </section>
        <!-- ------------------------------------------------------------------ -->
        <!--                              Nouveauté                             -->
        <!-- ------------------------------------------------------------------ -->
        <section class="text-center">
            <h2 class="m-lg-5 m-4">A découvrir en ce moment</h2>

            <div id="carouselProduit" class="carousel slide carousel-dark row" data-bs-ride="carousel">
                <a class="carousel-control-prev bg-transparent col-1 position-relative" href="#carouselProduit" role="button" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				</a>

				<div class="carousel-inner col" role="listbox">
                <?php
                    echo $carousel_produit;
                ?>
				</div>
				
				<a class="carousel-control-next bg-transparent col-1 position-relative" href="#carouselProduit" role="button" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
				</a>
			</div>
        </section>

        <!-- ------------------------------------------------------------------ -->
        <!--                              Jumbotron                             -->
        <!-- ------------------------------------------------------------------ -->
        <?php 
        if ($promotion['afficher_promo'] == 1) {
            ?>
        <div class="text-center jumbotron mt-3 mt-lg-5 shadow bg-taupe py-3 px-md-5 px-3">
            <h2 class="mb-3 mx-3">Promotions chez <?php echo $nom_entreprise;?></h2>
            <p class="fs-lg-5 ">
                <?php echo nl2br($promotion['texte_promo']); ?>
            </p>
            <p class="mt-3 fs-4">Réduction de <strong>- <?php echo $promotion['taux_promo']; ?> % </strong>sur tous les produits signalés.</p>
            <a href="index.php?page=202&s=4&f=0&c=0&p=1" class="btn btn-gris-souris rounded-pill ">Découvrez nos offres</a>
            <p class="mt-3">Offres valables du <strong><?php echo date('d-m-Y',$promotion['debut_promo']); ?> </strong> au <strong><?php echo date('d-m-Y',$promotion['fin_promo']); ?></strong>. Conditions générales s'appliquent.</p>
        </div>
            <?php
        }
        ?>
        
        <!-- ------------------------------------------------------------------ -->
        <!--                              ateliers                              -->
        <!-- ------------------------------------------------------------------ -->
        <section class="text-center">
            <h2 class="m-5">Ateliers</h2>
            <div class="row ">
                <div class="col-lg-6">
                    <div id="carouselAteliers" class="carousel slide carousel-dark" data-bs-ride="carousel" >
                        <ol class="carousel-indicators">
                            <?php echo $carousel_indicator; ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php echo $carousel_item; ?>
                        </div>
                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#carouselAteliers"
                            data-bs-slide="prev"
                        >
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#carouselAteliers"
                            data-bs-slide="next"
                        >
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                </div>
                <div class="col-lg-6 mt-3 mt-lg-0">
                    <h3>Nouvelles dates disponibles</h3>
                    <p class="m-lg-5 m-3 fs-lg-5 text-justify text-md-center">
                        <?php echo nl2br($texte_ateliers[0]['texte_pf']);?>
                    </p>
                    <a href="index.php?page=230" class="btn btn-gris-souris rounded-pill mb-lg-3">Découvrir nos ateliers</a>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- ------------------------------------------------------------------ -->
<!--                           Réassurances                             -->
<!--                         seulement sur pc                           -->
<!-- ------------------------------------------------------------------ -->
<section class="container-fluid  my-5 bg-taupe">
    <div class="row ">
        <div class="offset-lg-1 col-lg-10">
            <div class="row flex-wrap justify-content-evenly align-items-center reassurances">

                <div class="offset-1 col-2 d-lg-none">
                    <img src="public/assets/img/icones/credit-cards.png" alt="icone"  title="icone" >
                </div>
                <a href="index.php?page=6#" class="col-6 offset-1 offset-lg-0 col-lg-2 bg-white my-3 rounded-lg-circle rounded-pill d-flex flex-column justify-content-center align-items-center ">
                    <h4 class="text-center p-lg-2 fs-5">Payement sécurisé</h4>
                    <p class="text-center px-lg-2">Réalisez vos achats en toute sécurité</p>
                    <img src="public/assets/img/icones/credit-cards.png" alt="icone"  title="icone" class="d-none d-lg-inline-block">
                </a>
                <div class="offset-1 col-2 d-lg-none">
                    <img src="public/assets/img/icones/service-clients.png" alt="">
                </div>
                <a href="index.php?page=6#" class="col-6 offset-1 offset-lg-1 col-lg-2 bg-white my-3 rounded-lg-circle rounded-pill d-flex flex-column justify-content-center align-items-center ">
                    <h4 class="text-center p-lg-2 fs-5">Satisfait ou remboursé</h4>
                    <p class="text-center px-lg-2">Voir conditions générales de vente</p>
                    <img src="public/assets/img/icones/service-clients.png" alt="icone"  title="icone" class="d-none d-lg-inline-block">
                </a>
                <div class="offset-1 col-2 d-lg-none">
                    <img src="public/assets/img/icones/poignee-de-main.png" alt="icone" title="icone" >
                </div>
                <a href="index.php?page=6#" class="col-6 offset-1 offset-lg-1 col-lg-2 bg-white my-3 rounded-lg-circle rounded-pill d-flex flex-column justify-content-center align-items-center ">
                    <h4 class="text-center p-lg-2 fs-5">Un suivit de la production pas à pas</h4>
                    <p></p>
                    <img src="public/assets/img/icones/poignee-de-main.png" alt="icone"  title="icone" class="d-none d-lg-inline-block">
                </a>
                <div class="offset-1 col-2 d-lg-none">
                    <img src="public/assets/img/icones/camion.png" alt="">
                </div>
                <a href="index.php?page=6#" class="col-6 offset-1 offset-lg-1 col-lg-2 bg-white my-3 rounded-lg-circle rounded-pill d-flex flex-column justify-content-center align-items-center ">
                    <h4 class="text-center p-lg-2 fs-5">Livraisons</h4>
                    <p class="text-center p-lg-2">Des solutions sur mesure adaptées à vos besoins</p>
                    <img src="public/assets/img/icones/camion.png" alt="icone"  title="icone" class="d-none d-lg-inline-block">
                </a>
            </div>
        </div>
    </div>
</section>
<!-- ------------------------------------------------------------------ -->
<!--                         Nous contacter                             -->
<!-- ------------------------------------------------------------------ -->
<section class="container ">
    <div class="row align-items-center m-4 mb-lg-5">
        <h2 class="text-center">Nous contacter</h2>
        <div class="col-lg-4 ">
            <div class="row flex-column align-items-center align-items-lg-start">
                <!-- Modal trigger button -->
                <button
                    type="button"
                    class="btn btn-link w-75"
                    data-bs-toggle="modal"
                    data-bs-target="#modalId"
                >
                    <img src="public/assets/img/site/facade.png" alt="façade de la boutique" class="img-fluid border">
                </button>
                
                <!-- Modal Body -->
                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                <div
                    class="modal fade"
                    id="modalId"
                    tabindex="-1"
                    data-bs-backdrop="static"
                    data-bs-keyboard="false"
                    
                    role="dialog"
                    aria-labelledby="modalTitleId"
                    aria-hidden="true"
                >
                    <div
                        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                        role="document"
                    >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">
                                    Notre boutique
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <img src="public/assets/img/site/facade.png" alt="façade de la boutique" class="img-fluid ">
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- fin modal -->
                <div class="mt-3 col-md-6 col-lg-12">
                    <div class="row">
                        <div class="col-3 col-lg-1">
                            <img src="public/assets/img/icones/localisation.png" alt="icone localisation" title="icone localisation" class="icones"> 
                        </div>
                        <div class="col">
                            <?php echo $adresse_site; ?>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-md-6 col-lg-12">
                    <div class="row">
                        <div class="col-3 col-lg-1">
                            <img src="public/assets/img/icones/telephone_contour.png" alt="icone telephone" title="icone telephone" class="icones"> 
                        </div>
                        <div class="col">
                            <?php echo $tel_site; ?>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-md-6 col-lg-12">
                    <div class="row">
                        <div class="col-3 col-lg-1">
                            <img src="public/assets/img/icones/email.png" alt="icone message" title="icone message" class="icones"> 
                        </div>
                        <div class="col ">
                            <a href="index.php?page=300"><?php echo $mail_site; ?></a>
                        </div>
                    </div>
                </div>
                <div class="mt-3  col-md-6 col-lg-12">
                    <?php echo $facebook; ?>
                    <?php echo $instagram; ?>
                </div>
                <div class="mt-3 col-md-6 col-lg-12 mb-3">
                    <h4>Horaires d'ouverture :</h4>
                    <p>Du Lundi au Vendredi : </p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 py-lg-5 px-0">
            <iframe sandbox="allow-scripts" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d882.685758834235!2d6.928747789925432!3d49.19777541700996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4795b300a2a23f4b%3A0x605dc506b51b03a5!2s58%20Rue%20Saint-Fran%C3%A7ois%2C%2057350%20Stiring-Wendel!5e0!3m2!1sfr!2sfr!4v1702303177248!5m2!1sfr!2sfr" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> 
        </div>
    </div>
</section>

<script src="public/assets/js/card_panier.js"></script>
<script src="public/assets/js/configuration.js"></script>
<script src="public/assets/js/carousel_produit_accueil.js"></script>
