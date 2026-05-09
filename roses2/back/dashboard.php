<?php
require_once 'auth.php';
require_once '../classes/connexion.php';
$nb_p = $pdo->query("SELECT count(*) FROM produit")->fetchColumn();
$nb_u = $pdo->query("SELECT count(*) FROM utilisateur WHERE role='client'")->fetchColumn();
$nb_c = $pdo->query("SELECT count(*) FROM commande")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="admin-wrap">
    <div class="sidebar">
        <span class="logo">🌹 Admin</span>
        <a href="dashboard.php" class="active">🏠 Dashboard</a>
        <a href="liste_produits.php">🌹 Produits</a>
        <a href="ajouter_produit.php">➕ Ajouter</a>
        <a href="liste_utilisateurs.php">👥 Utilisateurs</a>
        <a href="liste_commandes.php">📦 Commandes</a>
        <a href="../index.php">🌐 Voir le site</a>
        <a href="../front/deconnexion.php">🚪 Déconnexion</a>
    </div>
    <div class="admin-page">
        <h1>Tableau de bord</h1>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:28px;">
            <div style="background:white; border-left:4px solid #e75480; padding:20px; border-radius:8px;">
                <div style="font-size:2rem; font-weight:bold; color:#c2185b;"><?php echo $nb_p; ?></div>
                <div style="color:#888;">🌹 Produits</div>
            </div>
            <div style="background:white; border-left:4px solid #e75480; padding:20px; border-radius:8px;">
                <div style="font-size:2rem; font-weight:bold; color:#c2185b;"><?php echo $nb_u; ?></div>
                <div style="color:#888;">👥 Clients</div>
            </div>
            <div style="background:white; border-left:4px solid #e75480; padding:20px; border-radius:8px;">
                <div style="font-size:2rem; font-weight:bold; color:#c2185b;"><?php echo $nb_c; ?></div>
                <div style="color:#888;">📦 Commandes</div>
            </div>
        </div>
        <a href="ajouter_produit.php" class="btn btn-rose">➕ Ajouter un produit</a>
    </div>
</div>
</body>
</html>
