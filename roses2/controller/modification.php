<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$us->user_cin = $_POST['cin'];
$us->user_nom = $_POST['nom'];
$us->modifier_user($_POST['cin']);
header('location: ../view/liste.php');
?>
