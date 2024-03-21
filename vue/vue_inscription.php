<?php
include_once('controler/traitement_inscription.php');
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inscription</li>
            </ol>
        </nav>
        <h1 class="text-center my-3 my-lg-5"><?php echo $titre; ?></h1>
        <section>
            <form action="index.php?page=312<?php echo $lien; ?>" method="post" class="row my-3 my-lg-5">
                <input type="hidden" name="test" id="test" value="<?php  echo $test; ?>">
                <p class="text-center"><?php echo $message; ?></p>
                <!-- ---------------- -->
                <!-- colone de gauche -->
                <!-- ---------------- -->
                <div class="offset-lg-1 col-lg-5">
                    <!-- nom -->
                    <div class="mb-3 form-floating ">
                        <input
                            type="text"
                            class="form-control"
                            name="nom_utilisateur"
                            id="nom_utilisateur"
                            aria-describedby="helpId1"
                            placeholder=""
                            value = "<?php echo $client['nom_utilisateur']; ?>"
                            required
                        />
                        <label for="nom_utilisateur" class="form-label">Nom</label>
                        <small id="helpId1" class="form-text text-muted">Votre nom</small>
                    </div>
                    <!-- mail -->
                    <div class="mb-3 form-floating ">
                        <input
                            type="email"
                            class="form-control"
                            name="mail_utilisateur"
                            id="mail_utilisateur"
                            aria-describedby="helpId2"
                            placeholder=""
                            value = "<?php echo $client['mail_utilisateur']; ?>"
                            required
                        />
                        <label for="mail_utilisateur" class="form-label">Mail</label>
                        <small id="helpId2" class="form-text text-muted">Votre adresse e-mail</small>
                    </div>
                </div>
                <!-- ---------------- -->
                <!-- colone de droite -->
                <!-- ---------------- -->
                <div class="col-lg-5">
                    <!-- prenom -->
                    <div class="mb-3 form-floating ">
                        <input
                            type="text"
                            class="form-control"
                            name="prenom_utilisateur"
                            id="prenom_utilisateur"
                            aria-describedby="helpId3"
                            placeholder=""
                            value = "<?php echo $client['prenom_utilisateur']; ?>"
                            required
                        />
                        <label for="prenom_utilisateur" class="form-label">Prenom</label>
                        <small id="helpId3" class="form-text text-muted">Votre prénom</small>
                    </div>
                    <!-- tel -->
                    <div class="mb-3 form-floating ">
                        <input
                            type="tel"
                            class="form-control"
                            name="tel_utilisateur"
                            id="tel_utilisateur"
                            aria-describedby="helpId4"
                            placeholder=""
                            value = "<?php echo $client['tel_utilisateur']; ?>"
                            required
                        />
                        <label for="tel_utilisateur" class="form-label">Téléphone</label>
                        <small id="helpId4" class="form-text text-muted">Votre numéro de téléphone</small>
                    </div>
                </div>
                <!-- ---------------- -->
                <!-- colone de gauche -->
                <!-- ---------------- -->
                <div class="offset-lg-1 col-lg-5">
                    <!-- facturation -->
                    <fieldset class="row">
                        <legend class="fs-5 my-3 my-lg-4 ">Adresse de facturation : </legend>
                        <div class="visually-hidden">
                            <input type="text" name="id_facturation" id="id_facturation" value="<?php echo $adresse_facturation['id_adresse']; ?>">
                        </div>
                        <!-- numéro -->
                        <div class=" col-2">
                            <div class="mb-3 form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="numero_adresse_f"
                                    id="numero_adresse_f"
                                    aria-describedby="helpId5"
                                    placeholder=""
                                    value = "<?php echo $adresse_facturation['numero_adresse']; ?>"
                                    required
                                />
                                <label for="numero_adresse_f" class="form-label">N°</label>
                                <small id="helpId5" class="form-text text-muted">Votre numéro</small>
                            </div>
                        </div>
                        <!-- rue -->
                        <div class="col-10">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="rue_adresse_f"
                                    id="rue_adresse_f"
                                    aria-describedby="helpId6"
                                    placeholder=""
                                    value = "<?php echo $adresse_facturation['rue_adresse']; ?>"
                                    required
                                />
                                <label for="rue_adresse_f" class="form-label">Rue</label>
                                <small id="helpId6" class="form-text text-muted">Votre rue</small>
                            </div>
                        </div>
                        <!-- complement d'adresse -->
                        <div>
                            <div class="mb-3 form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="complement_adresse_f"
                                    id="complement_adresse_f"
                                    aria-describedby="helpId7"
                                    placeholder=""
                                    value = "<?php echo $adresse_facturation['complement_adresse']; ?>"
                                />
                                <label for="complement_adresse_f" class="form-label">Complément d'adresse</label>
                                <small id="helpId7" class="form-text text-muted">Votre complément d'adresse</small>
                            </div>
                        </div>
                        <!-- code postal -->
                        <div class="col-4">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="code_postal_adresse_f"
                                    id="code_postal_adresse_f"
                                    aria-describedby="helpId8"
                                    placeholder=""
                                    value = "<?php echo $adresse_facturation['code_postal_adresse']; ?>"
                                    required
                                />
                                <label for="code_postal_adresse_f" class="form-label">Code postal</label>
                                <small id="helpId8" class="form-text text-muted">Votre code postal</small>
                            </div>
                        </div>
                        <!-- ville -->
                        <div class="col-8">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="ville_adresse_f"
                                    id="ville_adresse_f"
                                    aria-describedby="helpId9"
                                    placeholder=""
                                    value = "<?php echo $adresse_facturation['ville_adresse']; ?>"
                                    required
                                />
                                <label for="ville_adresse_f" class="form-label">Ville</label>
                                <small id="helpId9" class="form-text text-muted">Votre ville</small>
                            </div>
                        </div>
                        <!-- pays  -->
                        <div>
                            <div class="mb-3 form-floating ">
                                <select
                                    type="text"
                                    class="form-control"
                                    name="id_pays_f"
                                    id="id_pays_f"
                                    aria-describedby="helpId10"
                                    placeholder=""
                                    required
                                >
                                    <?php echo $liste_option_facturation; ?>
                                </select>
                                <label for="id_pays_f" class="form-label">Pays</label>
                                <small id="helpId10" class="form-text text-muted">Votre pays</small>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <!-- ---------------- -->
                <!-- colone de droite -->
                <!-- ---------------- -->
                <div class="col-lg-5">
                    <!-- livraison  -->
                    <fieldset class="row">
                        <legend class="fs-5 my-3 my-lg-4">Adresse de livraison (si différente) :</legend>
                        <div class="visually-hidden">
                            <input type="text" name="id_livraison" id="id_livraison" value="<?php echo $adresse_livraison['id_adresse']; ?>">
                        </div>
                        <!-- numéro -->
                        <div class=" col-2">
                            <div class="mb-3 form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="numero_adresse_l"
                                    id="numero_adresse_l"
                                    aria-describedby="helpId5"
                                    placeholder=""
                                    value = "<?php echo $adresse_livraison['numero_adresse']; ?>"
                                    
                                />
                                <label for="numero_adresse_l" class="form-label">N°</label>
                                <small id="helpId5" class="form-text text-muted">Votre numéro</small>
                            </div>
                        </div>
                        <!-- rue -->
                        <div class="col-10">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="rue_adresse_l"
                                    id="rue_adresse_l"
                                    aria-describedby="helpId6"
                                    placeholder=""
                                    value = "<?php echo $adresse_livraison['rue_adresse']; ?>"
                                    
                                />
                                <label for="rue_adresse_l" class="form-label">Rue</label>
                                <small id="helpId6" class="form-text text-muted">Votre rue</small>
                            </div>
                        </div>
                        <!-- complement d'adresse -->
                        <div>
                            <div class="mb-3 form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="complement_adresse_l"
                                    id="complement_adresse_l"
                                    aria-describedby="helpId7"
                                    value = "<?php echo $adresse_livraison['complement_adresse']; ?>"
                                    placeholder=""
                                />
                                <label for="complement_adresse_l" class="form-label">Complément d'adresse</label>
                                <small id="helpId7" class="form-text text-muted">Votre complément d'adresse</small>
                            </div>
                        </div>
                        <!-- code postal -->
                        <div class="col-4">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="code_postal_adresse_l"
                                    id="code_postal_adresse_l"
                                    aria-describedby="helpId8"
                                    placeholder=""
                                    value = "<?php echo $adresse_livraison['code_postal_adresse']; ?>"
                                    
                                />
                                <label for="code_postal_adresse_l" class="form-label">Code postal</label>
                                <small id="helpId8" class="form-text text-muted">Votre code postal</small>
                            </div>
                        </div>
                        <!-- ville -->
                        <div class="col-8">
                            <div class="mb-3 form-floating ">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="ville_adresse_l"
                                    id="ville_adresse_l"
                                    aria-describedby="helpId9"
                                    placeholder=""
                                    value = "<?php echo $adresse_livraison['ville_adresse']; ?>"
                                    
                                />
                                <label for="ville_adresse_l" class="form-label">Ville</label>
                                <small id="helpId9" class="form-text text-muted">Votre ville</small>
                            </div>
                        </div>
                        <!-- pays  -->
                        <div>
                            <div class="mb-3 form-floating ">
                                <select
                                    type="text"
                                    class="form-control"
                                    name="id_pays_l"
                                    id="id_pays_l"
                                    aria-describedby="helpId10"
                                    placeholder=""
                                >
                                    <?php echo $liste_option_livraison; ?>
                                </select>
                                <label for="id_pays_l" class="form-label">Pays</label>
                                <small id="helpId10" class="form-text text-muted">Votre pays</small>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <!-- ---------------- -->
                <!-- colone de gauche -->
                <!-- ---------------- -->
                <div class="offset-lg-1 col-lg-5">
                    <!-- mot de passe -->
                    <div class="mt-3 mt-lg-5">
                        <div class="mb-3 form-floating ">
                            <input
                                type="password"
                                class="form-control"
                                name="mdp_utilisateur"
                                id="mdp_utilisateur"
                                aria-describedby="helpId11"
                                placeholder=""
                                required
                            />
                            <label for="mdp_utilisateur" class="form-label">Mot de passe</label>
                            <small id="helpId11" class="form-text text-muted">Votre mot de passe</small>
                        </div>
                    </div>
                </div>
                <!-- ---------------- -->
                <!-- colone de droite -->
                <!-- ---------------- -->
                <div class="col-lg-5">
                    <!-- confirmation mot de passe -->
                    <div class="mt-3 mt-lg-5 <?php if (isset($_GET['id'])) { echo 'visually-hidden'; }?>">
                        <div class="mb-3 form-floating ">
                            <input
                                type="password"
                                class="form-control"
                                name="mdp_check"
                                id="mdp_check"
                                aria-describedby="helpId11"
                                placeholder=""
                                <?php if (!isset($_GET['id'])) {echo 'required';} else {echo 'value="0"';} ?>
                            />
                            <label for="mdp_check" class="form-label">Confirmation du mot de passe</label>
                            <small id="helpId11" class="form-text text-muted">Confirmer votre mot de passe</small>
                        </div>
                    </div>
                </div>
                <!-- ---------------- -->
                <!--    pleine page   -->
                <!-- ---------------- -->
                <div class="offset-1 col-10">
                    <!-- captcha -->
                    <div class="mb-lg-3" >
                        <p for="">Écrivez dans la case ci dessous uniquement les chiffres apparaissant dans le code suivant : <br> <strong id="code"></strong></p>
                    </div>
                    <div class="mb-lg-3 ">
                        <input type="text" name="captcha" id="captcha" class="py-2 form-control w-25" required>
                    </div>
                    <!-- conditions générales -->
                    <div class=" mb-lg-3" >
                        <p >Conditions Générales :</p>
                    </div>
                    <div class="mb-lg-3 d-flex flex-no-wrap align-items-start">
                        <input type="checkbox" name="condition" id="condition" class="mt-1 form-check-input" required> 
                        <label for="condition" class="ms-2 " id="condition_label">J'accepte les <a href="index.php?page=7">conditions générales et la politique de confidentialité</a>  de <strong><?php echo $nom_entreprise; ?></strong>. En cochant cette case, je confirme avoir lu et compris ces documents, et je consens à leur application.</label>
                    </div>
                    <!-- inscription newsletter -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="newsletter" name="newsletter" <?php if ($client['newsletter'] == 1) {echo 'checked';}?>/>
                        <label class="form-check-label" for="newsletter"> En cochant cette case, vous consentez à recevoir des communications marketing de la part de <strong><?php echo $nom_entreprise; ?></strong>, notamment des informations sur nos produits, offres spéciales et actualités. </label>
                    </div>
                    
                    <!-- envoyer -->
                    <div class="mb-3 text-center">
                        <input type="submit" value="<?php echo $btn_envoyer; ?>" class="btn btn-gris-souris rounded-pill" disabled>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<script src="public/assets/js/captcha.js"></script>
<script src="public/assets/js/formulaire_inscription.js"></script>