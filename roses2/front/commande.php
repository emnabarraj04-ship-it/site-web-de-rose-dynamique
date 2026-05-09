<?php
// ===== front/commande.php =====
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: connexion.php'); exit(); }
require_once '../classes/connexion.php';

$succes = ''; $erreur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_id  = $_POST['produit_id'];
    $quantite = $_POST['quantite'];
    $adresse  = $_POST['adresse'];
    $user_id  = $_SESSION['user_id'];

    if (empty($adresse) || $quantite < 1) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $pdo->exec("INSERT INTO commande (user_id, produit_id, quantite, adresse) VALUES ('$user_id','$prod_id','$quantite','$adresse')");
        $pdo->exec("UPDATE produit SET stock = stock - '$quantite' WHERE id='$prod_id'");
        $succes = "✅ Commande passée avec succès !";
    }
}

$res = $pdo->query("SELECT * FROM produit WHERE stock > 0");
$produits = $res->fetchAll(PDO::FETCH_ASSOC);
$produit  = null;
if (isset($_GET['id'])) {
    $req    = $pdo->query("SELECT * FROM produit WHERE id='" . $_GET['id'] . "'");
    $produit = $req->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commander - La Rose</title>
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
        <h2>🛒 Passer une commande</h2>
        <?php if ($erreur): ?><div class="msg-erreur"><?php echo $erreur; ?></div><?php endif; ?>
        <?php if ($succes): ?>
            <div class="msg-succes"><?php echo $succes; ?><br>
                <a href="mes_commandes.php" style="color:#2e7d32;">Voir mes commandes</a>
            </div>
        <?php endif; ?>
        <form method="post" action="commande.php">
            <label>Choisir un produit</label>
            <select name="produit_id" required>
                <?php foreach ($produits as $p): ?>
                    <option value="<?php echo $p['id']; ?>" <?php echo (isset($produit) && $produit['id']==$p['id']) ? 'selected' : ''; ?>>
                        <?php echo $p['image'].' '.htmlspecialchars($p['nom']); ?> — <?php echo number_format($p['prix'],2); ?> DT
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Quantité</label>
            <input type="number" name="quantite" value="1" min="1" required>
            <label>Adresse de livraison</label>
            <textarea name="adresse" rows="3" placeholder="Votre adresse complète..." required></textarea>
            <button type="submit" class="btn btn-rose">Confirmer la commande</button>
        </form>
    </div>
</div>
<footer>&copy; 2026 La Rose — Projet Web II, 1ère année GI</footer>
</body>
</html>
