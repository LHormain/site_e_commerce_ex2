<?php
include_once('controler/traitement_devis_location.php');
?>
<div class="container ht_page ">
    <section class="row text-center">
        <h1 class="mb-lg-5 mb-3">Demande de devis</h1>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item ">Ma liste de souhait</li>
                <li class="breadcrumb-item <?php if ($test_devis == 0 || $modifier == 1) {echo 'active fw-bold" aria-current="page';} ?>">Demander un devis</li>
                <li class="breadcrumb-item <?php if (!($test_devis == 0 || $modifier == 1)) {echo 'active fw-bold" aria-current="page';} ?>" >Demande envoyée</li>
            </ol>
        </nav>
        <p>
            Nous sommes ravis de votre enthousiasme pour notre service de location de matériel pour événements spéciaux. Pour mieux vous servir, veuillez noter que nous limitons actuellement les demandes de devis de location à la région où notre ébéniste travaille.
            <br>
            Cette mesure vise à garantir une expérience de service optimale et à répondre de manière efficace à vos besoins dans notre zone d'opération. Nous apprécions votre compréhension et restons à votre disposition pour tout renseignement supplémentaire. Merci de votre intérêt et de votre confiance.
        </p>
        
        <?php 
            if ($test_devis == 0 || $modifier == 1) {
                ?>
                <p>
                    Tous les champs sont obligatoires
                </p>
                <form action="index.php?page=213<?php echo $lien; ?>" method="post" class="text-start offset-lg-1 col-lg-10">
                    <fieldset class="row">
                        <legend>Rappelle de vos informations</legend>
                        <!-- nom  -->
                        <div class="mb-3 col-lg-6 ">
                            <label for="nom_utilisateur" class="form-label">Nom</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nom_utilisateur"
                                id="nom_utilisateur"
                                aria-describedby="helpId1"
                                placeholder=""
                                value = "<?php echo $client['nom_utilisateur']; ?>"
                                disabled
                            />
                            <small id="helpId1" class="form-text text-muted">Votre nom</small>
                        </div>
                        
                        <!-- prénom -->
                        <div class="mb-3 col-lg-6 ">
                            <label for="prenom_utilisateur" class="form-label">Prenom</label>
                            <input
                                type="text"
                                class="form-control"
                                name="prenom_utilisateur"
                                id="prenom_utilisateur"
                                aria-describedby="helpId3"
                                placeholder=""
                                value = "<?php echo $client['prenom_utilisateur']; ?>"
                                disabled
                            />
                            <small id="helpId3" class="form-text text-muted">Votre prénom</small>
                        </div>
                        
                        <!-- mail -->
                        <div class="mb-3 col-lg-6 ">
                            <label for="mail_utilisateur" class="form-label">Mail</label>
                            <input
                                type="email"
                                class="form-control"
                                name="mail_utilisateur"
                                id="mail_utilisateur"
                                aria-describedby="helpId2"
                                placeholder=""
                                value = "<?php echo $client['mail_utilisateur']; ?>"
                                disabled
                            />
                            <small id="helpId2" class="form-text text-muted">Votre adresse e-mail</small>
                        </div>
                        
                        <!-- téléphone -->
                        <div class="mb-3 col-lg-6 ">
                            <label for="tel_utilisateur" class="form-label">Téléphone</label>
                            <input
                                type="tel"
                                class="form-control"
                                name="tel_utilisateur"
                                id="tel_utilisateur"
                                aria-describedby="helpId4"
                                placeholder=""
                                value = "<?php echo $client['tel_utilisateur']; ?>"
                                disabled
                            />
                            <small id="helpId4" class="form-text text-muted">Votre numéro de téléphone</small>
                        </div>
                    </fieldset>
                    <fieldset class="row">
                        <legend>Information sur l'événement</legend>
                        <!-- date de l'événement  -->
                        <div class="mb-3 col-lg-6">
                            <label for="date_evenement_devis" class="form-label">Date de l'événement</label>
                            <input
                                type="date"
                                class="form-control"
                                name="date_evenement_devis"
                                id="date_evenement_devis"
                                aria-describedby="helpId5"
                                placeholder=""
                                required
                                value="<?php echo $date_evenement; ?>"
                            />
                            <small id="helpId5" class="form-text text-muted">Date de votre événement</small>
                        </div>
                        <!-- nombre de convives -->
                        <div class="mb-3 col-lg-6">
                            <label for="nbr_invite" class="form-label">Nombre de convives</label>
                            <input
                                type="number"
                                class="form-control"
                                name="nbr_invite"
                                id="nbr_invite"
                                aria-describedby="helpId6"
                                placeholder=""
                                min=0
                                required
                                value="<?php echo $nbr_invite;?>"
                            />
                            <small id="helpId6" class="form-text text-muted">Nombre de personne participant à l'événement</small>
                        </div>
                        <!-- type d'événement -->
                        <div class="mb-3 col-lg-6">
                            <label for="type_evenement" class="form-label">Type d'événement</label>
                            <select
                                class="form-select form-select-lg"
                                name="type_evenement"
                                id="type_evenement"
                                required
                            >
                                <option value="-" selected>choisir une option</option>
                                <option value="mariage" <?php if ($type_evenement == 'mariage') { echo 'selected';}?>>Mariage</option>
                                <option value="aniversaire" <?php if ($type_evenement == 'aniversaire') { echo 'selected';}?>>Anniversaire</option>
                                <option value="culturel" <?php if ($type_evenement == 'culturel') { echo 'selected';}?>>Communion/baptême/...</option>
                                <option value="entreprise" <?php if ($type_evenement == 'entreprise') { echo 'selected';}?>>Réception d'entreprise</option>
                                <option value="autre" <?php if ($type_evenement == 'autre') { echo 'selected';}?>>Autre</option>
                            </select>
                        </div>
                        <!-- adresse de l'événement -->
                        <div class="mb-3 ">
                            <label for="adresse_evenement" class="form-label">Adresse de l'événement</label>
                            <input
                                type="text"
                                class="form-control"
                                name="adresse_evenement"
                                id="adresse_evenement"
                                aria-describedby="helpId7"
                                placeholder=""
                                required
                                value="<?php echo $adresse_evenement; ?>"
                            />
                            <small id="helpId7" class="form-text text-muted">Adresse où se déroulera l'événement</small>
                        </div>
                        
                    </fieldset>
                    <fieldset>
                        <legend>Matériels souhaités</legend>
                        <div>
                            <div
                                class="table-responsive"
                            >
                                <table
                                    class="table table-borderless "
                                >
                                    <thead class="">
                                        <caption>
                                        </caption>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php echo $liste_produit;?>
                                    </tbody>
                                    <tfoot>
                                        
                                    </tfoot>
                                </table>
                            </div>
                            <input type="hidden" name="panier_location" value="<?php echo $id_commande; ?>">
                        </div>
                        <!-- message/demande de piece sur mesure -->
                        <div class="mb-3">
                            <label for="message_devis" class="form-label">Informations complémentaire et demande de pièces uniques</label>
                            <textarea class="form-control" name="message_devis" id="message_devis" rows="10"><?php echo $message_devis;?></textarea>
                        </div>
                    </fieldset>
                    <!-- id utilisateur -->
                    <?php
                        if (isset($_SESSION['id_client'])) {
                            echo '<input type="hidden" value="'.$client['id_user'].'" name="id_user">';
                        }
                        
                    ?>
                    <!-- captcha -->
                    <div class="mb-lg-3" >
                        <p for="">Écrivez dans la case de droite uniquement les chiffres apparaissant dans le code suivant : <br> <strong id="code"></strong></p>
                    </div>
                    <div class="mb-lg-3 ">
                        <input type="text" name="captcha" id="captcha" class="py-2 form-control w-25" required>
                    </div>
                    <!-- conditions générales -->
                    <div class=" mb-lg-3" >
                        <p >Conditions Générales :</p>
                    </div>
                    <div class="mb-3 d-flex flex-no-wrap align-items-start">
                        <input type="checkbox" name="condition" id="condition" class="mt-1" required> 
                        <label for="condition" class="ms-2 " id="condition_label">J'accepte les <a href="index.php?page=7">conditions générales et la politique de confidentialité</a>  de <strong><?php echo $nom_entreprise; ?></strong>. En cochant cette case, je confirme avoir lu et compris ces documents, et je consens à leur application.</label>
                    </div>
                    <!-- envoyer -->
                    <div class="text-md-end text-center">
                        <input type="submit" value="Envoyer votre demande de devis" class="btn btn-gris-souris rounded-pill mb-lg-5 mb-3" disabled>
                    </div>
                </form>
                <?php
            }
            else {
                ?>
                <p class="my-5 py-5"><?php echo $texte_page_courante; ?></p>
                <?php
            }
        ?>
    </section>
</div>

<script src="public/assets/js/captcha.js"></script>
<script src="public/assets/js/formulaire_devis_location.js"></script>