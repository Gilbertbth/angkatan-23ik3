<?php
require_once 'config.php';
requireLogin();

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

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM parfum WHERE id = ?");
        $stmt->execute([$id]);
        
        header('Location: dashboard.php?message=deleted');
        exit();
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Parfum - Sistem Parfum</title>
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
                <h2>Hapus Parfum</h2>
                <div class="actions">
                    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="delete-confirmation">
                <div class="warning-box">
                    <h3>⚠️ Konfirmasi Penghapusan</h3>
                    <p>Apakah Anda yakin ingin menghapus parfum berikut ini?</p>
                    
                    <div class="parfum-details">
                        <h4><?php echo htmlspecialchars($parfum['nama_parfum']); ?></h4>
                        <p><strong>Merk:</strong> <?php echo htmlspecialchars($parfum['merk']); ?></p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($parfum['jenis_kelamin']); ?></p>
                        <p><strong>Ukuran:</strong> <?php echo htmlspecialchars($parfum['ukuran']); ?></p>
                        <p><strong>Harga:</strong> <?php echo formatCurrency($parfum['harga']); ?></p>
                        <p><strong>Stok:</strong> <?php echo $parfum['stok']; ?></p>
                        <?php if ($parfum['deskripsi']): ?>
                            <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($parfum['deskripsi']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="warning-text">
                        <p><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Data parfum akan dihapus secara permanen.</p>
                    </div>

                    <form method="POST" action="" class="delete-form">
                        <div class="form-actions">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">Ya, Hapus Parfum</button>
                            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>