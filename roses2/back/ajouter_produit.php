<?php
require_once 'auth.php';
require_once '../classes/connexion.php';
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom=$_POST['nom']; $description=$_POST['description']; $prix=$_POST['prix']; $stock=$_POST['stock']; $image=$_POST['image'];
    if (empty($nom)||empty($prix)) { $erreur="Nom et prix obligatoires."; }
    else {
        $pdo->exec("INSERT INTO produit (nom,description,prix,stock,image) VALUES ('$nom','$description','$prix','$stock','$image')");
        header('Location: liste_produits.php?succes=1'); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Ajouter - Admin La Rose</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="admin-wrap">
    <div class="sidebar">
        <span class="logo">🌹 Admin</span>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="liste_produits.php">🌹 Produits</a>
        <a href="ajouter_produit.php" class="active">➕ Ajouter</a>
        <a href="liste_utilisateurs.php">👥 Utilisateurs</a>
        <a href="liste_commandes.php">📦 Commandes</a>
        <a href="../index.php">🌐 Voir le site</a>
        <a href="../front/deconnexion.php">🚪 Déconnexion</a>
    </div>
    <div class="admin-page">
        <h1>➕ Ajouter un produit</h1>
        <a href="liste_produits.php" style="color:#e75480;">← Retour</a>
        <?php if ($erreur): ?><div class="msg-erreur" style="margin-top:14px;"><?php echo $erreur; ?></div><?php endif; ?>
        <div class="form-box" style="margin-top:20px; max-width:500px;">
            <form method="post" action="ajouter_produit.php">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo isset($_POST['nom'])?$_POST['nom']:''; ?>" required>
                <label>Description</label>
                <textarea name="description" rows="3"><?php echo isset($_POST['description'])?$_POST['description']:''; ?></textarea>
                <label>Prix (DT)</label>
                <input type="number" name="prix" step="0.01" min="0" value="<?php echo isset($_POST['prix'])?$_POST['prix']:''; ?>" required>
                <label>Stock</label>
                <input type="number" name="stock" min="0" value="<?php echo isset($_POST['stock'])?$_POST['stock']:'0'; ?>">
                <label>Emoji</label>
                <input type="text" name="image" value="<?php echo isset($_POST['image'])?$_POST['image']:'🌹'; ?>">
                <button type="submit" class="btn btn-rose">Ajouter</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
