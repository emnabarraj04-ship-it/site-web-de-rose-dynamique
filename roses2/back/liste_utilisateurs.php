<?php
// ===== back/liste_utilisateurs.php =====
require_once 'auth.php';
require_once '../classes/connexion.php';
$users = $pdo->query("SELECT * FROM utilisateur ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Utilisateurs - Admin La Rose</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-wrap">
    <div class="sidebar">
        <span class="logo">🌹 Admin</span>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="liste_produits.php">🌹 Produits</a>
        <a href="ajouter_produit.php">➕ Ajouter</a>
        <a href="liste_utilisateurs.php" class="active">👥 Utilisateurs</a>
        <a href="liste_commandes.php">📦 Commandes</a>
        <a href="../index.php">🌐 Voir le site</a>
        <a href="../front/deconnexion.php">🚪 Déconnexion</a>
    </div>
    <div class="admin-page">
        <h1>👥 Utilisateurs</h1>
        <table>
            <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th></tr></thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo htmlspecialchars($u['prenom'].' '.$u['nom']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo $u['role']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
