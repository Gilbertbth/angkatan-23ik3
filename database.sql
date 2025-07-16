-- Database: sistem_parfum
CREATE DATABASE IF NOT EXISTS sistem_parfum;
USE sistem_parfum;

-- Tabel untuk admin/user
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk parfum
CREATE TABLE IF NOT EXISTS parfum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_parfum VARCHAR(100) NOT NULL,
    merk VARCHAR(50) NOT NULL,
    jenis_kelamin ENUM('Pria', 'Wanita', 'Unisex') NOT NULL,
    ukuran VARCHAR(20) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@parfum.com');

-- Insert sample parfum data
INSERT INTO parfum (nama_parfum, merk, jenis_kelamin, ukuran, harga, stok, deskripsi) VALUES 
('Bleu de Chanel', 'Chanel', 'Pria', '100ml', 1500000, 25, 'Parfum pria dengan aroma segar dan maskulin'),
('Chanel No.5', 'Chanel', 'Wanita', '50ml', 1800000, 15, 'Parfum wanita klasik dengan aroma bunga yang elegan'),
('Sauvage', 'Dior', 'Pria', '100ml', 1400000, 30, 'Parfum pria dengan aroma segar dan berani'),
('J\'adore', 'Dior', 'Wanita', '100ml', 1600000, 20, 'Parfum wanita dengan aroma bunga yang mewah'),
('CK One', 'Calvin Klein', 'Unisex', '200ml', 800000, 40, 'Parfum unisex dengan aroma segar dan modern');