<?php
require_once 'config.php';
requireLogin();

// Get search parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_gender = isset($_GET['filter_gender']) ? $_GET['filter_gender'] : '';

// Build query
$query = "SELECT * FROM parfum WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (nama_parfum LIKE ? OR merk LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($filter_gender) {
    $query .= " AND jenis_kelamin = ?";
    $params[] = $filter_gender;
}

$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$parfums = $stmt->fetchAll();

// Get total count
$count_query = "SELECT COUNT(*) as total FROM parfum WHERE 1=1";
if ($search) {
    $count_query .= " AND (nama_parfum LIKE ? OR merk LIKE ?)";
}
if ($filter_gender) {
    $count_query .= " AND jenis_kelamin = ?";
}

$count_stmt = $pdo->prepare($count_query);
$count_stmt->execute($params);
$total_count = $count_stmt->fetch()['total'];

// Check for success message
$success_message = '';
if (isset($_GET['message']) && $_GET['message'] == 'deleted') {
    $success_message = 'Parfum berhasil dihapus';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Parfum</title>
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
            <a href="dashboard.php" class="nav-link active">Dashboard</a>
            <a href="add_parfum.php" class="nav-link">Tambah Parfum</a>
        </nav>

        <main class="main-content">
            <div class="content-header">
                <h2>Daftar Parfum</h2>
                <div class="actions">
                    <a href="add_parfum.php" class="btn btn-primary">Tambah Parfum Baru</a>
                </div>
            </div>

            <?php if ($success_message): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <!-- Search and Filter -->
            <div class="search-filter">
                <form method="GET" action="" class="search-form">
                    <input type="text" name="search" placeholder="Cari parfum atau merk..." value="<?php echo htmlspecialchars($search); ?>">
                    <select name="filter_gender">
                        <option value="">Semua Gender</option>
                        <option value="Pria" <?php echo $filter_gender == 'Pria' ? 'selected' : ''; ?>>Pria</option>
                        <option value="Wanita" <?php echo $filter_gender == 'Wanita' ? 'selected' : ''; ?>>Wanita</option>
                        <option value="Unisex" <?php echo $filter_gender == 'Unisex' ? 'selected' : ''; ?>>Unisex</option>
                    </select>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    <a href="dashboard.php" class="btn btn-secondary">Reset</a>
                </form>
            </div>

            <div class="stats">
                <p>Total parfum: <?php echo $total_count; ?></p>
            </div>

            <!-- Perfume Table -->
            <div class="table-container">
                <table class="parfum-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Parfum</th>
                            <th>Merk</th>
                            <th>Gender</th>
                            <th>Ukuran</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($parfums)): ?>
                            <tr>
                                <td colspan="9" class="no-data">Tidak ada data parfum</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($parfums as $index => $parfum): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($parfum['nama_parfum']); ?></td>
                                    <td><?php echo htmlspecialchars($parfum['merk']); ?></td>
                                    <td><?php echo htmlspecialchars($parfum['jenis_kelamin']); ?></td>
                                    <td><?php echo htmlspecialchars($parfum['ukuran']); ?></td>
                                    <td><?php echo formatCurrency($parfum['harga']); ?></td>
                                    <td><?php echo $parfum['stok']; ?></td>
                                    <td class="description"><?php echo htmlspecialchars(substr($parfum['deskripsi'], 0, 50)) . '...'; ?></td>
                                    <td class="actions">
                                        <a href="edit_parfum.php?id=<?php echo $parfum['id']; ?>" class="btn btn-small btn-primary">Edit</a>
                                        <a href="delete_parfum.php?id=<?php echo $parfum['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus parfum ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>