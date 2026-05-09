<?php
class Produit
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        return $this->pdo->query("SELECT * FROM produit")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailable(): array
    {
        return $this->pdo->query("SELECT * FROM produit WHERE stock > 0")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produit WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produit ?: null;
    }

    public function create(string $nom, string $description, float $prix, int $stock, string $image): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO produit (nom,description,prix,stock,image) VALUES (:nom,:description,:prix,:stock,:image)"
        );
        return $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':image' => $image
        ]);
    }

    public function update(int $id, string $nom, string $description, float $prix, int $stock, string $image): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE produit SET nom=:nom, description=:description, prix=:prix, stock=:stock, image=:image WHERE id=:id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':image' => $image
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM produit WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function decrementStock(int $id, int $quantite): bool
    {
        $stmt = $this->pdo->prepare("UPDATE produit SET stock = stock - :quantite WHERE id=:id AND stock >= :quantite");
        $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function countAll(): int
    {
        return (int) $this->pdo->query("SELECT count(*) FROM produit")->fetchColumn();
    }
}
?>
