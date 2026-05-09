<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$us->user_cin = $_POST['cinuser'];
$us->user_nom = $_POST['nomuser'];
$row = $us->recherche_user();
$n = $row->fetchColumn(0);

if ($n == 0) {
    $us->insertuser();
    header('location: ../view/liste.php');
} else {
    header('location: ../view/inscriptionForm.html');
}
?>
