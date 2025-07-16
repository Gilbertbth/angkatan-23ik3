<?php
require_once 'config.php';
requireLogin();

$success = '';
$error = '';

// Get perfume ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: dashboard.php');
    exit();
}

// Get perfume data
$stmt = $pdo->prepare("SELECT * FROM parfum WHERE id = ?");
$stmt->execute([$id]);
$parfum = $stmt->fetch();

if (!$parfum) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_parfum = trim($_POST['nama_parfum']);
    $merk = trim($_POST['merk']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $ukuran = trim($_POST['ukuran']);
    $harga = trim($_POST['harga']);
    $stok = trim($_POST['stok']);
    $deskripsi = trim($_POST['deskripsi']);
    
    // Validation
    if (empty($nama_parfum) || empty($merk) || empty($jenis_kelamin) || empty($ukuran) || empty($harga) || empty($stok)) {
        $error = 'Semua field wajib diisi kecuali deskripsi';
    } elseif (!is_numeric($harga) || $harga <= 0) {
        $error = 'Harga harus berupa angka positif';
    } elseif (!is_numeric($stok) || $stok < 0) {
        $error = 'Stok harus berupa angka non-negatif';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE parfum SET nama_parfum = ?, merk = ?, jenis_kelamin = ?, ukuran = ?, harga = ?, stok = ?, deskripsi = ? WHERE id = ?");
            $stmt->execute([$nama_parfum, $merk, $jenis_kelamin, $ukuran, $harga, $stok, $deskripsi, $id]);
            $success = 'Parfum berhasil diperbarui';
            
            // Update parfum array for display
            $parfum['nama_parfum'] = $nama_parfum;
            $parfum['merk'] = $merk;
            $parfum['jenis_kelamin'] = $jenis_kelamin;
            $parfum['ukuran'] = $ukuran;
            $parfum['harga'] = $harga;
            $parfum['stok'] = $stok;
            $parfum['deskripsi'] = $deskripsi;
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parfum - Sistem Parfum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Sistem Informasi Parfum</h1>
            <div class="user-info">
                <span>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </header>

        <nav class="navigation">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="add_parfum.php" class="nav-link">Tambah Parfum</a>
        </nav>

        <main class="main-content">
            <div class="content-header">
                <h2>Edit Parfum</h2>
                <div class="actions">
                    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="" class="parfum-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_parfum">Nama Parfum *</label>
                            <input type="text" id="nama_parfum" name="nama_parfum" value="<?php echo htmlspecialchars($parfum['nama_parfum']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="merk">Merk *</label>
                            <input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars($parfum['merk']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin *</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Gender</option>
                                <option value="Pria" <?php echo $parfum['jenis_kelamin'] == 'Pria' ? 'selected' : ''; ?>>Pria</option>
                                <option value="Wanita" <?php echo $parfum['jenis_kelamin'] == 'Wanita' ? 'selected' : ''; ?>>Wanita</option>
                                <option value="Unisex" <?php echo $parfum['jenis_kelamin'] == 'Unisex' ? 'selected' : ''; ?>>Unisex</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ukuran">Ukuran *</label>
                            <input type="text" id="ukuran" name="ukuran" value="<?php echo htmlspecialchars($parfum['ukuran']); ?>" placeholder="contoh: 100ml, 50ml" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="harga">Harga (Rp) *</label>
                            <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($parfum['harga']); ?>" min="0" step="1000" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="stok">Stok *</label>
                            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($parfum['stok']); ?>" min="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi parfum (opsional)"><?php echo htmlspecialchars($parfum['deskripsi']); ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Parfum</button>
                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>