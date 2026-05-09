<?php
// ===== back/auth.php =====
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header('Location: ../front/connexion.php');
    exit();
}
?>
