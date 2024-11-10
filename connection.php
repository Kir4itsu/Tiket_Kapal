<?php
// Konfigurasi Database
$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'penjadwalan_tiket',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci'
];

// Fungsi untuk membuat koneksi database
function createConnection($config) {
    try {
        // Buat koneksi dengan error handling
        $conn = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database']
        );

        // Cek koneksi
        if ($conn->connect_error) {
            throw new Exception("Koneksi database gagal: " . $conn->connect_error);
        }

        // Set charset
        if (!$conn->set_charset($config['charset'])) {
            throw new Exception("Error setting charset: " . $conn->error);
        }

        // Set timezone untuk database
        $conn->query("SET time_zone = '+07:00'");

        return $conn;
    } catch (Exception $e) {
        // Log error (in production, you should use proper logging)
        error_log("Database Error: " . $e->getMessage());
        
        // Show user-friendly error message
        die("Maaf, terjadi kesalahan pada sistem. Silakan coba beberapa saat lagi.");
    }
}

// Buat koneksi
$conn = createConnection($db_config);

// Fungsi untuk membersihkan input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk menutup koneksi dengan aman
function closeConnection($conn) {
    if ($conn instanceof mysqli) {
        $conn->close();
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function(function() use ($conn) {
    closeConnection($conn);
});

// Error handling untuk mode development
// Hapus atau komentari baris di bawah ini saat di production
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);