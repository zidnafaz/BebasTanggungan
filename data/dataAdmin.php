<?php  
include '../login.php';
include '../koneksi.php';

try {
    $sql = "SELECT id_karyawan, nama_karyawan, nomor_telfon_karyawan, alamat_karyawan, tanggal_lahir_karyawan, jenis_kelamin_karyawan 
    FROM dbo.admin a
    WHERE a.id_karyawan = ?";

    session_start(); 
    
    if (isset($_COOKIE['id'])) {
        $inputUsername = $_COOKIE['id'];
    } else {
        die("Anda harus login terlebih dahulu.");
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
        echo "Data tidak ditemukan.";
        $resultUser = null; // Pastikan $result diset null jika data tidak ditemukan
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>