<?php
if (isset($_GET['id']) && $_GET['id']) {
    $id_contact = intval($_GET['id']);

    req_lu_contact($bdd, $id_contact);
    $contact = req_contact($bdd, $id_contact);

}
?>