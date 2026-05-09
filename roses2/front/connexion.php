<?php
// ===== front/connexion.php =====
// Chapitre 2 (formulaires) + Chapitre 4 (Sessions + Cookies)

// Cookie : setcookie AVANT tout HTML (Chapitre 4 du cours)
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

require_once '../classes/connexion.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp   = $_POST['mot_de_passe'];

    $req  = $pdo->query("SELECT * FROM utilisateur WHERE email='$email'");
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp, $user['mot_de_passe'])) {

        // Créer la session (Chapitre 4)
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_nom']  = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Cookie : se souvenir du visiteur (Chapitre 4 du cours)
        // time()+60*60*24*30 = expire dans 30 jours
        setcookie("dernier_visiteur", $user['prenom'], time()+60*60*24*30, "/", "", 0);

        if ($user['role'] == 'admin') {
            header('Location: ../back/dashboard.php');
        } else {
            header('Location: ../index.php');
        }
        exit();

    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - La Rose</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav>
    <a href="../index.php" class="logo">🌹 La Rose</a>
    <div>
        <a href="../index.php">Accueil</a>
        <a href="inscription.php">S'inscrire</a>
    </div>
</nav>

<div class="container">
    <div class="form-box" style="margin-top:40px;">
        <h2>🔑 Connexion</h2>

        <?php if ($erreur): ?>
            <div class="msg-erreur"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <!-- Message de validation DOM (affiché par JS - Chapitre 5) -->
        <div id="msg-validation" style="display:none; margin-bottom:10px;"></div>

        <!-- onsubmit : validation JS avant envoi (Chapitre 5) -->
        <form method="post" action="connexion.php" onsubmit="return validerFormulaire()">

            <label>Email</label>
            <!-- id="email" pour que JS puisse accéder (getElementById - Chapitre 5) -->
            <input type="email" name="email" id="email"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mdp" required>

            <button type="submit" class="btn btn-rose">Se connecter</button>
        </form>

        <div class="msg-succes" style="margin-top:14px; font-size:0.82rem;">
            <strong>Admin :</strong> admin@roses.tn / password
        </div>

        <p style="text-align:center; margin-top:14px; font-size:0.88rem;">
            Pas de compte ? <a href="inscription.php" style="color:#e75480;">S'inscrire</a>
        </p>
    </div>
</div>

<footer>
    &copy; 2026 La Rose — Projet Web II, 1ère année GI
</footer>

<!-- JS externe (Chapitre 5) -->
<script src="../js/script.js"></script>

</body>
</html>
