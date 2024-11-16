<?php
include 'koneksi.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // Query untuk memeriksa username dan password
        $sql = "SELECT status FROM dbo.login WHERE username = ? AND password = ?";
        $params = array($inputUsername, $inputPassword);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
        }

        // Memeriksa apakah ada hasil
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Pengalihan berdasarkan status
            if ($row['status'] === 'adminlt7') {
                header("Location: adminLt7.html");
            } elseif ($row['status'] === 'adminlt6') {
                header("Location: adminLt6.html");
            } elseif ($row['status'] === 'mahasiswa') {
                header("Location: mahasiswa.html");
            } else {
                echo "Status tidak dikenal.";
            }
            exit;
        } else {
            // Jika username/password tidak cocok
            echo "Username atau password salah.";
        }

        // Menutup statement
        sqlsrv_free_stmt($stmt);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
