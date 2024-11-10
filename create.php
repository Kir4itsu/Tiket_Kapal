<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tiket Kapal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .card-header {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border-radius: 15px 15px 0 0 !important;
        }
        .btn {
            border-radius: 25px;
            padding: 8px 20px;
        }
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php
    include "connection.php";
    
    if(isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $nama_kapal = $_POST['nama_kapal'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];
        $tujuan = $_POST['tujuan_pemberangkatan'];
        $deskripsi = $_POST['deskripsi'];
        
        $sql = "INSERT INTO tiket (nama, nama_kapal, tanggal, waktu, tujuan_pemberangkatan, deskripsi) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nama, $nama_kapal, $tanggal, $waktu, $tujuan, $deskripsi);
        
        if($stmt->execute()) {
            header("Location: home.php?status=success");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        
        $stmt->close();
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-ship me-2"></i>Sistem Tiket Kapal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="create.php">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Tiket
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form method="post" action="">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-white text-center mb-0">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Tiket Kapal Baru
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Penumpang
                                </label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-ship me-1"></i>Nama Kapal
                                </label>
                                <input type="text" name="nama_kapal" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="far fa-calendar-alt me-1"></i>Tanggal Keberangkatan
                                </label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="far fa-clock me-1"></i>Waktu Keberangkatan
                                </label>
                                <input type="time" name="waktu" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Tujuan
                                </label>
                                <input type="text" name="tujuan_pemberangkatan" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Deskripsi
                                </label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan detail tambahan seperti kelas kapal, fasilitas, dll" required></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn-success me-2" type="submit" name="submit">
                                    <i class="fas fa-save me-1"></i>Simpan Tiket
                                </button>
                                <a class="btn btn-secondary" href="home.php">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>