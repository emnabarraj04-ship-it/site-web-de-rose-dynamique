<?php
class connexion
{
    public function CNXbase()
    {
        $dbc = new PDO('mysql:host=localhost;dbname=roses_db', 'root', '');
        return $dbc;
    }
}
?>
