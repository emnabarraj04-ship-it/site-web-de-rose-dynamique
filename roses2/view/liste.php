<?php
require_once '../model/user.class.php';
$us = new utilisateur();
$res = $us->listusers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <h2>Liste des utilisateurs</h2>
    <table border="1" cellpadding="6">
        <tr>
            <td>Numero cin utilisateur</td>
            <td>Nom utilisateur</td>
            <td>Modifier</td>
            <td>Supprimer</td>
        </tr>
        <?php foreach ($res as $row) {
            $cin = htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8');
            $nom = htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8');
            echo "<tr><td>$cin</td>";
            echo "<td>$nom</td>";
            echo "<td><a href=\"modifForm.php?id=" . urlencode($row[0]) . "\">Modifier</a></td>";
            echo "<td><a href=\"../controller/sup.php?id=" . urlencode($row[0]) . "\">Supprimer</a></td></tr>";
        } ?>
    </table>
    <p><a href="inscriptionForm.html">Ajouter un utilisateur</a></p>
</body>
</html>
