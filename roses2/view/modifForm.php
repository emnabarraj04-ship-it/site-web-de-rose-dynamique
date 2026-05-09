<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$id = isset($_GET['id']) ? preg_replace('/[^0-9A-Za-z]/', '', $_GET['id']) : '';
if ($id == '') {
    header('location: liste.php');
    exit();
}
$res = $us->getuser($id);
$data = $res->fetchAll(PDO::FETCH_ASSOC);
if (!isset($data[0])) {
    header('location: liste.php');
    exit();
}
$cin = $data[0]['user_cin'];
$nom = $data[0]['user_nom'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
</head>
<body>
    <h2>Modifier utilisateur</h2>
    <form action="../controller/modification.php" method="post">
        <label>Code</label><br>
        <input type="text" name="cin" value="<?php echo htmlspecialchars($cin, ENT_QUOTES, 'UTF-8'); ?>" readonly><br><br>

        <label>Nom</label><br>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'); ?>" required><br><br>

        <button type="submit">Modifier</button>
    </form>
    <p><a href="liste.php">Retour à la liste</a></p>
</body>
</html>
