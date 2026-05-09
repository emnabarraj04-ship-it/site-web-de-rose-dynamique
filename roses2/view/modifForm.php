<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$res = $us->getuser($_GET['id']);
$data = $res->fetchAll(PDO::FETCH_ASSOC);
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
        <input type="text" name="cin" value="<?php echo $cin; ?>" readonly><br><br>

        <label>Nom</label><br>
        <input type="text" name="nom" value="<?php echo $nom; ?>" required><br><br>

        <button type="submit">Modifier</button>
    </form>
    <p><a href="liste.php">Retour à la liste</a></p>
</body>
</html>
