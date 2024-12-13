<?php
include '../../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = isset($_POST['nim']) ? $_POST['nim'] : null;
    $nim2 = isset($_GET['nim']) ? $_GET['nim'] : null;

    // Pastikan status verifikasi terpilih
    if (!isset($_POST['status_verifikasi'])) {
        $_SESSION['message'] = ['type' => 'error', 'content' => 'Status verifikasi tidak dipilih.'];
        redirectToUpload($nim2);
    }

    $statusVerifikasi = $_POST['status_verifikasi'];

    // Validasi keterangan jika status verifikasi 'ditolak'
    if ($statusVerifikasi === 'ditolak' && ($_POST['keterangan'] === '' || !isset($_POST['keterangan']))) {
        $_SESSION['message'] = ['type' => 'error', 'content' => 'Keterangan wajib diisi jika status verifikasi ditolak.'];
        redirectToUpload($nim2);
    }

    // Jika keterangan tidak dikirim, set default "-"
    $keterangan = isset($_POST['keterangan']) && $_POST['keterangan'] !== '' ? $_POST['keterangan'] : '-';

    // Query untuk update status
    $sql = "UPDATE dbo.penyerahan_pkl
            SET status_pengumpulan_penyerahan_pkl = ?, keterangan_pengumpulan_penyerahan_pkl = ?
            WHERE nim = ?";
    $params = [$statusVerifikasi, $keterangan, $nim];

    $stmt = sqlsrv_query($conn, $sql, $params);

    $sqlTanggal = "UPDATE dbo.adminlt6_konfirmasi SET tanggal_adminlt6_konfirmasi = GETDATE() WHERE nim = ?";
    $params2 = [$nim];

    $stmt2 = sqlsrv_query($conn, $sqlTanggal, $params2);

    if ($stmt && $stmt2) {
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Status berhasil diperbarui!'];
    } else {
        $errors = sqlsrv_errors();
        $_SESSION['message'] = ['type' => 'error', 'content' => $errors ? implode(', ', $errors) : 'Unknown error.'];
    }
    redirectToUpload($nim2);
}

/**
 * Helper function to redirect with or without nim
 */
function redirectToUpload($nim = null) {
    // Ambil URL sebelumnya jika tersedia
    $previousUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../pkl.php';

    // Tambahkan parameter nim jika ada
    if ($nim) {
        $urlParts = parse_url($previousUrl);
        parse_str($urlParts['query'] ?? '', $queryParams);
        $queryParams['nim'] = $nim; // Tetapkan NIM

        $previousUrl = $urlParts['path'] . '?' . http_build_query($queryParams);
    }

    header("Location: $previousUrl");
    exit();
}

?>
