CREATE DATABASE IF NOT EXISTS roses_db;
USE roses_db;

CREATE TABLE produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    prix DECIMAL(8,2),
    stock INT,
    image VARCHAR(100)
);

CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    adresse TEXT,
    role ENUM('client','admin') DEFAULT 'client'
);

CREATE TABLE commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    produit_id INT,
    quantite INT,
    adresse TEXT,
    date_cmd DATETIME DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES utilisateur(id),
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

-- Admin (mot de passe : password)
INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role) VALUES
('Admin', 'Super', 'admin@roses.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Produits
INSERT INTO produit (nom, description, prix, stock, image) VALUES
('Rose Rouge',       'La rose rouge classique, symbole d amour.',       5.00, 50, '🌹'),
('Rose Blanche',     'Douce et élégante, parfaite pour toutes occasions.', 4.50, 40, '🤍'),
('Rose Rose',        'Tendre et romantique, idéale pour offrir.',        4.00, 60, '🌸'),
('Bouquet 12 Roses', 'Un magnifique bouquet de 12 roses rouges.',       45.00, 20, '💐'),
('Rose Jaune',       'Symbole d amitié et de joie.',                     4.00, 35, '🌼'),
('Bouquet Mixte',    'Un mélange coloré de toutes les couleurs.',        38.00, 15, '🌺');
