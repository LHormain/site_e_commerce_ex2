<?php
include_once('controler/traitement_ateliers_participatif.php');
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=1">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ateliers - Pour les particuliers</li>
  </ol>
</nav>
<h1 class="text-center my-3">Nos ateliers participatifs</h1>
<p class="px-5 px-md-5 px-lg-0"><?php echo nl2br($texte_ateliers[0]['texte_pf']);?></p>

<?php echo $sortie; ?>