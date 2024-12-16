<?php
require_once 'Koneksi.php';

$db = new Koneksi();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password
    $sql = "SELECT status, username FROM [dbo].[login] WHERE username = ? AND password = ?";
    $params = array($username, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
    }

    // Memeriksa apakah ada hasil
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Pastikan cookie 'nim' diset sebelum header
        session_start();
        $_SESSION['id'] = $row['username'];

        // Pengalihan berdasarkan status
        switch ($row['status']) {
            case 'adminLt7':
                header("Location: AdminLt7/home.php");
                break;
            case 'adminLt6':
                header("Location: AdminLt6/home.php");
                break;
            case 'adminPusat':
                header("Location: AdminPusat/home.php");
                break;
            case 'adminPerpus':
                header("Location: AdminPerpus/home.php");
                break;
            case 'mahasiswa':
                header("Location: Mahasiswa/home.php");
                break;
            default:
                echo "<script>alert('Status tidak dikenal');</script>";
                break;
        }
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Username atau password salah!']);
    }

    // Menutup statement
    sqlsrv_free_stmt($stmt);
}
?>