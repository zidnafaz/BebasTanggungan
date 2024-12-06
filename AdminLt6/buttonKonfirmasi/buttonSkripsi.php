<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];

    // Pastikan status verifikasi terpilih
    if (!isset($_POST['status_verifikasi'])) {
        echo json_encode(['success' => false, 'error' => 'Status verifikasi tidak dipilih.']);
        exit();
    }

    $statusVerifikasi = $_POST['status_verifikasi'];

    // Validasi keterangan jika status verifikasi 'tidak_terverifikasi'
    if ($statusVerifikasi === 'ditolak' && ($_POST['keterangan'] === '' || !isset($_POST['keterangan']))) {
        echo json_encode(['success' => false, 'error' => 'Keterangan wajib diisi jika status verifikasi ditolak.']);
        exit();
    }

    // Jika keterangan tidak dikirim, set default "-"
    $keterangan = isset($_POST['keterangan']) && $_POST['keterangan'] !== '' ? $_POST['keterangan'] : '-';

    // Query untuk update status
    $sql = "UPDATE dbo.penyerahan_skripsi
            SET status_pengumpulan_penyerahan_skripsi = ?, keterangan_pengumpulan_penyerahan_skripsi = ?
            WHERE nim = ?";
    $params = [$statusVerifikasi, $keterangan, $nim];

    // Mengeksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    $sqlTanggal = "UPDATE dbo.adminlt6_konfirmasi SET tanggal_adminlt6_konfirmasi = GETDATE() WHERE nim = ?";
    $params2 = [$nim];

    $stmt2 = sqlsrv_query($conn, $sqlTanggal, $params2);

    if ($stmt&&$stmt2) {
        header("Location: ../skripsi.php?message=Status+berhasil+diperbarui!&type=success");
        exit();
    } else {
        // Cek apakah ada error dari SQL Server
        $errors = sqlsrv_errors();
        echo json_encode(['success' => false, 'error' => $errors ? $errors : 'Unknown error dah masuk sini']);
    }
    
}
?>