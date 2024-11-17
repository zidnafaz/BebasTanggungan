<?php
include 'koneksi.php';

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
        setcookie('nim', $row['username'], time() + 3600, "/"); // Mengatur path cookie agar dapat diakses di seluruh aplikasi

        // Pengalihan berdasarkan status
        switch ($row['status']) {
            case 'adminlt7':
                header("Location: adminLt7.html");
                break;
            case 'adminlt6':
                header("Location: AdminLt6/home.html");
                break;
            case 'mahasiswa':
                header("Location: Mahasiswa/home.html");
                break;
            default:
                echo "Status tidak dikenal.";
                break;
        }
        exit;
    } else {
        // Jika username/password tidak cocok
        echo "Username atau password salah.";
    }

    // Menutup statement
    sqlsrv_free_stmt($stmt);
}
?>
