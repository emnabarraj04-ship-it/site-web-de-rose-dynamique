<?php
// ===== back/liste_produits.php =====
require_once 'auth.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController();

if (isset($_GET['supprimer'])) {
    $adminController->supprimerProduit((int)$_GET['supprimer']);
    header('Location: liste_produits.php?succes=1'); exit();
}

$produits = $adminController->getProduits();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits - Admin La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="admin-wrap">
    <div class="sidebar">
        <span class="logo">🌹 Admin</span>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="liste_produits.php" class="active">🌹 Produits</a>
        <a href="ajouter_produit.php">➕ Ajouter</a>
        <a href="liste_utilisateurs.php">👥 Utilisateurs</a>
        <a href="liste_commandes.php">📦 Commandes</a>
        <a href="../index.php">🌐 Voir le site</a>
        <a href="../front/deconnexion.php">🚪 Déconnexion</a>
    </div>
    <div class="admin-page">
        <h1>🌹 Produits</h1>
        <?php if (isset($_GET['succes'])): ?><div class="msg-succes">Produit supprimé.</div><?php endif; ?>
        <a href="ajouter_produit.php" class="btn btn-rose" style="margin-bottom:16px; display:inline-block;">➕ Ajouter</a>
        <table>
            <thead><tr><th>ID</th><th>Produit</th><th>Prix</th><th>Stock</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo $p['image'].' '.htmlspecialchars($p['nom']); ?></td>
                    <td><?php echo number_format($p['prix'],2); ?> DT</td>
                    <td><?php echo $p['stock']; ?></td>
                    <td>
                        <a href="modifier_produit.php?id=<?php echo $p['id']; ?>" class="btn" style="background:#f8bbd0; color:#c2185b; padding:6px 12px; font-size:0.82rem;">✏️ Modifier</a>
                        <a href="liste_produits.php?supprimer=<?php echo $p['id']; ?>" class="btn btn-rouge" style="padding:6px 12px; font-size:0.82rem;" onclick="return confirm('Supprimer ?')">🗑 Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
