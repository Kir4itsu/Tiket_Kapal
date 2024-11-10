<?php
include "connection.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Cek apakah record exists
    $check_sql = "SELECT id FROM tiket WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if($check_result->num_rows > 0){
        $sql = "DELETE FROM tiket WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()){
            header("Location: home.php?status=deleted");
            exit();
        } else {
            header("Location: home.php?status=error");
            exit();
        }
    } else {
        header("Location: home.php?status=not_found");
        exit();
    }
    
    $check_stmt->close();
    $stmt->close();
} else {
    header("Location: home.php");
    exit();
}

$conn->close();
?>

// Tambahkan connection.php yang lebih aman
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "penjadwalan_tiket";

try {
    $conn = new mysqli($servername, $username, $password, $db_name);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset ke utf8mb4 untuk mendukung semua karakter
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }
    
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
?>