<?php
// ===== front/produits.php =====
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}
require_once '../classes/connexion.php';

$res = $pdo->query("SELECT * FROM produit");
$produits = $res->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Roses - La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav>
    <a href="../index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="../index.php">Accueil</a>
        <a href="produits.php">Nos Roses</a>
        <a href="profil.php">Mon Profil</a>
        <a href="commande.php">Commander</a>
        <a href="deconnexion.php">Déconnexion</a>
    </div>
</nav>

<div class="container">
    <h2>🌹 Nos Roses</h2>

    <!-- Message DOM (Chapitre 5) -->
    <div id="msg-panier"></div>

    <div class="grille">
        <?php foreach ($produits as $p): ?>
        <div class="carte">
            <div class="emoji"><?php echo $p['image']; ?></div>
            <h3><?php echo htmlspecialchars($p['nom']); ?></h3>
            <p><?php echo htmlspecialchars($p['description']); ?></p>
            <div class="prix"><?php echo number_format($p['prix'], 2); ?> DT</div>

            <?php if ($p['stock'] > 0): ?>
                <!-- onclick avec JS (Chapitre 5) -->
                <button class="btn btn-rose"
                    onclick="ajouterPanier('<?php echo htmlspecialchars($p['nom']); ?>')">
                    🛒 Ajouter
                </button>
                <a href="commande.php?id=<?php echo $p['id']; ?>" class="btn" style="background:#f8bbd0; color:#c2185b; margin-left:5px;">Commander</a>
            <?php else: ?>
                <span style="color:#e53935; font-weight:bold;">Épuisé</span>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    &copy; 2026 La Rose — Projet Web II, 1ère année GI
</footer>

<script src="../js/script.js"></script>
</body>
</html>
