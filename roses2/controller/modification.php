<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$us->user_cin = isset($_POST['cin']) ? preg_replace('/[^0-9A-Za-z]/', '', $_POST['cin']) : '';
$us->user_nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
if ($us->user_cin != '' && $us->user_nom != '') {
    $us->modifier_user($us->user_cin);
}
header('location: ../view/liste.php');
exit();
?>
