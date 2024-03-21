<?php
include_once('controler/traitement_commande.php');
?>
<section class="container ht_page ">
    <div class="row text-center">
    <h1 class="mb-lg-5 mb-3">Commander</h1>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb justify-content-center">
                <?php echo $breadcrumb; ?>
            </ol>
        </nav>
        
        <h2 class="text-start fs-5">Récapitulatif de la commande</h2>
        <div
            class="table-responsive col-lg-8"
        >
            <table
                class="table  table-hover table-borderless text-start align-middle table_produit"
            >
                <thead class="">
                    <caption>
                    </caption>

                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <td>Client : </td>
                        <td><?php echo $client['prenom_utilisateur'].' '.$client['nom_utilisateur']; ?></td>
                    </tr>
                    <tr>
                        <td>Commande n° :</td>
                        <td><?php echo $id_commande; ?></td>
                    </tr>
                    <tr>
                        <td>Nombre d'articles : </td>
                        <td><?php echo $nbr_produits; ?></td>
                    </tr>
                    <tr>
                        <td>Date : </td>
                        <td><?php echo date('d/m/Y',$jour); ?></td>
                    </tr>

                    <tr>
                        <td>Adresse de livraison :</td>
                        <td>
                            <div class=" pe-3">
                                <select
                                    class="form-select form-select-lg "
                                    name="livraison"
                                    id="livraison"
                                >
                                    <?php echo $adresses_livraison; ?>
                                </select>
                            </div>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Adresse de facturation :</td>
                        <td>
                        <div class=" pe-3">
                                <select
                                    class="form-select form-select-lg"
                                    name="facturation"
                                    id="facturation"
                                >
                                    <?php echo $adresses_facturation; ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
        <aside class="col-lg-3 offset-lg-1 border mb-lg-5 mb-3">
            <h2><?php echo $sous_titre; ?></h2>
            <div class="row my-5 fw-bold ">
                <div class="col-10 offset-1 d-flex justify-content-between">
                    <div class="d-inline">Total HT : </div>
                    <div class="d-inline"><?php echo number_format($total_HT,2,'.',' ');?></div>
                </div>
                <div class="col-10 offset-1 d-flex justify-content-between">
                    <div class="d-inline">TVA (20%): </div>
                    <div class="d-inline"><?php echo number_format($TVA,2,'.',' '); ?></div>
                </div>
                <div class="col-10 offset-1 d-flex justify-content-between">
                    <div class="d-inline">Frais de port : </div>
                    <div class="d-inline"><?php echo $frais; ?></div>
                </div>
                <hr  class="col-10 offset-1">
                <div class="col-10 offset-1 d-flex justify-content-between">
                    <div class="d-inline">Total TTC : </div>
                    <div class="d-inline"><?php echo number_format($total_TTC,2,'.',' '); ?></div>
                </div>
                <div class="text-center">
                    <form action="<?php echo $destination; ?>" method="post">
                        <input type="hidden" name="id_commande" value="<?php echo $id_commande;?>">
                        <input type="hidden" name="id_livraison" value="<?php echo $livraisons[0]['id_adresse'];?>" id="id_livraison">
                        <input type="hidden" name="id_facturation" value="<?php echo $facturations[0]['id_adresse'];?>" id="id_facturation">
                        <input type="hidden" name="jour" value="<?php echo $jour;?>">
                        <input type="hidden" name="token" value="<?php echo $token;?>">
                        <input type="hidden" name="mail_client" value="<?php echo $client['mail_utilisateur'];?>">
                        <input type="hidden" name="prix_payer" value="<?php echo $total_TTC;?>">
                        <input type="submit" value="<?php echo $btn_envoyer; ?>" class="btn btn-gris-souris rounded-pill mt-3" id="payer">
                    </form>
                </div>
            </div>
        </aside>
    </div>
</section>

<script src="public/assets/js/select_adresses.js"></script>