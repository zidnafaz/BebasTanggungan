<?php
include '../login.php';
include '../koneksi.php';

try {
    $sql = "SELECT * FROM dbo.mahasiswa WHERE nim = ?";

    session_start();

    if (isset($_COOKIE['id'])) {
        $inputUsername = $_COOKIE['id'];
    } else {
        header("Location: ../index.html");
        exit();
    }

    $param = array($inputUsername);
    $stmt = sqlsrv_query($conn, $sql, $param);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Tangani error query
    }

    // Ambil hasil query
    if (sqlsrv_has_rows($stmt)) {
        $resultUser = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); // Ambil data sebagai array asosiatif
    } else {
        header("Location: ../index.html");
        exit();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>