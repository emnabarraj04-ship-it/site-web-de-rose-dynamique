<?php
require_once 'auth.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController();
$commandes = $adminController->getCommandes();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Commandes - Admin La Rose</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-wrap">
    <div class="sidebar">
        <span class="logo">🌹 Admin</span>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="liste_produits.php">🌹 Produits</a>
        <a href="ajouter_produit.php">➕ Ajouter</a>
        <a href="liste_utilisateurs.php">👥 Utilisateurs</a>
        <a href="liste_commandes.php" class="active">📦 Commandes</a>
        <a href="../index.php">🌐 Voir le site</a>
        <a href="../front/deconnexion.php">🚪 Déconnexion</a>
    </div>
    <div class="admin-page">
        <h1>📦 Commandes</h1>
        <table>
            <thead><tr><th>#</th><th>Client</th><th>Produit</th><th>Qté</th><th>Total</th><th>Date</th></tr></thead>
            <tbody>
                <?php if (empty($commandes)): ?>
                    <tr><td colspan="6" style="text-align:center; color:#888;">Aucune commande.</td></tr>
                <?php else: ?>
                    <?php foreach ($commandes as $c): ?>
                    <tr>
                        <td><?php echo $c['id']; ?></td>
                        <td><?php echo htmlspecialchars($c['prenom'].' '.$c['nom']); ?></td>
                        <td><?php echo $c['image'].' '.htmlspecialchars($c['produit']); ?></td>
                        <td><?php echo $c['quantite']; ?></td>
                        <td><?php echo number_format($c['quantite']*$c['prix'],2); ?> DT</td>
                        <td><?php echo date('d/m/Y', strtotime($c['date_cmd'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
