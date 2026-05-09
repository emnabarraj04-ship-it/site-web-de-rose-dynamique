<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$id = isset($_GET['id']) ? preg_replace('/[^0-9A-Za-z]/', '', $_GET['id']) : '';
if ($id != '') {
    $us->supprimer_user($id);
}
header('location:../view/liste.php');
?>
