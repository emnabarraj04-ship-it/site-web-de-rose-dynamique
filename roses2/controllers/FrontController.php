<?php
require_once __DIR__ . '/../classes/connexion.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../models/Commande.php';

class FrontController
{
    private PDO $pdo;
    private Utilisateur $utilisateurModel;
    private Produit $produitModel;
    private Commande $commandeModel;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        $this->utilisateurModel = new Utilisateur($this->pdo);
        $this->produitModel = new Produit($this->pdo);
        $this->commandeModel = new Commande($this->pdo);
    }

    public function getAllProduits(): array
    {
        return $this->produitModel->getAll();
    }

    public function getProduitsDisponibles(): array
    {
        return $this->produitModel->getAvailable();
    }

    public function getProduitById(?int $id): ?array
    {
        if (!$id) {
            return null;
        }
        return $this->produitModel->getById($id);
    }

    public function inscription(array $data): array
    {
        $nom = trim($data['nom'] ?? '');
        $prenom = trim($data['prenom'] ?? '');
        $email = trim($data['email'] ?? '');
        $motDePasse = $data['mot_de_passe'] ?? '';
        $adresse = trim($data['adresse'] ?? '');

        if ($nom === '' || $prenom === '' || $email === '' || $motDePasse === '') {
            return ['erreur' => 'Veuillez remplir tous les champs.', 'succes' => ''];
        }

        if ($this->utilisateurModel->findByEmail($email)) {
            return ['erreur' => 'Cet email est déjà utilisé.', 'succes' => ''];
        }

        $hash = password_hash($motDePasse, PASSWORD_BCRYPT);
        $ok = $this->utilisateurModel->create($nom, $prenom, $email, $hash, $adresse);

        if (!$ok) {
            return ['erreur' => 'Erreur lors de l’inscription.', 'succes' => ''];
        }

        return ['erreur' => '', 'succes' => 'Inscription réussie ! Vous pouvez vous connecter.'];
    }

    public function connexion(string $email, string $motDePasse): array
    {
        $user = $this->utilisateurModel->findByEmail(trim($email));

        if (!$user || !password_verify($motDePasse, $user['mot_de_passe'])) {
            return ['erreur' => 'Email ou mot de passe incorrect.', 'redirect' => null];
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];
        setcookie("dernier_visiteur", $user['prenom'], time() + 60 * 60 * 24 * 30, "/", "", 0);

        if ($user['role'] === 'admin') {
            return ['erreur' => '', 'redirect' => '../back/dashboard.php'];
        }

        return ['erreur' => '', 'redirect' => '../index.php'];
    }

    public function getUserById(int $id): ?array
    {
        return $this->utilisateurModel->getById($id);
    }

    public function updateProfil(int $id, array $data): array
    {
        $nom = trim($data['nom'] ?? '');
        $prenom = trim($data['prenom'] ?? '');
        $adresse = trim($data['adresse'] ?? '');

        if ($nom === '' || $prenom === '') {
            return ['erreur' => 'Nom et prénom obligatoires.', 'succes' => ''];
        }

        $ok = $this->utilisateurModel->updateProfil($id, $nom, $prenom, $adresse);
        if (!$ok) {
            return ['erreur' => 'Erreur lors de la mise à jour du profil.', 'succes' => ''];
        }

        $_SESSION['user_nom'] = $nom;
        return ['erreur' => '', 'succes' => 'Profil mis à jour !'];
    }

    public function passerCommande(int $userId, array $data): array
    {
        $produitId = (int) ($data['produit_id'] ?? 0);
        $quantite = (int) ($data['quantite'] ?? 0);
        $adresse = trim($data['adresse'] ?? '');

        if ($produitId < 1 || $quantite < 1 || $adresse === '') {
            return ['erreur' => 'Veuillez remplir tous les champs.', 'succes' => ''];
        }

        $this->pdo->beginTransaction();
        try {
            $okStock = $this->produitModel->decrementStock($produitId, $quantite);
            if (!$okStock) {
                $this->pdo->rollBack();
                return ['erreur' => 'Stock insuffisant pour ce produit.', 'succes' => ''];
            }

            $okCmd = $this->commandeModel->create($userId, $produitId, $quantite, $adresse);
            if (!$okCmd) {
                $this->pdo->rollBack();
                return ['erreur' => 'Erreur lors de la commande.', 'succes' => ''];
            }

            $this->pdo->commit();
            return ['erreur' => '', 'succes' => '✅ Commande passée avec succès !'];
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return ['erreur' => 'Erreur lors de la commande.', 'succes' => ''];
        }
    }

    public function getMesCommandes(int $userId): array
    {
        return $this->commandeModel->getByUserId($userId);
    }
}
?>
