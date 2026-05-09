<?php
class Utilisateur
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function create(string $nom, string $prenom, string $email, string $hash, string $adresse): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, adresse) VALUES (:nom, :prenom, :email, :mdp, :adresse)"
        );
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => $hash,
            ':adresse' => $adresse
        ]);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function updateProfil(int $id, string $nom, string $prenom, string $adresse): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE utilisateur SET nom = :nom, prenom = :prenom, adresse = :adresse WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':adresse' => $adresse
        ]);
    }

    public function countClients(): int
    {
        $stmt = $this->pdo->prepare("SELECT count(*) FROM utilisateur WHERE role = :role");
        $stmt->execute([':role' => 'client']);
        return (int) $stmt->fetchColumn();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
