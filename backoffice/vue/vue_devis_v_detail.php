<?php
include_once('controler/traitement_devis_v_detail.php');
?>
<div class="col-10 p-5 ">
    <h2 class="mb-5 text-center">Devis livraison n° <?php echo $devis['id_livraison']; ?> correspondant à la commande n° <?php echo $id_commande; ?> </h2>
    <p><?php echo $texte_page_courante; ?></p>
    <div class="row">
        <div class="col-2 mb-3 fw-bold">
            Etat : 
        </div>
        <div class="col-10">
            <?php echo $devis['nom_etat']; ?>
        </div>

        <div class="col-2 mb-3 fw-bold">
            Nombre de produits : 
        </div>
        <div class="col-10">
            <?php echo $nbr_produits;?>
        </div>
        <div class="col-2 mb-3 fw-bold">
            Poids total de la commande : 
        </div>
        <div class="col-10">
            <?php echo $poids_livraison/1000;?> kg
        </div>
        <div class="col-2 mb-3 fw-bold">
            Volume total des produits : 
        </div>
        <div class="col-10">
            <?php echo $dimension_totale/1000000;?> m<sup>3</sup>
        </div>
        <div class="col-2 mb-3 fw-bold">
            Montant des achats : 
        </div>
        <div class="col-10">
            <?php echo $facture['montant_commande']; ?> €
        </div>
        <div>
            <form action="#" method="post" class="row" enctype="multipart/form-data">
                <div class="col-2 mb-3 fw-bold">
                    Montant de la livraison : 
                </div>
                <div class="mb-3 col-10">
                    <input
                        type="text"
                        class="form-control w-50"
                        name="prix_livraison"
                        id="prix_livraison"
                        aria-describedby="helpId"
                        placeholder=""
                        value = "<?php echo $prix_livraisons; ?>"
                    />
                    <small id="helpId" class="form-text text-muted">Montant de la livraison en euro défini par l'entreprise</small>
                </div>
                <div class="col-2 mb-3 fw-bold">
                    Montant total à payer : 
                </div>
                <div class="mb-3 col-10">
                    <?php echo ($prix_livraisons + $facture['montant_commande']); ?> €
                </div>
                <?php
                    if ($devis['fichier_devis_livraison'] != NULL) {
                        ?>
                    <div class="col-2 mb-3 fw-bold">
                        Devis joint pour le client :
                    </div>
                    <!--  bouton bootstrap modal qui affiche le fichier -->
                    <div  class="mb-3 col-10">
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#devisModal">
                            Voir le devis
                        </button>
                        <div class="modal fade" id="devisModal" tabindex="-1" aria-labelledby="devisModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="devisModalLabel">Devis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <embed src="http://localhost/projet/qualis_arma/mvc/public/assets/devis/<?php echo $devis['fichier_devis_livraison']; ?>" type="application/pdf" width="1100" height="600">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                ?>
                <div class="col-2 mb-3 fw-bold">
                    Ajouter un fichier devis : 
                </div>
                <div class="mb-3 col-10">
                        <input type="file" class="form-control w-50" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                        <div id="fileHelpId" class="form-text">Fichier pdf. Max 256Mo.</div>
                    </div>
                <div class="text-center">
                    <input type="submit" value="Enregistrer les modifications" class="btn btn-camel rounded-pill text-light">
                </div>
            </form>
        </div>
    </div>
</div>