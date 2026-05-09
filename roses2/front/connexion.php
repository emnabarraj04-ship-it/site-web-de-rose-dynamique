<?php
// ===== front/connexion.php =====
// Chapitre 2 (formulaires) + Chapitre 4 (Sessions + Cookies)

// Cookie : setcookie AVANT tout HTML (Chapitre 4 du cours)
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once '../controllers/FrontController.php';
$frontController = new FrontController();

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $frontController->connexion($_POST['email'] ?? '', $_POST['mot_de_passe'] ?? '');
    if (!empty($result['redirect'])) {
        header('Location: ' . $result['redirect']);
        exit();
    }
    $erreur = $result['erreur'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav>
    <a href="../index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="../index.php">Accueil</a>
        <a href="inscription.php">S'inscrire</a>
    </div>
</nav>

<div class="container">
    <div class="form-box" style="margin-top:40px;">
        <h2>🔑 Connexion</h2>

        <?php if ($erreur): ?>
            <div class="msg-erreur"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <!-- Message de validation DOM (affiché par JS - Chapitre 5) -->
        <div id="msg-validation" style="display:none; margin-bottom:10px;"></div>

        <!-- onsubmit : validation JS avant envoi (Chapitre 5) -->
        <form method="post" action="connexion.php" onsubmit="return validerFormulaire()">

            <label>Email</label>
            <!-- id="email" pour que JS puisse accéder (getElementById - Chapitre 5) -->
            <input type="email" name="email" id="email"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mdp" required>

            <button type="submit" class="btn btn-rose">Se connecter</button>
        </form>

        <div class="msg-succes" style="margin-top:14px; font-size:0.82rem;">
            <strong>Admin :</strong> admin@roses.tn / password
        </div>

        <p style="text-align:center; margin-top:14px; font-size:0.88rem;">
            Pas de compte ? <a href="inscription.php" style="color:#e75480;">S'inscrire</a>
        </p>
    </div>
</div>

<footer>
    &copy; 2026 La Rose — Projet Web II, 1ère année GI
</footer>

<!-- JS externe (Chapitre 5) -->
<script src="../js/script.js"></script>

</body>
</html>
