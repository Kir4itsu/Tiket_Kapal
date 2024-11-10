<?php
include "connection.php";

$id = "";
$nama = "";
$nama_kapal = "";
$tanggal = "";
$waktu = "";
$tujuan_pemberangkatan = "";
$deskripsi = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Mengambil data tiket yang akan diedit
    $sql = "SELECT * FROM tiket WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $nama_kapal = $row['nama_kapal'];
        $tanggal = $row['tanggal'];
        $waktu = $row['waktu'];
        $tujuan_pemberangkatan = $row['tujuan_pemberangkatan'];
        $deskripsi = $row['deskripsi'];
    } else {
        header("Location: home.php?status=not_found");
        exit();
    }
    $stmt->close();
}

// Proses update data
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nama_kapal = $_POST['nama_kapal'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $tujuan_pemberangkatan = $_POST['tujuan_pemberangkatan'];
    $deskripsi = $_POST['deskripsi'];
    
    $sql = "UPDATE tiket SET nama=?, nama_kapal=?, tanggal=?, waktu=?, tujuan_pemberangkatan=?, deskripsi=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nama, $nama_kapal, $tanggal, $waktu, $tujuan_pemberangkatan, $deskripsi, $id);
    
    if ($stmt->execute()) {
        header("Location: home.php?status=updated");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating record: " . $conn->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tiket Kapal</title>
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
                        <a class="nav-link" href="create.php">
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
                                <i class="fas fa-edit me-2"></i>Edit Tiket Kapal
                            </h3>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Penumpang
                                </label>
                                <input type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-ship me-1"></i>Nama Kapal
                                </label>
                                <input type="text" name="nama_kapal" value="<?php echo htmlspecialchars($nama_kapal); ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="far fa-calendar-alt me-1"></i>Tanggal Keberangkatan
                                </label>
                                <input type="date" name="tanggal" value="<?php echo $tanggal; ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="far fa-clock me-1"></i>Waktu Keberangkatan
                                </label>
                                <input type="time" name="waktu" value="<?php echo $waktu; ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>Tujuan
                                </label>
                                <input type="text" name="tujuan_pemberangkatan" value="<?php echo htmlspecialchars($tujuan_pemberangkatan); ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Deskripsi
                                </label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn btn-success me-2" type="submit" name="submit">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
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