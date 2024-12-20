<?php
session_start();
require_once '../Koneksi.php';

// Inisialisasi koneksi
$db = new Koneksi();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $statusVerifikasi = $_POST['status_verifikasi'];
    $keterangan = $_POST['keterangan'];
    $jenisBerkas = $_POST['jenis_berkas'];

    // Tentukan nama kolom dan tabel yang sesuai berdasarkan jenis berkas
    switch ($jenisBerkas) {
        case 'publikasi_jurnal':
            $sqlUpdate = "UPDATE publikasi_jurnal SET status_pengumpulan_publikasi_jurnal = ?, keterangan_pengumpulan_publikasi_jurnal = ? WHERE nim = ?";
            break;
        case 'aplikasi':
            $sqlUpdate = "UPDATE aplikasi SET status_pengumpulan_aplikasi = ?, keterangan_pengumpulan_aplikasi = ? WHERE nim = ?";
            break;
        case 'skripsi':
            $sqlUpdate = "UPDATE skripsi SET status_pengumpulan_skripsi = ?, keterangan_pengumpulan_skripsi = ? WHERE nim = ?";
            break;
        default:
            // Jika jenis berkas tidak dikenali
            exit('Jenis berkas tidak valid');
    }

    $stmt = sqlsrv_prepare($conn, $sqlUpdate, [$statusVerifikasi, $keterangan, $nim]);

    $sqlTanggal = "UPDATE dbo.adminlt7_konfirmasi SET tanggal_adminlt7_konfirmasi = GETDATE() WHERE nim = ?";
    $params2 = [$nim];

    $stmt2 = sqlsrv_query($conn, $sqlTanggal, $params2);

    // Menyiapkan dan mengeksekusi query
    if ($stmt && $stmt2) {
        sqlsrv_execute($stmt);
        sqlsrv_execute($stmt2);
        header("Location: detail_mahasiswa.php?nim=" . urlencode($nim));
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Status berhasil diperbarui!'];
    } else {
        header("Location: detail_mahasiswa.php?nim=" . urlencode($nim));
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Terjadi kesalahan saat mengupdate status'];
    }
}
?>
