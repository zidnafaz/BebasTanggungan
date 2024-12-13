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
    $sql = "UPDATE dbo.publikasi_jurnal
            SET status_pengumpulan_publikasi_jurnal = ?, keterangan_pengumpulan_publikasi_jurnal = ?
            WHERE nim = ?";
    $params = [$statusVerifikasi, $keterangan, $nim];

    // Mengeksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    $sqlTanggal = "UPDATE dbo.adminlt7_konfirmasi SET tanggal_adminlt7_konfirmasi = GETDATE() WHERE nim = ?";
    $params2 = [$nim];

    $stmt2 = sqlsrv_query($conn, $sqlTanggal, $params2);

    if ($stmt&&$stmt2) {
        header("Location: ../publikasi_jurnal.php?message=Status+berhasil+diperbarui!&type=success");
        exit();
    } else {
        // Cek apakah ada error dari SQL Server
        $errors = sqlsrv_errors();
        echo json_encode(['success' => false, 'error' => $errors ? $errors : 'Unknown error dah masuk sini']);
    }
    
}
?>
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
    $sql = "UPDATE dbo.publikasi_jurnal
            SET status_pengumpulan_publikasi_jurnal = ?, keterangan_pengumpulan_publikasi_jurnal = ?
            WHERE nim = ?";
    $params = [$statusVerifikasi, $keterangan, $nim];

    $stmt = sqlsrv_query($conn, $sql, $params);

    $sqlTanggal = "UPDATE dbo.adminlt7_konfirmasi SET tanggal_adminlt7_konfirmasi = GETDATE() WHERE nim = ?";
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
    $previousUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../publikasi_jurnal.php';

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
