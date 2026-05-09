<?php
// ===== front/inscription.php =====
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
require_once '../controllers/FrontController.php';

$frontController = new FrontController();

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $frontController->inscription($_POST);
    $erreur = $result['erreur'];
    $succes = $result['succes'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav>
    <a href="../index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="../index.php">Accueil</a>
        <a href="connexion.php">Connexion</a>
    </div>
</nav>

<div class="container">
    <div class="form-box" style="margin-top:30px;">
        <h2>🌸 Inscription</h2>

        <?php if ($erreur): ?>
            <div class="msg-erreur"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <?php if ($succes): ?>
            <div class="msg-succes"><?php echo $succes; ?> <a href="connexion.php">Se connecter</a></div>
        <?php else: ?>

        <form method="post" action="inscription.php">
            <label>Nom</label>
            <input type="text" name="nom" value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : ''; ?>" required>

            <label>Prénom</label>
            <input type="text" name="prenom" value="<?php echo isset($_POST['prenom']) ? $_POST['prenom'] : ''; ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" required>

            <label>Adresse de livraison</label>
            <textarea name="adresse" rows="3"><?php echo isset($_POST['adresse']) ? $_POST['adresse'] : ''; ?></textarea>

            <button type="submit" class="btn btn-rose">S'inscrire</button>
        </form>

        <p style="text-align:center; margin-top:14px; font-size:0.88rem;">
            Déjà un compte ? <a href="connexion.php" style="color:#e75480;">Se connecter</a>
        </p>

        <?php endif; ?>
    </div>
</div>

<footer>
    &copy; 2026 La Rose — Projet Web II, 1ère année GI
</footer>

</body>
</html>
