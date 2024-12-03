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

    // Cek apakah keterangan dikirim atau tidak, jika tidak maka set default "-"
    $keterangan = isset($_POST['keterangan']) && $_POST['keterangan'] !== '' ? $_POST['keterangan'] : '-';

    // Query untuk update status
    $sql = "UPDATE dbo.toeic
            SET status_pengumpulan_toeic = ?, keterangan_pengumpulan_toeic = ?
            WHERE nim = ?";
    $params = [$statusVerifikasi, $keterangan, $nim];

    // Mengeksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        // Redirect setelah update berhasil
        header("Location: ../toeic.php?message=Status+berhasil+diperbarui!&type=success");
        exit(); // Pastikan eksekusi script berhenti setelah redirect
    } else {
        // Jika query gagal, tampilkan error
        echo json_encode(['success' => false, 'error' => sqlsrv_errors()]);
    }
}
?>
