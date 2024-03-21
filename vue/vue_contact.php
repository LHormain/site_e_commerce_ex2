<?php
include_once('controler/traitement_contact.php');
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
            </ol>
        </nav>
        <h1 class="text-center my-3">Contact</h1>
        <p class="offset-1 offset-lg-0 col-10 col-lg-12">Pour une demande de renseignements, de devis ou pour toutes autres questions, n'hésitez pas à me joindre par téléphone, courriel ou en utilisant le formulaire de contact ci-dessous. Tous les champs sont obligatoire</p>
        <section>
            <div class="row mt-3 mt-lg-5">
                <div class="offset-1 col-10 col-lg-6">
                    <p><?php echo $texte_page_courante; ?></p>
                    <form action="index.php?page=301" method="post" class="row mb-3 mb-lg-5">
                        <div class="mb-3 col-lg-6 form-floating ">
                            <input 
                                type="text" 
                                class="form-control" 
                                name="nom_contact" 
                                id="nom_contact" 
                                aria-describedby="helpId1" 
                                value="<?php echo $client['prenom_utilisateur'].' '.$client['nom_utilisateur']; ?>"
                                required
                            />
                            <label for="nom_contact" class="form-label ms-3">Nom et prénom</label>
                            <small id="helpId1" class="form-text text-muted">Votre nom complet</small>
                        </div>
                        <div class="mb-3 col-lg-6 form-floating ">
                            <input
                                type="text"
                                class="form-control"
                                name="tel_contact"
                                id="tel_contact"
                                aria-describedby="helpId2"
                                value="<?php echo $client['tel_utilisateur']; ?>"
                                required
                            />
                            <label for="tel_contact" class="form-label ms-3">Téléphone</label>
                            <small id="helpId2" class="form-text text-muted">Votre numéro de téléphone</small>
                        </div>
                        <div class="mb-3 form-floating ">
                            <input
                                type="mail"
                                class="form-control"
                                name="mail_contact"
                                id="mail_contact"
                                aria-describedby="helpId3"
                                placeholder=""
                                value = "<?php echo $client['mail_utilisateur']; ?>"
                                required
                            />
                            <label for="mail_contact" class="form-label ms-3">E-mail</label>
                            <small id="helpId3" class="form-text text-muted">Votre adresse e-mail</small>
                        </div>
                        <div class="mb-3 form-floating ">
                            <select
                                class="form-select form-select-lg"
                                name="sujet"
                                id="sujet"
                            >
                                <?php echo $select; ?>
                            </select>
                            <label for="sujet" class="form-label ms-3">Objet de votre demande</label>
                        </div>
                        <div class="mb-3 form-floating ">
                            <textarea class="form-control h-100" name="message_contact" id="message_contact" rows="5" required></textarea>
                            <label for="message_contact" class="form-label ms-3">Poser ici votre question et/ou décrivez votre projet</label>
                        </div>
                        <!-- captcha -->
                        <div class="mb-lg-3" >
                            <p for="">Écrivez dans la case ci dessous uniquement les chiffres apparaissant dans le code suivant : <br> <strong id="code"></strong></p>
                        </div>
                        <div class="mb-lg-3 ">
                            <input type="text" name="captcha" id="captcha" class="py-2 form-control w-50" required>
                        </div>
                        <!-- conditions générales -->
                        <div class=" mb-lg-3" >
                            <p >Conditions Générales :</p>
                        </div>
                        <div class="mb-lg-3 d-flex flex-no-wrap align-items-start">
                            <input type="checkbox" name="condition" id="condition" class="mt-1" required> 
                            <label for="condition" class="ms-2 " id="condition_label">J'accepte les <a href="index.php?page=7">conditions générales et la politique de confidentialité</a>  de <strong><?php echo $nom_entreprise; ?></strong>. En cochant cette case, je confirme avoir lu et compris ces documents, et je consens à leur application.</label>
                        </div>
                        <!-- envoyer -->
                        <div class="mb-3 text-end">
                            <input type="submit" value="Envoyez" class="btn btn-gris-souris rounded-pill" disabled>
                        </div>
                    </form>
                </div>
                <div class="text-center text-lg-start offset-lg-1 col-lg-4 mb-3">
                    <h2 class="fs-4">Coordonnées :</h2>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-1 offset-md-3 offset-lg-0">
                                <img src="public/assets/img/icones/localisation.png" alt="icone localisation" title="icone localisation" class="icones"> 
                            </div>
                            <div class="col-lg-11 col-md-4">
                                <?php echo $adresse_site; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-1 offset-md-3 offset-lg-0">
                                <img src="public/assets/img/icones/telephone_contour.png" alt="icone telephone" title="icone telephone" class="icones"> 
                            </div>
                            <div class="col-lg-11 col-md-4">
                                <?php echo $tel_site; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-1 offset-md-3 offset-lg-0">
                                <img src="public/assets/img/icones/email.png" alt="icone message" title="icone message" class="icones"> 
                            </div>
                            <div class="col-lg-11 col-md-4">
                                <a href="index.php?page=300"><?php echo $mail_site; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3">
                        <!-- facebook -->
                        <?php echo $facebook; ?>
                        <?php echo $instagram; ?>
                    </div>
                    <h2 class="fs-4 mt-3">Horaires d'ouverture :</h2>
                    <p class="offset-1 col">Du lundi au vendredi : </p>
                    <div class="text-center">
                        <img
                            src="public/assets/img/logo/qualisarmalogo2.png"
                            class="img-fluid rounded rounded-3 w-50"
                            alt=""
                        />
                    </div>
                    
                </div>
            </div>
        </section>
    </div>
</div>

<script src="public/assets/js/configuration.js"></script>
<script src="public/assets/js/captcha.js"></script>
<script src="public/assets/js/formulaire_contact.js"></script>