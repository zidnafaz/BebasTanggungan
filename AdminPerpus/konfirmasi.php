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
        case 'penyerahan_hardcopy':
            $sqlUpdate = "UPDATE penyerahan_hardcopy SET status_pengumpulan_penyerahan_hardcopy = ?, keterangan_pengumpulan_penyerahan_hardcopy = ? WHERE nim = ?";
            break;
        case 'tugas_akhir_softcopy':
            $sqlUpdate = "UPDATE tugas_akhir_softcopy SET status_pengumpulan_tugas_akhir_softcopy = ?, keterangan_pengumpulan_tugas_akhir_softcopy = ? WHERE nim = ?";
            break;
        case 'bebas_pinjam_buku_perpustakaan':
            $sqlUpdate = "UPDATE bebas_pinjam_buku_perpustakaan SET status_pengumpulan_bebas_pinjam_buku_perpustakaan = ?, keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan = ? WHERE nim = ?";
            break;
        case 'hasil_kuisioner':
            $sqlUpdate = "UPDATE hasil_kuisioner SET status_pengumpulan_hasil_kuisioner = ?, keterangan_pengumpulan_hasil_kuisioner = ? WHERE nim = ?";
            break;
        default:
            // Jika jenis berkas tidak dikenali
            exit('Jenis berkas tidak valid');
    }       

    $stmt = sqlsrv_prepare($conn, $sqlUpdate, [$statusVerifikasi, $keterangan, $nim]);

    $sqlTanggal = "UPDATE dbo.adminPerpus_konfirmasi SET tanggal_adminPerpus_konfirmasi = GETDATE() WHERE nim = ?";
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
