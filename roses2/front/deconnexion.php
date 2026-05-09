<?php
// ===== front/deconnexion.php =====
// Chapitre 4 : session_destroy + supprimer cookie

// Supprimer le cookie en mettant une date passée (Chapitre 4 du cours)
setcookie("dernier_visiteur", "", time() - 10000, "/");

session_start();
session_unset();
session_destroy();
header('Location: ../index.php');
exit();
?>
