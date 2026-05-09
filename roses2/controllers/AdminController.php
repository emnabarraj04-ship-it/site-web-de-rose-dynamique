<?php
require_once __DIR__ . '/../classes/connexion.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../models/Commande.php';

class AdminController
{
    private const DEFAULT_EMOJI = '🌹';
    private Utilisateur $utilisateurModel;
    private Produit $produitModel;
    private Commande $commandeModel;

    public function __construct()
    {
        global $pdo;
        $this->utilisateurModel = new Utilisateur($pdo);
        $this->produitModel = new Produit($pdo);
        $this->commandeModel = new Commande($pdo);
    }

    public function getDashboardStats(): array
    {
        return [
            'nb_p' => $this->produitModel->countAll(),
            'nb_u' => $this->utilisateurModel->countClients(),
            'nb_c' => $this->commandeModel->countAll(),
        ];
    }

    public function getUsers(): array
    {
        return $this->utilisateurModel->getAll();
    }

    public function getProduits(): array
    {
        return $this->produitModel->getAll();
    }

    public function supprimerProduit(int $id): bool
    {
        return $this->produitModel->delete($id);
    }

    public function ajouterProduit(array $data): array
    {
        $nom = trim($data['nom'] ?? '');
        $description = trim($data['description'] ?? '');
        $prix = (float) ($data['prix'] ?? 0);
        $stock = (int) ($data['stock'] ?? 0);
        $image = trim($data['image'] ?? self::DEFAULT_EMOJI);

        if ($nom === '' || $prix <= 0) {
            return ['erreur' => 'Nom et prix obligatoires.'];
        }

        $ok = $this->produitModel->create($nom, $description, $prix, $stock, $image !== '' ? $image : self::DEFAULT_EMOJI);
        return ['erreur' => $ok ? '' : 'Erreur lors de l’ajout du produit.'];
    }

    public function updateProduit(int $id, array $data): array
    {
        $nom = trim($data['nom'] ?? '');
        $description = trim($data['description'] ?? '');
        $prix = (float) ($data['prix'] ?? 0);
        $stock = (int) ($data['stock'] ?? 0);
        $image = trim($data['image'] ?? self::DEFAULT_EMOJI);

        if ($nom === '' || $prix <= 0) {
            return ['erreur' => 'Nom et prix obligatoires.'];
        }

        $ok = $this->produitModel->update($id, $nom, $description, $prix, $stock, $image !== '' ? $image : self::DEFAULT_EMOJI);
        return ['erreur' => $ok ? '' : 'Erreur lors de la modification du produit.'];
    }

    public function getProduitById(int $id): ?array
    {
        return $this->produitModel->getById($id);
    }

    public function getCommandes(): array
    {
        return $this->commandeModel->getAllWithRelations();
    }
}
?>
