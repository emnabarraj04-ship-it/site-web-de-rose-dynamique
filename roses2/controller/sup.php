<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$us->supprimer_user($_GET['id']);
header('location:../view/liste.php');
?>
