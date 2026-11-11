CREATE DATABASE IF NOT EXISTS pawhome CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pawhome;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

DROP TABLE IF EXISTS animals;
CREATE TABLE animals (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('dog','cat') NOT NULL,
    age VARCHAR(30) NOT NULL,
    description VARCHAR(255) NOT NULL,
    image_url VARCHAR(500) NOT NULL
) ENGINE=InnoDB;

INSERT INTO animals (name, type, age, description, image_url) VALUES
('Max',  'dog', '2 жас',  'Мейірімді және ойнақы',        'https://images.unsplash.com/photo-1552053831-71594a27632d?w=600'),
('Luna', 'cat', '1 жас',   'Нәзік және байсалды',         'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=600'),
('Rex',  'dog', '3 жас',  'Ақылды және белсенді',        'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600'),
('Mia',  'cat', '8 ай', 'Қызығушыл және жылы','https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=600');
