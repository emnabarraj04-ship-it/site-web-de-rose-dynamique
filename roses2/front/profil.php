<?php
// ===== front/profil.php =====
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: connexion.php'); exit(); }
require_once '../controllers/FrontController.php';

$frontController = new FrontController();

$succes = ''; $erreur = '';
$user = $frontController->getUserById((int)$_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $frontController->updateProfil((int)$_SESSION['user_id'], $_POST);
    $erreur = $result['erreur'];
    $succes = $result['succes'];
    $user = $frontController->getUserById((int)$_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav>
    <a href="../index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="../index.php">Accueil</a>
        <a href="produits.php">Nos Roses</a>
        <a href="profil.php">Mon Profil</a>
        <a href="mes_commandes.php">Mes Commandes</a>
        <a href="deconnexion.php">Déconnexion</a>
    </div>
</nav>
<div class="container">
    <div class="form-box" style="margin-top:30px; max-width:500px;">
        <h2>👤 Mon Profil</h2>
        <?php if ($erreur): ?><div class="msg-erreur"><?php echo $erreur; ?></div><?php endif; ?>
        <?php if ($succes): ?><div class="msg-succes"><?php echo $succes; ?></div><?php endif; ?>

        <!-- Afficher le cookie (Chapitre 4) -->
        <?php if (isset($_COOKIE['dernier_visiteur'])): ?>
            <div class="msg-succes" style="font-size:0.82rem;">
                🍪 Cookie enregistré : Bonjour <strong><?php echo $_COOKIE['dernier_visiteur']; ?></strong>
            </div>
        <?php endif; ?>

        <form method="post" action="profil.php">
            <label>Nom</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
            <label>Email (non modifiable)</label>
            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled style="background:#eee;">
            <label>Adresse</label>
            <textarea name="adresse" rows="3"><?php echo htmlspecialchars($user['adresse'] ?? ''); ?></textarea>
            <button type="submit" class="btn btn-rose">Enregistrer</button>
        </form>
        <p style="text-align:center; margin-top:14px;">
            <a href="mes_commandes.php" style="color:#e75480;">Voir mes commandes →</a>
        </p>
    </div>
</div>
<footer>&copy; 2026 La Rose — Projet Web II, 1ère année GI</footer>
</body>
</html>
