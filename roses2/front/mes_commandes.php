<?php
// ===== front/mes_commandes.php =====
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: connexion.php'); exit(); }
require_once '../controllers/FrontController.php';

$frontController = new FrontController();
$commandes = $frontController->getMesCommandes((int)$_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes - La Rose</title>
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
    <h2>📦 Mes Commandes</h2>
    <?php if (empty($commandes)): ?>
        <div class="msg-succes">Aucune commande pour l'instant. <a href="produits.php" style="color:#2e7d32;">Voir les roses</a></div>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>#</th><th>Produit</th><th>Qté</th><th>Total</th><th>Adresse</th><th>Date</th></tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $c): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo $c['image'].' '.htmlspecialchars($c['nom']); ?></td>
                    <td><?php echo $c['quantite']; ?></td>
                    <td><?php echo number_format($c['quantite']*$c['prix'],2); ?> DT</td>
                    <td><?php echo htmlspecialchars($c['adresse']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($c['date_cmd'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<footer>&copy; 2026 La Rose — Projet Web II, 1ère année GI</footer>
</body>
</html>
