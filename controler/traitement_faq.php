<?php

// récupération des questions
$faq = req_all_faq($bdd);

$sortie = "";
$i = 1;
foreach ($faq as $lignes) {
    $sortie .= '
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-heading'.$i.'">
            <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapse'.$i.'"
                aria-expanded="true"
                aria-controls="flush-collapse'.$i.'"
            >
                '.$lignes['question_faq'].'
            </button>
        </h2>
        <div
            id="flush-collapse'.$i.'"
            class="accordion-collapse collapse"
            aria-labelledby="flush-heading'.$i.'"
            data-bs-parent="#accordionFAQ"
        >
            <div class="accordion-body">
                '.$lignes['reponse_faq'].'
            </div>
        </div>
    </div>
    ';
    $i++;
}
?>