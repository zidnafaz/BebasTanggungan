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
        case 'penyerahan_skripsi':
            $sqlUpdate = "UPDATE penyerahan_skripsi SET status_pengumpulan_penyerahan_skripsi = ?, keterangan_pengumpulan_penyerahan_skripsi = ? WHERE nim = ?";
            break;
        case 'penyerahan_pkl':
            $sqlUpdate = "UPDATE penyerahan_pkl SET status_pengumpulan_penyerahan_pkl = ?, keterangan_pengumpulan_penyerahan_pkl = ? WHERE nim = ?";
            break;
        case 'toeic':
            $sqlUpdate = "UPDATE toeic SET status_pengumpulan_toeic = ?, keterangan_pengumpulan_toeic = ? WHERE nim = ?";
            break;
        case 'bebas_kompen':
            $sqlUpdate = "UPDATE bebas_kompen SET status_pengumpulan_bebas_kompen = ?, keterangan_pengumpulan_bebas_kompen = ? WHERE nim = ?";
            break;
        case 'penyerahan_kebenaran_data':
            $sqlUpdate = "UPDATE penyerahan_kebenaran_data SET status_pengumpulan_penyerahan_kebenaran_data = ?, keterangan_pengumpulan_penyerahan_kebenaran_data = ? WHERE nim = ?";
            break;
        default:
            // Jika jenis berkas tidak dikenali
            exit('Jenis berkas tidak valid');
    }    

    $stmt = sqlsrv_prepare($conn, $sqlUpdate, [$statusVerifikasi, $keterangan, $nim]);

    $sqlTanggal = "UPDATE dbo.adminlt6_konfirmasi SET tanggal_adminlt6_konfirmasi = GETDATE() WHERE nim = ?";
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
