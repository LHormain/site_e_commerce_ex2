<?php
include_once('controler/traitement_promo.php');
?>
<div class="col-8 offset-1 mt-5">
    <h2 class="text-center">Gestion des promotions</h2>

    <div class="row">
        <div class="col-6 mt-5">
            <h3 class="mb-3">
                Informations sur la promotion
            </h3>
            <p class="text-center">
                <?php echo $texte_page_courante; ?>
            </p>
            <form action="#" method="post">
                <!-- date du début -->
                <div class="mb-3">
                    <label for="debut_promo" class="form-label">Date de début</label>
                    <input
                        type="date"
                        class="form-control"
                        name="debut_promo"
                        id="debut_promo"
                        aria-describedby="helpId1"
                        placeholder=""
                        value="<?php echo date('Y-m-d',$promotion['debut_promo']);?>" 
                    />
                    <small id="helpId1" class="form-text text-muted">Date à partir de laquelle la promo sera appliquée</small>
                </div>
                <!-- date de fin  -->
                <div class="mb-3">
                    <label for="fin_promo" class="form-label">Date de fin </label>
                    <input
                        type="date"
                        class="form-control"
                        name="fin_promo"
                        id="fin_promo"
                        aria-describedby="helpId2"
                        placeholder=""
                        value="<?php echo date('Y-m-d',$promotion['fin_promo']);?>" 
                    />
                    <small id="helpId2" class="form-text text-muted">Date de fin de la promotion</small>
                </div>
                <!-- taux  -->
                <div class="mb-3">
                    <label for="taux_promo" class="form-label">Taux de réduction</label>
                    <input
                        type="text"
                        class="form-control"
                        name="taux_promo"
                        id="taux_promo"
                        aria-describedby="helpId3"
                        placeholder=""
                        value="<?php echo $promotion['taux_promo'];?>"
                    />
                    <small id="helpId3" class="form-text text-muted">Taux de réduction à appliquée sur les produits bénéficiant d'une promotion</small>
                </div>
                <!-- texte d'annonce en page d'accueil et dans le catalogue -->
                <div class="mb-3">
                    <label for="texte_promo" class="form-label">Texte promotionnel </label>
                    <textarea class="form-control" name="texte_promo" id="texte_promo" rows="8"><?php echo $promotion['texte_promo'];?></textarea>
                </div>
                <!-- affichage en page d'accueil -->
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="afficher_promo" 
                        id="oui" 
                        value="1"
                        <?php if ($promotion['afficher_promo'] == 1) {echo 'checked';} ?>
                    />
                    <label class="form-check-label" for="oui"> Afficher en page d'accueil </label>
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="afficher_promo"
                        id="non"
                        value="0"
                        <?php if ($promotion['afficher_promo'] == 0) {echo 'checked';} ?>
                    />
                    <label class="form-check-label" for="non">
                        Ne pas afficher en page d'accueil
                    </label>
                </div>
                
                <!-- envoyer -->
                <div class="text-end">
                    <input type="submit" value="enregistrer les modifications" class="btn btn-camel text-light  rounded-pill">
                </div>
            </form>
        </div>
        <div class="col-6 mt-5">
            <h3 class="mb-3">Catégories concernée par la promotion</h3>
            <p>
                Note : Chaque produit peut être ajouter ou retirer individuellement de la promotion sur la page gestion produit et lors de l'enregistrement du produit
            </p>
            <!-- catégories concernées  -->
            <div class="d-flex justify-content-end">
                <?php table_legend();?>
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
                            <th>Nom section</th>
                            <th>Nom catégorie</th>
                            <th>Promo</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php echo $table; ?>
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>
            </div>
            

        </div>
    </div>
    
</div>

<script src="public/assets/js/gestion_cat_promo.js"></script>