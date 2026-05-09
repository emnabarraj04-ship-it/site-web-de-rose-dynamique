<?php
class Commande
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $userId, int $produitId, int $quantite, string $adresse): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO commande (user_id, produit_id, quantite, adresse) VALUES (:user_id, :produit_id, :quantite, :adresse)"
        );
        return $stmt->execute([
            ':user_id' => $userId,
            ':produit_id' => $produitId,
            ':quantite' => $quantite,
            ':adresse' => $adresse
        ]);
    }

    public function getByUserId(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT c.*, p.nom, p.image, p.prix
             FROM commande c
             JOIN produit p ON c.produit_id = p.id
             WHERE c.user_id = :id
             ORDER BY c.date_cmd DESC"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithRelations(): array
    {
        return $this->pdo->query(
            "SELECT c.*, u.nom, u.prenom, p.nom AS produit, p.image, p.prix
             FROM commande c
             JOIN utilisateur u ON c.user_id = u.id
             JOIN produit p ON c.produit_id = p.id
             ORDER BY c.date_cmd DESC"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query("SELECT count(*) FROM commande")->fetchColumn();
    }
}
?>
