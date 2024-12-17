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
        case 'data_alumni':
            $sqlUpdate = "UPDATE data_alumni SET status_pengumpulan_data_alumni = ?, keterangan_pengumpulan_data_alumni = ? WHERE nim = ?";
            break;
        case 'skkm':
            $sqlUpdate = "UPDATE skkm SET status_pengumpulan_skkm = ?, keterangan_pengumpulan_skkm = ? WHERE nim = ?";
            break;
        case 'foto_ijazah':
            $sqlUpdate = "UPDATE foto_ijazah SET status_pengumpulan_foto_ijazah = ?, keterangan_pengumpulan_foto_ijazah = ? WHERE nim = ?";
            break;
        case 'ukt':
            $sqlUpdate = "UPDATE ukt SET status_pengumpulan_ukt = ?, keterangan_pengumpulan_ukt = ? WHERE nim = ?";
            break;
        default:
            // Jika jenis berkas tidak dikenali
            exit('Jenis berkas tidak valid');
    }        

    $stmt = sqlsrv_prepare($conn, $sqlUpdate, [$statusVerifikasi, $keterangan, $nim]);

    $sqlTanggal = "UPDATE dbo.adminPusat_konfirmasi SET tanggal_adminPusat_konfirmasi = GETDATE() WHERE nim = ?";
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
