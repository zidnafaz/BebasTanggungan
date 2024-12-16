<?php
session_start();
require_once '../Koneksi.php';

$db = new Koneksi();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi ID dari cookie
    if (!isset($_SESSION['id'])) {
        header("Location: ../index.html");
        exit();
    }

    $id = htmlspecialchars($_SESSION['id']); // Amankan data dari cookie

    // Mendapatkan direktori dari input hidden
    $uploadDir = '../Documents/Uploads/' . htmlspecialchars($_POST['uploadDir']);
    $uploadDir = rtrim($uploadDir, '/'); // Pastikan tidak ada trailing slash

    // Tentukan tabel berdasarkan direktori
    $tableMap = [
        'data_alumni' => 'data_alumni',
        'skkm' => 'skkm',
        'foto_ijazah' => 'foto_ijazah',
        'ukt' => 'ukt',
        'penyerahan_hardcopy' => 'penyerahan_hardcopy',
        'tugas_akhir_softcopy' => 'tugas_akhir_softcopy',
        'bebas_pinjam_buku_perpustakaan' => 'bebas_pinjam_buku_perpustakaan',
        'hasil_kuisioner' => 'hasil_kuisioner',
        'penyerahan_skripsi' => 'penyerahan_skripsi',
        'penyerahan_pkl' => 'penyerahan_pkl',
        'toeic' => 'toeic',
        'bebas_kompen' => 'bebas_kompen',
        'penyerahan_kebenaran_data' => 'penyerahan_kebenaran_data',
        'publikasi_jurnal' => 'publikasi_jurnal',
        'aplikasi' => 'aplikasi',
        'skripsi' => 'skripsi'
    ];

    $directoryLabel = basename($uploadDir);
    $tableName = isset($tableMap[$directoryLabel]) ? $tableMap[$directoryLabel] : null;

    if (!$tableName) {
        echo "Nama tabel tidak valid.";
        exit;
    }

    // Validasi file
    $allowedExtensions = ['pdf'];
    $maxFileSize = 2 * 1024 * 1024; // Default: 2 MB

    if ($directoryLabel === 'skripsi') {
        $allowedExtensions = ['pdf'];
        $maxFileSize = 20 * 1024 * 1024; // 20 MB
    } elseif ($directoryLabel === 'aplikasi') {
        $allowedExtensions = ['zip', 'rar'];
        $maxFileSize = 100 * 1024 * 1024; // 100 MB
    }

    $originalFileName = basename($_FILES["file"]["name"]);
    $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $fileSize = $_FILES["file"]["size"];

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "Tipe file tidak diizinkan. Hanya diperbolehkan: " . implode(', ', $allowedExtensions) . ".";
        exit;
    }

    if ($fileSize > $maxFileSize) {
        echo "Ukuran file terlalu besar. Maksimal: " . ($maxFileSize / (1024 * 1024)) . " MB.";
        exit;
    }

    // Buat direktori jika belum ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Buat nama file baru
    $newFileName = $id . '_' . $directoryLabel . '.' . $fileExtension;

    // Tentukan path lengkap untuk menyimpan file
    $target_file = $uploadDir . '/' . $newFileName;

    // Cek apakah sudah ada file dengan nama yang sama (tanpa melihat ekstensi)
    $existingFile = glob($uploadDir . '/' . $id . '_' . $directoryLabel . '.*'); // Menangkap semua file dengan NIM + directoryLabel

    // Jika file dengan NIM + directoryLabel sudah ada, hapus file lama dan simpan file baru
    if ($existingFile) {
        // Hapus file lama
        foreach ($existingFile as $file) {
            if (!unlink($file)) {
                echo "Gagal menghapus file lama.";
                exit;
            }
        }
    }

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        // Jika upload ke penyerahan_hardcopy, insert judul_tugas_akhir dan update status
        if ($directoryLabel === 'penyerahan_hardcopy') {
            $judulTugasAkhir = htmlspecialchars($_POST['judul_tugas_akhir']);

            if (strlen($judulTugasAkhir) > 200) {
                echo "Judul tugas akhir tidak boleh lebih dari 200 karakter.";
                exit;
            }

            // Update status pengumpulan tugas akhir menjadi 'pending'
            $updateSql = "UPDATE penyerahan_hardcopy
                          SET status_pengumpulan_penyerahan_hardcopy = 'pending', 
                              keterangan_pengumpulan_penyerahan_hardcopy = 'Menunggu Proses Verifikasi',
                              judul_tugas_akhir = ?
                          WHERE nim = ?";
            $params = [$judulTugasAkhir, $id];
            $updateStmt = sqlsrv_query($conn, $updateSql, $params);
            if ($updateStmt === false) {
                echo 'Gagal memperbarui status pengumpulan.';
                exit;
            }
        } else {
            // Update status untuk tabel lainnya
            $sql = "UPDATE {$tableName} 
                    SET status_pengumpulan_{$directoryLabel} = 'pending', 
                        keterangan_pengumpulan_{$directoryLabel} = 'Menunggu Proses Verifikasi' 
                    WHERE nim = ?";
            $params = [$id];

            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                echo 'Gagal memperbarui status di database.';
                exit;
            }
        }

        echo 'File berhasil diupload.';
    } else {
        echo 'Gagal mengupload file.';
    }
} else {
    echo "Tidak ada file yang diupload.";
}
?>