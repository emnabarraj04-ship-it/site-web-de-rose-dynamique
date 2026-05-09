<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$us->user_cin = isset($_POST['cinuser']) ? preg_replace('/[^0-9A-Za-z]/', '', $_POST['cinuser']) : '';
$us->user_nom = isset($_POST['nomuser']) ? trim($_POST['nomuser']) : '';
if ($us->user_cin == '' || $us->user_nom == '') {
    header('location: ../view/inscriptionForm.html');
    exit();
}
$row = $us->recherche_user();
$n = $row->fetchColumn(0);

if ($n == 0) {
    $us->insertuser();
    header('location: ../view/liste.php');
} else {
    header('location: ../view/inscriptionForm.html');
}
exit();
?>
