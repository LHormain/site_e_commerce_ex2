<?php
?>
<div class="container ht_page ">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mentions légales et conditions Générales de vente
        </nav>
        <section id="legal">
            <h1><?php  echo $nom_entreprise; ?></h1>    
            <h2>Mentions légales</h2>
            <h3>Micro-entreprise</h3>
            <div class="row">
                <p class="col-2"><strong>Siège social :</strong></p><p class="col-9"> <?php echo $adresse_site; ?></p>
                <p class="col-2"><strong>Tel : </strong></p><p class="col-9"><?php echo $tel_site; ?></p>
                <p class="col-2"><strong>Mail : </strong></p><p class="col-9"><?php echo $mail_site; ?></p>
                <p class="col-12">RCS SARREGUEMINES TI 823 570 577 – N° de Gestion 2016 A 336</p>
                <p class="col-2"><strong>N° SIREN : </strong></p><p class="col-9"> 823570577</p>
                <p class="col-2"><strong>Responsable de la publication : </strong></p><p class="col-9">Julien Hormain</p>
                <p class="col-2"><strong>Hébergeur : </strong></p><p class="col-9">1&1 Internet AG Brauerstr. 48 76135 Karlsruhe Allemagne</p>
                <p class="col-2"><strong>Réalisation du site : </strong></p><p class="col-9">Laureline Hormain</p>
            </div>

    
            <p>Conditions générales de vente des produits proposés sur  <?php echo $site; ?> . Toute commande implique l’acceptation sans aucune réserve des présentes conditions générales de vente.</p>
            <h3>Crédits photographiques</h3>
            <?php echo $nom_entreprise;?> et ses fournisseurs.
            <h3 class="fs-6 my-3">Autre crédit</h3>
            <a href="https://sql.sh/514-liste-pays-csv-xml">sql.sh</a>
            <a href="https://www.flaticon.com/fr/icones-gratuites/facebook" title="facebook icônes">Facebook icônes créées par Freepik - Flaticon</a>
            <a href="https://www.flaticon.com/fr/icones-gratuites/logo-instagram" title="logo-instagram icônes">Logo-instagram icônes créées par Pixel perfect - Flaticon</a>
            <br>
            <br>
            <p>Date de dernière mise à jour le 04/ 04/ 2024</p>
        </section>
        <hr>
        <section id="cgv">
            <h2>Conditions générales de vente</h2>
            <h3>Article 1 – Objet</h3>
            <p>

                Les présentes conditions régissent les ventes par la société <?php  echo $nom_entreprise; ?>, <?php echo $adresse_site; ?>, de produits sur le thème de la reconstitution historique.
            </p>
    
            <h3>Article 2 – Produits</h3>
            <p>

                Les produits présentés sur le site <?php echo $site; ?> sont issus de l’artisanat, dont chaque pièce est unique. Les photos ne sont pas contractuelles et ne peuvent être exactement identiques au produit proposé, notamment pour les produits réalisés sur mesure, naturels comme la corne de bœuf, ou les objets en bois, dont l’essence de bois utilisée ne présente jamais les mêmes motifs / nuance de couleur d’une planche à l’autre.
            </p>
    
            
    
            <h3>Article 3 – Tarifs</h3>
            <p>

                Les prix de nos produits sont indiqués en euros toutes taxes comprises (TVA et autres taxes applicables au jour de la commande), sauf indication contraire et hors frais de traitement et d’expédition.
            </p>
            <p>

                En cas de commande vers un pays autre que la France métropolitaine, vous êtes l’importateur du ou des produits concernés. Des droits de douane ou autres taxes locales, droits d’importation ou taxes d’état sont susceptibles d’être exigibles. Ces droits et sommes seront à votre charge et relèvent de votre entière responsabilité, tant en termes de déclarations que de paiements aux autorités et organismes compétents de votre pays. Nous vous conseillons de vous renseigner sur ces aspects auprès de vos autorités locales.
            </p>
            <p>

                Toutes les commandes, quelle que soit leur origine sont payables en euros.
            </p>
            <p>

                La société <?php echo $nom_entreprise; ?> se réserve le droit de modifier ses prix à tout moment, mais le produit sera facturé sur la base du tarif en vigueur au moment de la validation de la commande et sous réserve de disponibilité.
            </p>
            <p>

                Les produits demeurent la propriété de la société <?php echo $nom_entreprise; ?> jusqu’au paiement complet du prix.
            </p>
            <p>

                <strong>Attention</strong> : dès que vous prenez possession physiquement des produits commandés, les risques de perte ou d’endommagement des produits vous sont transférés.
            </p>
    
            
    
            <h3>Article 4 – Commandes</h3>
            <p>

                Vous pouvez passer commande :
            </p>
            <ul>
                <li>
                    Sur Internet : <?php echo $site; ?>
                </li>
                <li>Par mail : <?php echo $mail_site; ?></li>
                <li>Sur stand lors de manifestations historiques ou marchés</li>
            </ul>
    
            <p>

                Les informations contractuelles sont présentées en langue française et feront l’objet d’une confirmation au plus tard au moment de la validation de votre commande.
            </p>
            <p>

                La société <?php echo $nom_entreprise; ?> se réserve le droit de ne pas enregistrer un paiement, et de ne pas confirmer une commande pour quelque raison que ce soit, et plus particulièrement en cas de problème d’approvisionnement, ou en cas de difficulté concernant la commande reçue.
            </p>
            <p>

                Nous contacter avant toute commande de pièce hors stock, afin de connaître les modalités de fabrication, délai de livraison et tarifs.
            </p>
    
            
            <h3> Article 5 – Validation de votre commande</h3>
           <p>

               Toute commande figurant sur le site Internet <?php echo $nom_entreprise; ?> suppose l’adhésion aux présentes Conditions Générales. Toute confirmation de commande entraîne votre adhésion pleine et entière aux présentes conditions générales de vente, sans exception ni réserve.
           </p>
            <p>

                L’ensemble des données fournies et la confirmation enregistrée vaudront preuve de la transaction.
            </p>
            <p>

                Vous déclarez en avoir parfaite connaissance.
            </p>
            <p>

                La confirmation de commande vaudra signature et acceptation des opérations effectuées.
            </p>
            <p>

                Un récapitulatif des informations de votre commande et des présentes Conditions Générales, vous sera communiqué via l’adresse e-mail de confirmation de votre commande.
            </p>
    
            
            <h3>Article 6 – Paiement</h3>
            <p>

                Le fait de valider votre commande implique pour vous l’obligation de payer le prix indiqué.
            </p>
            <p>

                Le règlement de vos achats peut s’effectuer par Chèque , virement bancaire ou par Paypal.
            </p>
            <p>

                Les frais supplémentaires liés au paiement via paypal seront à votre charge.
            </p>
            <p>

                Le compte de l’acheteur ne sera débité qu’avant l’expédition de la commande.
            </p>
            <p>

                Que les produits soient en stock ou développés sur mesure, le montant total de la commande vous sera demandé lors de la validation de celle-ci.
            </p>
    
            
            <h3>Article 7 – Rétractation</h3>
            <p>

                Conformément aux dispositions de l’article L.121-21 du Code de la Consommation, vous disposez d’un délai de rétractation de 14 jours à compter de la réception de vos produits pour exercer votre droit de rétraction sans avoir à justifier de motifs ni à payer de pénalité.
            </p>
            <p>

                Les retours sont à effectuer dans leur état d’origine et complets (emballage, accessoires, notice). Dans ce cadre, votre responsabilité est engagée. Veillez à bien protéger le produit, car tout dommage subi par le produit à cette occasion peut être de nature à faire échec au droit de rétractation.  Les frais de retour sont à votre charge.
            </p>
            <p>

                En cas d’exercice du droit de rétractation, la société <?php echo $nom_entreprise; ?> procédera au remboursement des sommes versées, dans un délai de 14 jours suivant la notification de votre demande et via le même moyen de paiement que celui utilisé lors de la commande.
            </p>
    
            
            <strong>EXCEPTIONS AU DROIT DE RETRACTATION  </strong>
            
            <p>

                Conformément aux dispositions de l’article L.121-21-8 du Code de la Consommation, le droit de rétractation ne s’applique pas à :
            </p>
            <ul>
                <li>

                     La fourniture de services pleinement exécutés avant la fin du délai de rétractation et dont l’exécution a commencé après accord préalable exprès du consommateur et renoncement exprès à son droit de rétractation.
                </li>
                <li>

                    La fourniture de biens n’étant pas en stock et fabriqués spécialement pour le consommateur, ou confectionnés selon les spécifications du consommateur ou nettement personnalisés.
                </li>
                <li>

                    La fourniture de biens susceptibles de se détériorer ou de se périmer rapidement.
                </li>
                <li>

                    La fourniture de biens qui, après avoir été livrés et de par leur nature, sont mélangés de manière indissociable avec d’autres articles ;
                </li>
                <li>

                    La fourniture de boissons alcoolisées dont la livraison est différée au-delà de trente jours et dont la valeur convenue à la conclusion du contrat dépend de fluctuations sur le marché échappant au contrôle du professionnel.
                </li>
            </ul>
    
            <h3> Article 8 – Disponibilité</h3>
            <p>

                Nos produits sont proposés tant qu’ils sont visibles sur le site <?php echo $site; ?> et dans la limite des stocks disponibles. Pour les produits non stockés, nos offres sont valables sous réserve de disponibilité chez nos fournisseurs.
            </p>
            <p>

                En cas d’indisponibilité de produit après passation de votre commande, nous vous en informerons par mail. Une solution annexe vous sera proposée, ou, le cas échéant, votre commande sera annulée et aucun débit bancaire ne sera effectué.
            </p>
    
            
            <h3>Article 9 – Livraison</h3>
            <p>

                Les produits seront livrés à l’adresse de livraison indiquée lors de l’enregistrement de commande, ou peuvent être retirés en mains propres à mon atelier, ou à mon stand lors de manifestations historiques. Les délais de livraison ne sont donnés qu’à titre indicatif ; Seuls les articles en stock peuvent bénéficier de la possibilité d’annuler la commande si le délai de livraison dépasse 30 jours à compter de la commande. Si entre temps vous recevez le produit nous procéderons à son remboursement et aux frais d’acheminement.
            </p>
            <p>

                En cas de livraisons par un transporteur, la société <?php echo $nom_entreprise; ?> ne peut être tenue pour responsable de retard de livraison dû au transporteur, ou à une indisponibilité du client après plusieurs propositions de rendez-vous. En cas de dommage pendant le transport, la protestation motivée doit être formulée auprès du transporteur dans un délai de 3 jours à compter de la réception de commande. La société <?php echo $nom_entreprise; ?> ne peut être tenue responsable de dommages survenus pendant le transport.
            </p>
    
            
            <h3>Article 10 – Garantie</h3>
            <p>

                Tous nos produits bénéficient de la garantie légale de conformité et de la garantie des vices cachés, prévues par les articles 1641 et suivants du Code civil. En cas de non-conformité d’un produit vendu, il pourra être retourné, modifié, échangé ou remboursé.
            </p>
            <p>

                Toutes les réclamations, demandes d’échange ou de remboursement doivent s’effectuer par mail ou voix postale, dans un délai de 30 jours à compter de la date de livraison.
            </p>
            <p>

                Les produits doivent nous être retournés dans l’état dans lequel vous les avez reçus avec l’ensemble des éléments (accessoires, emballage,..). Les frais d’envoi vous seront remboursés sur la base du tarif facturé et les frais de retour vous seront remboursés sur présentation des justificatifs.
            </p>
            <p>

                Les dispositions de cet Article ne vous empêchent pas de bénéficier du droit de rétractation prévu à l’article 7.
            </p>
    
            
            <h3>Article 11 – Responsabilité</h3>
            <p>

                Les produits proposés sont conformes à la législation française en vigueur. La responsabilité de la société <?php echo $nom_entreprise; ?> ne saurait être engagée en cas de non-respect de la législation du pays où le produit est livré. Il vous appartient de vérifier auprès des autorités locales les possibilités d’importation ou d’utilisation des produits ou services que vous envisagez de commander.
            </p>
            <p>

                Par ailleurs, la société <?php echo $nom_entreprise; ?> ne saurait être tenue pour responsable des dommages résultant d’une mauvaise utilisation du produit acheté, ni en cas d’accident dû à l’utilisation de ce produit.
            </p>
            <p>

                Enfin la responsabilité de la société <?php echo $nom_entreprise; ?> ne saurait être engagée pour tous les inconvénients ou dommages inhérents à l’utilisation du réseau Internet, notamment une rupture de service, une intrusion extérieure ou la présence de virus informatiques.
            </p>
    
            
            <h3>Article 12 – Droit applicable en cas de litiges</h3>
            <p>

                La langue du présent contrat est la langue française. Les présentes conditions de vente sont soumises à la loi française. En cas de litige, les tribunaux français seront les seuls compétents. En aucun cas les frais juridiques ne sauraient être à la charge de la société <?php echo $nom_entreprise; ?>.
            </p>
    
        </section>
        <hr>
        <section id="cgu">
            <h2>Condition générales d'utilisation</h2>
            <h3>Article 13 – Propriété intellectuelle</h3>
            <p>

                Tous les éléments du site <?php echo $site; ?>, de la page facebook et de la page instagram qualisarma sont et restent la propriété intellectuelle et exclusive de la société <?php echo $nom_entreprise; ?>. Nul n’est autorisé à reproduire, exploiter, rediffuser, ou utiliser à quelque titre que ce soit, même partiellement, des éléments du site qu’ils soient logiciels, visuels ou sonores. Tout lien simple ou par hypertexte est strictement interdit sans un accord écrit exprès de la société <?php echo $nom_entreprise; ?>.
                <br>
                Vous vous engagez à ne pas utiliser ce site à des fins illicites ou interdites par les lois ou par les mentions légales et contractuelles.
                <br>
                Votre utilisation de ce site web constitue votre acceptation des conditions générales et mentions d'avertissement. Ce site peut contenir des liens vers d'autres sites web. <?php echo $site;?> n'assume aucune responsabilité sur le contenu des sites autres que ceux faisant partie du domaine public.
            </p>
        </section>
        <hr>
        <section id="pc" class="mb-lg-5 mb-3">
            <h2>Politique de confidentialité</h2>
            <h3>Article 14 – Données personnelles</h3>
            <p>

                La société <?php echo $nom_entreprise; ?> se réserve le droit de collecter les informations nominatives et les données personnelles vous concernant (Nom, prénom, âge, adresse, adresse mail, numéro de téléphone, le nom de votre association, votre période de reconstitution) . Elles sont nécessaires à la gestion de votre commande, ainsi qu’à l’amélioration des services et des informations que nous vous adressons.
            </p>    
            <p>

                Elles peuvent aussi être transmises aux sociétés qui contribuent à ces relations, telles que celles chargées de l’exécution des services et commandes pour leur gestion, exécution, traitement et paiement.
            </p>
            <p>

                Ces informations et données sont également conservées à des fins de sécurité, afin de respecter les obligations légales et réglementaires.
            </p>
            <p>

                Conformément à la loi du 6 janvier 1978, vous disposez d’un droit d’accès, de rectification et d’opposition aux informations nominatives et aux données personnelles vous concernant, directement sur le site Internet.
            </p>
            
                    
            <h3>Article 15 – Archivage</h3>
            <p>

                La société <?php echo $nom_entreprise; ?> archivera les bons de commandes et les factures sur un support fiable et durable constituant une copie fidèle conformément aux dispositions de l’article 1348 du Code civil.
            </p>
            <p>

                Les registres informatisés de la société <?php echo $nom_entreprise; ?> seront considérés par toutes les parties concernées comme preuve des communications, commandes, paiements et transactions intervenus entre les parties.
            </p>

        </section>
        

        

 
    </div>
</div>
<script src="public/assets/js/configuration.js"></script>