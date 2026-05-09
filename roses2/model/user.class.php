<?php
class utilisateur
{
    public $user_cin;
    public $user_nom;

    function insertuser()
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "insert into utilisateur_mvc (user_cin, user_nom) values ('$this->user_cin', '$this->user_nom')";
        $pdo->exec($req) or print_r($pdo->errorInfo());
    }

    function listusers()
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM utilisateur_mvc";
        $res = $pdo->query($req) or print_r($pdo->errorInfo());
        return $res;
    }

    function getuser($id)
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM utilisateur_mvc where user_cin='$id'";
        $res = $pdo->query($req) or print_r($pdo->errorInfo());
        return $res;
    }

    function modifier_user($id)
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "UPDATE utilisateur_mvc SET user_nom='$this->user_nom' WHERE user_cin='$id'";
        $pdo->exec($req) or print_r($pdo->errorInfo());
    }

    function supprimer_user($id)
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "DELETE FROM utilisateur_mvc WHERE user_cin='$id'";
        $pdo->exec($req) or print_r($pdo->errorInfo());
    }

    function recherche_user()
    {
        require_once __DIR__ . '/../config/config.php';
        $cnx = new connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT count(*) FROM utilisateur_mvc WHERE user_cin='$this->user_cin'";
        $res = $pdo->query($req) or print_r($pdo->errorInfo());
        return $res;
    }
}
?>
