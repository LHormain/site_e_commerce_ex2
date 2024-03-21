<?php
include_once('controler/traitement_panier.php');
?>
<div class="container ht_page ">
    <section class="row text-center">
        <h1 class="mb-lg-5 mb-3"><?php echo $titre; ?></h1>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb justify-content-center">
                <?php echo $breadcrumb; ?>
            </ol>
        </nav>
        
        <div
            class="table-responsive col-lg-8"
        >
            <table
                class="table table-striped table-hover table-borderless table-taupe align-middle table_produit"
            >
                <thead class="table-light ">
                    <caption>
                    </caption>
                    <tr class="head_table_panier">
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire HT (€)</th>
                        <th>Sous total TTC (€)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php echo $tableau; ?>
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
        <aside class="col-md-3 offset-md-1 col-11 border mb-lg-5 mb-3 mx-3 mx-md-0">
            <h2><?php echo $sous_titre; ?></h2>
            <h3 class="fs-6"><?php echo $sous_sous_titre;?></h3>
            <div class="row my-5 fw-bold ">
                <div class="col-8 offset-2 d-flex justify-content-between">
                    <div class="d-inline">Total HT : </div>
                    <div class="d-inline"><?php echo number_format($total_HT,2,'.',' ');?></div>
                </div>
                <div class="col-8 offset-2 d-flex justify-content-between">
                    <div class="d-inline">TVA (20%): </div>
                    <div class="d-inline"><?php echo number_format($TVA,2,'.',' '); ?></div>
                </div>
                <hr  class="col-8 offset-2">
                <div class="col-8 offset-2 d-flex justify-content-between">
                    <div class="d-inline">Total TTC : </div>
                    <div class="d-inline"><?php echo number_format($total_TTC,2,'.',' '); ?></div>
                </div>
                <div class="text-center">
                <?php  
                    if (isset($_SESSION['id_client'])) {
                         echo $txt_btn; 
                    }
                    else {
                        ?>
                        <a href="index.php?page=310&btq=<?php echo $c;?>" class="btn btn-gris-souris rounded-pill mt-3" role="button">Se connecter</a>
                        <?php
                    }
                ?>
                </div>
            </div>
        </aside>
        <div class="text-center text-md-start mb-lg-5 mb-3">
            <a
                class="btn btn-gris-souris rounded-pill"
                href="index.php?page=1"
                role="button"
                >Continuer mes achats</a
            >
            
        </div>
    </section>
</div>