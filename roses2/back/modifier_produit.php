<?php
require_once 'auth.php';
require_once '../controllers/AdminController.php';
if (!isset($_GET['id'])) { header('Location: liste_produits.php'); exit(); }
if ((int)$_GET['id'] < 1) { header('Location: liste_produits.php'); exit(); }
$adminController = new AdminController();
$id=$_GET['id']; $erreur='';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $result = $adminController->updateProduit((int)$id, $_POST);
    $erreur = $result['erreur'];
    if ($erreur === '') {
        header('Location: liste_produits.php?succes=1'); exit();
    }
}
$p=$adminController->getProduitById((int)$id);
if (!$p) { header('Location: liste_produits.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Modifier - Admin La Rose</title><link rel="stylesheet" href="../css/style.css"></head>
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
        <h1>✏️ Modifier un produit</h1>
        <a href="liste_produits.php" style="color:#e75480;">← Retour</a>
        <?php if ($erreur): ?><div class="msg-erreur" style="margin-top:14px;"><?php echo $erreur; ?></div><?php endif; ?>
        <div class="form-box" style="margin-top:20px; max-width:500px;">
            <form method="post" action="modifier_produit.php?id=<?php echo $id; ?>">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo htmlspecialchars($p['nom']); ?>" required>
                <label>Description</label>
                <textarea name="description" rows="3"><?php echo htmlspecialchars($p['description']); ?></textarea>
                <label>Prix (DT)</label>
                <input type="number" name="prix" step="0.01" value="<?php echo $p['prix']; ?>" required>
                <label>Stock</label>
                <input type="number" name="stock" value="<?php echo $p['stock']; ?>">
                <label>Emoji</label>
                <input type="text" name="image" value="<?php echo htmlspecialchars($p['image']); ?>">
                <button type="submit" class="btn btn-rose">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
