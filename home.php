<?php
// Include security headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; script-src 'self' https://cdn.jsdelivr.net;");

require_once "connection.php";

// Fungsi untuk escape output
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Ambil data tiket dengan prepared statement
$sql = "SELECT * FROM tiket ORDER BY tanggal ASC, waktu ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if(!$result) {
    die("Error in query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem pemesanan tiket kapal online yang aman dan terpercaya">
    <title>Sistem Tiket Kapal - Pemesanan Tiket Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            --secondary-gradient: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            --accent-color: #6dd5ed;
            --shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        body {
            background-color: #f0f8ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: var(--primary-gradient);
            padding: 1rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card {
            box-shadow: var(--shadow);
            border-radius: 15px;
            background: white;
            margin-bottom: 2rem;
        }

        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: var(--secondary-gradient);
            color: white;
        }

        .table th {
            border: none;
            padding: 1rem;
            font-weight: 600;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .btn {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .action-buttons .btn {
            padding: 0.4rem 1rem;
            margin: 0 0.2rem;
        }

        .footer {
            margin-top: auto;
            background: var(--primary-gradient);
            color: white;
        }

        .empty-message {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .action-buttons {
                display: flex;
                gap: 0.5rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-ship me-2"></i>Sistem Tiket Kapal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-light" href="create.php">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Tiket
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">
                    <i class="fas fa-ticket-alt me-2"></i>Jadwal Tiket Kapal
                </h2>
                
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kapal</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Tujuan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= e($row['id']) ?></td>
                                            <td><?= e($row['nama']) ?></td>
                                            <td><?= date('d/m/Y', strtotime(e($row['tanggal']))) ?></td>
                                            <td><?= date('H:i', strtotime(e($row['waktu']))) ?></td>
                                            <td><?= e($row['tujuan_pemberangkatan']) ?></td>
                                            <td><?= e($row['deskripsi']) ?></td>
                                            <td class="action-buttons">
                                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?= e($row['id']) ?>"
                                                   title="Edit tiket">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="delete.php?id=<?= e($row['id']) ?>"
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');"
                                                   title="Hapus tiket">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-message">
                                            <i class="fas fa-info-circle me-2"></i>Belum ada data tiket tersedia
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer py-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5><i class="fas fa-ship me-2"></i>Tentang Kami</h5>
                    <p class="mb-3">Sistem Tiket Kapal menyediakan layanan pemesanan tiket kapal yang aman, mudah, dan terpercaya untuk berbagai rute pelayaran di Indonesia.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-angle-right me-2"></i>Cara Pemesanan
                        </a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-angle-right me-2"></i>Syarat & Ketentuan
                        </a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-angle-right me-2"></i>Kebijakan Privasi
                        </a></li>
                        <li><a href="#" class="text-white text-decoration-none">
                            <i class="fas fa-angle-right me-2"></i>FAQ
                        </a></li>
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <h5><i class="fas fa-phone-alt me-2"></i>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="https://github.com/Kir4itsu" target="_blank" 
                               class="text-white text-decoration-none">GitHub</a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>Kiraitsu
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <a href="https://github.com/Kir4itsu" target="_blank" 
                               class="text-white text-decoration-none">github.com/Kir4itsu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 pt-3 border-top">
            <p class="mb-0">&copy; <?= date('Y') ?> Sistem Tiket Kapal. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>