<?php
// ===== index.php =====
// Chapitre 3 (MySQL) + Chapitre 4 (Cookies) + Chapitre 5 (JS/DOM)

// Cookie : accepter la bannière (Chapitre 4 du cours)
// setcookie doit être AVANT toute balise HTML
if (isset($_GET['accepter_cookie'])) {
    setcookie("cookies_acceptes", "oui", time() + 60*60*24*30, "/", "", 0);
    header('Location: index.php');
    exit();
}

session_start();
require_once 'classes/connexion.php';

// Récupérer les produits (Chapitre 3)
$res     = $pdo->query("SELECT * FROM produit");
$produits = $res->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>La Rose - Fleuriste en ligne</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="index.php">Accueil</a>
        <a href="front/produits.php">Nos Roses</a>
        <a href="view/liste.php">Module MVC</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="front/profil.php">Mon Profil</a>
            <a href="front/commande.php">Commander</a>
            <a href="front/deconnexion.php">Déconnexion</a>
        <?php else: ?>
            <a href="front/connexion.php">Connexion</a>
            <a href="front/inscription.php">S'inscrire</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Afficher le nom depuis le cookie si existant (Chapitre 4) -->
<?php if (isset($_COOKIE['dernier_visiteur'])): ?>
    <div style="background:#fce4ec; color:#c2185b; text-align:center; padding:8px; font-size:0.88rem;">
        👋 Bon retour <strong><?php echo $_COOKIE['dernier_visiteur']; ?></strong> !
    </div>
<?php endif; ?>

<!-- BANNIÈRE COOKIE (Chapitre 4 + DOM Chapitre 5) -->
<?php if (!isset($_COOKIE['cookies_acceptes'])): ?>
    <div id="cookie-banner">
        <span>🍪 Ce site utilise des cookies pour améliorer votre expérience.</span>
        <!-- onclick utilise une fonction JS (Chapitre 5) -->
        <button onclick="accepterCookies()">Accepter</button>
    </div>
<?php endif; ?>

<!-- HERO -->
<div style="background: linear-gradient(135deg, #e75480, #f48fb1); color:white; text-align:center; padding:50px 20px;">
    <h1 style="color:white; font-size:2rem; margin-bottom:10px;">🌹 Bienvenue chez La Rose</h1>
    <p style="margin-bottom:20px;">Les plus belles roses livrées chez vous en Tunisie</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="front/inscription.php" class="btn btn-rose" style="background:white; color:#e75480; font-weight:bold;">Créer un compte</a>
        <a href="front/connexion.php"   class="btn" style="border:2px solid white; color:white; margin-left:10px;">Se connecter</a>
    <?php else: ?>
        <a href="front/produits.php" class="btn btn-rose" style="background:white; color:#e75480; font-weight:bold;">Voir nos roses</a>
    <?php endif; ?>
</div>

<!-- PRODUITS -->
<div class="container">
    <h2>Nos Produits</h2>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="msg-erreur">⚠️ Connectez-vous pour commander.</div>
    <?php endif; ?>

    <!-- Message DOM (affiché par JavaScript - Chapitre 5) -->
    <div id="msg-panier"></div>

    <div class="grille">
        <?php foreach ($produits as $p): ?>
        <div class="carte">
            <div class="emoji"><?php echo $p['image']; ?></div>
            <h3><?php echo htmlspecialchars($p['nom']); ?></h3>
            <p><?php echo htmlspecialchars($p['description']); ?></p>
            <div class="prix"><?php echo number_format($p['prix'], 2); ?> DT</div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- onclick avec fonction JS (Chapitre 5) -->
                <button class="btn btn-rose"
                    onclick="ajouterPanier('<?php echo htmlspecialchars($p['nom']); ?>')">
                    🛒 Ajouter
                </button>
                <a href="front/commande.php?id=<?php echo $p['id']; ?>" class="btn" style="background:#f8bbd0; color:#c2185b; margin-left:5px;">Commander</a>
            <?php else: ?>
                <a href="front/connexion.php" class="btn btn-gris">Connectez-vous</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    &copy; 2026 La Rose — Projet Web II, 1ère année GI
</footer>

<!-- Fichier JS externe (Chapitre 5 du cours) -->
<script src="js/script.js"></script>

</body>
</html>
